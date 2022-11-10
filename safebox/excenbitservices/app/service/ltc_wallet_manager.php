<?php
//_________________________________DEFAULT SERVICE TEST_________________________________________
// !!! dont put echo or print here!
try{
    $service_status = "ok";//default if not ok
    $service_msg = "";
       
    //______________________________________________________________________________________________
    
    $dt	= new DateTime(gmdate("Y-m-d H:i:s"));
    $dt = $dt->format('Y-m-d H:i:s');//converto para string

    $coinlabel = 'ltc';
    $fk_currency_id = '4';


        /** 
    ______________________________  ltc wallet manager v1.0 16/06/2020 id=45_____________________________
    */

    //_____________________________________________________________ VERIFY PARAMETERS__________________________________________________________________
    $min_unused_address = _ex_get_param("ltc_min_unused_address",2);
    $min_unused_address = 2;
    $needs_new_address = false;
    //verifico se há necessidade de criar mais address

    $where = "fk_user_id IS NULL AND fk_currency_id = '$fk_currency_id' AND ti_active = '1'";//I find total of unusedaddress
    $result = _sqlcount('address',$where,DB_CONNECTION_LOCAL,2);

    if (!isset($result)){
        $service_msg = "error: ". "sqlcount". " line:". __LINE__;//max 255 characters
        $service_status = "error";
    }else{
        if ($result < $min_unused_address){
            $needs_new_address = true;
        }
       
        //ok
    }

    if ($needs_new_address){
        $n_new_addr = 2;//create new 10 address to ltc  
        //_____________________________________________________________ CREATE X NEW ADDRESSES__________________________________________________________________
        
        //$api_code = get_apicode_btc();
        for ($i = 1; $i <= $n_new_addr; $i++) { //create x addresses
            $json_result = ltc_create_wallet();
            if (!$json_result){
                $service_msg = "error: ". "creating address". " line:". __LINE__;//max 255 characters
                $service_status = "error";
            }else{//ok          
                
                $privkey = $json_result['data']['Privkey']; 
                $address = $json_result['data']['Pubkey']; 
                $secret_key = "default#pwd";        
                $pwd = encrypt_decrypt('encrypt',$privkey,$secret_key);   
                $data_array = array(
                'v_addr' => $address,
                'v_priv_key' => $pwd,
                'v_coinlabel' => $coinlabel,
                'ti_active' => '1',                
                'fk_currency_id' => $fk_currency_id,
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

     //_____________________________________________________________ TRANSFER FROM ADDRESS TO W WALLET__________________________________________________________________




//select destination wallet
    $w_address = _sqlgetval('wallet','v_address',"fk_currency_id = '$fk_currency_id' AND ti_active = '1' AND ti_users_wallet = '0'",DB_CONNECTION_LOCAL,2);       
    if (!$w_address){
        //nothing
        $service_msg = "no w wallets";
        $service_status = "error";  
    }else{
       
        //1- transfer all when the balance is grather than 0.1 LTC or balance > 0.001 and last update > 30 days
        $where = "(fk_currency_id = '$fk_currency_id' AND ti_active ='1' AND ti_needs_update = '0') AND (db_current_balance > '0.1' OR (db_current_balance > 0.001 AND dt_last_update < date_sub(now(), interval 1 month))) LIMIT 10";
        
        $result_array3 = _sqlselectall('address',$where,null,DB_CONNECTION_LOCAL,2);    
        if (!$result_array3){
            //nothing
            
            
        }else{
            foreach($result_array3 as $key=>$val) {  
                $address_id = $result_array3[$key]['address_id'];
                $address = $result_array3[$key]['v_addr'];
                $enc_privkey = $result_array3[$key]['v_priv_key'];
                $secret_key = "default#pwd";       
                $privkey = encrypt_decrypt('decrypt',$enc_privkey,$secret_key);                
                $fee = 100000;
                $result = ltc_sendall($w_address,$privkey,$fee);
                if(!$result){
                    $service_msg = "error ltc_sendall";
                    $service_status = "error";  

                }else{
                    $sql = "UPDATE address SET db_current_balance = '0' WHERE v_addr = '$address' AND fk_currency_id = '$fk_currency_id'";               
                    $result = _sqlexecute($sql,DB_CONNECTION_LOCAL,2);
                    if (!$result) {
                        $service_msg = "error: ". "sql update". " line:". __LINE__;
                        $service_status = "error";        
                        
                    } else {

                       
                        
                    }  


                }



            }

        }


    }
    

//____________________________________________________________________
return true;
} catch (\Throwable $th) {
    $service_status = "error";
    $service_msg = "error: ". "exception". " file: ". __FILE__;
}

?>