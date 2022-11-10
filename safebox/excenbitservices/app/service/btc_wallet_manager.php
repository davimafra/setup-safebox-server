<?php
//_________________________________DEFAULT SERVICE _________________________________________
// !!! dont put echo or print here!
try{
    $service_status = "ok";//default if not ok
    $service_msg = "";
       
    //______________________________________________________________________________________________
    
    $dt1	= new DateTime(gmdate("Y-m-d H:i:s"));
    $dt = $dt1->format('Y-m-d H:i:s');//converto para string
    $dt_dma = $dt1->format('Y-m-d');//converto para string
    $coinlabel = 'btc';
    $fk_currency_id = '3';


    /** 
    ______________________________  btc wallet manager v1.1 19/06/2020 id=21_____________________________
    */


    //_____________________________________________________________ VERIFY PARAMETERS__________________________________________________________________
    $min_unused_address = _ex_get_param("btc_min_unused_address",2);
   
    $max_address = _ex_get_param("btc_max_addr_wallet",2);   
    $wallet_id_to_create = '';
    $needs_new_address = false;
    $needs_new_wallet = false;
    //verifico se há necessidade de criar mais address
    
    $where = "fk_user_id IS NULL AND fk_currency_id = '$fk_currency_id' AND ti_active = '1'";//I find total of unusedaddress
    $result = _sqlcount('address',$where,DB_CONNECTION_LOCAL,2);
    if (!isset($result)){
       
        $service_msg = "error: ". "sql count". " line:". __LINE__;//max 255 characters
        
    }else{
        if ($result < $min_unused_address){
            $needs_new_address = true;
        }
       
        //ok
    }

    if ($needs_new_address){
        
        //_____________________________________________________________ select wallet to create address__________________________________________________________________
        // verifico qual carteira serao criados os address

       
        $needs_new_wallet = true;
        $where = "fk_currency_id = '$fk_currency_id' AND ti_users_wallet = '1' AND ti_active ='1'";
        $result_array = _sqlselectall('wallet',$where,null,DB_CONNECTION_LOCAL,2);    
        if (!$result_array){
            //nothing            
            $needs_new_wallet = true; 
        }else{
            foreach($result_array as $key=>$val) {
                //consulto o numero de endereços para cada carteira            
                $wallet_id = $result_array[$key]['wallet_id'];
                
                $result2 = _sqlcount('address',"fk_wallet_id = '$wallet_id'",DB_CONNECTION_LOCAL,2);
                if (!isset($result2)){
                    //error
                }else{
                    if ($result2 >= $max_address){//vai para a proxima
                        //carteiras cheias
                        
                    }else{
                        //carteira com poucos pode criar addresses
                        if ($wallet_id_to_create == ''){                
                            $wallet_id_to_create = $wallet_id;//pega dados para criar addresses
                            $guid = $result_array[$key]['v_guid']; 
                            //$encript_pwd = $result_array[$key]['v_pass'];
                            $needs_new_wallet = false;
                        }    
                    }            
                }     
            }       
        }

        if ($needs_new_wallet){                
            //precisa criar mais carteiras
        //_____________________________________________________________ CREATE NEW WALLET__________________________________________________________________
            $wallet_label = 'btc_deposit_wallet_'.$dt_dma;
            $pwd = 'btc_default_pwd';//default password for new wallets, antiga: btc_default_pwd
            $secret_key = 'default#pwd';        
            $encript_pwd = encrypt_decrypt('encrypt',$pwd,$secret_key);
            $api_code = get_apicode_btc();
            $json_result = btc_create_wallet($pwd,$api_code, $wallet_label);
            if (!$json_result){
                $service_msg = "error: ". "creating wallet". " line:". __LINE__;//max 255 characters
                $service_status = "error";
            }else{//ok            
                
                $guid = $json_result['guid'];
                $address = $json_result['address'];
                $label = $json_result['label']; 
                $data_array = array(
                    'v_address' => $address,
                    'v_pass' => $encript_pwd,
                    'v_guid' => $guid,
                    'v_label' => $label,                
                    'v_coinlabel' => $coinlabel,
                    'fk_currency_id' => $fk_currency_id,
                    'ti_users_wallet' => '1',
                    'ti_active' => '1',
                    );
                    
                $result = _sqlinsert('wallet', $data_array,DB_CONNECTION_LOCAL,2);
                if ($result) {
                //ok
                    
                } else {
                    $service_msg = "error: ". "sql insert". " line:". __LINE__;//max 255 characters
                    $service_status = "error";
                }
            }
        }   

        if (!$wallet_id_to_create == ''){ 
        //_____________________________________________________________ CREATE X NEW ADDRESSES__________________________________________________________________
            $n_new_addr = 2;//create new 10 address to btc 
            $pwd = 'btc_default_pwd';//default password for new wallets, antiga: btc_default_pwd
            $secret_key = 'default#pwd';        
            $encript_pwd = encrypt_decrypt('encrypt',$pwd,$secret_key);   
            
            //$api_code = get_apicode_btc();
            for ($i = 1; $i <= $n_new_addr; $i++) { //create x addresses
                $json_result = btc_create_address($guid,$pwd);
                if (!$json_result){
                    $service_msg = "error: ". "creating address". " line:". __LINE__;//max 255 characters
                    $service_status = "error";
                }else{//ok          
                    
                    $address = $json_result['address'];    
                   
                    $data_array = array(
                        'v_addr' => $address,      
                        'v_coinlabel' => $coinlabel,
                        'fk_currency_id' => $fk_currency_id,
                        'fk_wallet_id' => $wallet_id_to_create,                        
                        'ti_active' => '1',
                        );
                        
                    $result = _sqlinsert('address', $data_array,DB_CONNECTION_LOCAL,2);
                    if ($result) {
                    //ok
                         
                    } else {
                        $service_msg = "error: ". "sql insert". " line:". __LINE__;//max 255 characters
                        $service_status = "error";
                    }     
                }
            }                 

        }
    }


     //_____________________________________________________________ TRANSFER FROM D WALLET TO W WALLET__________________________________________________________________
     
     //get destination wallet
     $where = "fk_currency_id = '$fk_currency_id' AND ti_users_wallet = '0' AND ti_active ='1'";
     $result_array2 = _sqlselectall('wallet',$where,null,DB_CONNECTION_LOCAL,2);    
     if (!$result_array2){
         //nothing
         $service_msg = "no w wallet found";
         $service_status = "error";
     }else{
        $dest_wallet = $result_array2[0]['v_address'];//first wallet found
       //0.1 min
        $where = "(fk_currency_id = '$fk_currency_id' AND ti_users_wallet = '1' AND ti_active ='1') AND (db_current_balance > '0' OR (db_current_balance > 0.001 AND dt_last_update < date_sub(now(), interval 1 month))) LIMIT 10";
        $result_array3 = _sqlselectall('wallet',$where,null,DB_CONNECTION_LOCAL,2);    
        if (!$result_array3){
            //nothing
            
           
        }else{
            foreach($result_array3 as $key=>$val) {
                $wallet_id = $result_array3[$key]['wallet_id'];
                $balance = $result_array3[$key]['db_current_balance'];
                $prev_balance = $result_array3[$key]['db_previous_balance'];
                if ($prev_balance == $balance){//verify if needs update
                    $guid = $result_array3[$key]['v_guid'];
                    $encript_pwd = $result_array3[$key]['v_pass'];
                    $secret_key =_ex_get_param('kww',1);
                    $pwd = encrypt_decrypt('decrypt',$encript_pwd,$secret_key);
                    $balance = btc_to_satoshi($balance);
                    $fee = btc_to_satoshi(0.0002);
                    $amount = $balance - $fee;
                    //sendall                
                    $json_result = btc_send_payment($guid,$pwd,$amount,$fee,$dest_wallet);

                    if (!$json_result){
                        $service_msg = "error: ". "send payment to w wallet";
                        $service_status = "error";
                    }else{//ok 
                        $sql3 = "UPDATE wallet SET db_current_balance = '0' WHERE wallet_id = '$wallet_id'";
                        $result = _sqlexecute($sql3,DB_CONNECTION_LOCAL,2);
                        if ($result) {
                            
                            //ok      
                            
                        } else {
                            $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                            $service_status = "error";
                        }  

                    }
                }

            }
        }
    }

//____________________________________________________________________
return true;
} catch (\Throwable $th) {
    $service_status = "error";
    $service_msg = "exception";
}

?>