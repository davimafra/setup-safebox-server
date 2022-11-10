<?php
//_________________________________DEFAULT SERVICE ________________________________________
// !!! dont put echo or print here!
try{
    $service_status = "ok";//default if not ok
    $service_msg = "";
       
    //______________________________________________________________________________________________
    
    $dt	= new DateTime(gmdate("Y-m-d H:i:s"));
    $dt = $dt->format('Y-m-d H:i:s');//converto para string


    $coinlabel = 'btc';
    $fk_currency_id = '3';

    /** 
______________________________  btc update balance v1.1 id=23_____________________________
*/
//_____________________________________________________________ UPDATE BALANCE ALL WALLETS__________________________________________________________________

$where = "fk_currency_id = '$fk_currency_id' AND ti_active = '1'";//I find the wallets
$result_array = _sqlselectall('wallet',$where,null,DB_CONNECTION_LOCAL,2);
if (!$result_array){
    //nothing
    $service_msg = "no wallets found";//max 255 characters
       
}else{        
    foreach($result_array as $key=>$val) {  
            //consulto o numero de endereços para cada carteira            
            $wallet_id = $result_array[$key]['wallet_id'];
            $guid = $result_array[$key]['v_guid']; 
            $encript_pwd = $result_array[$key]['v_pass'];
            $users_wallet = $result_array[$key]['ti_users_wallet'];  //carteira de usuarios 

            $secret_key = _ex_get_param('kww',1);      
            $pwd = encrypt_decrypt('decrypt',$encript_pwd,$secret_key);
            $json_result = btc_get_balance_wallet($guid,$pwd);
            if ($json_result == false)
            {
                $service_msg = "error: ". " function getting balance". " line:". __LINE__;//max 255 characters
                $service_status = "error";
                return false;
            }else{//ok
            
                //estimative value only     
                $curr_balance = $json_result['balance'];
                $curr_balance = satoshi_to_btc($curr_balance);
                if ($users_wallet == '1'){
                    $data_array = array(
                        'db_current_balance' => $curr_balance, //coloca diferença de para atualizar os endereços 
                        ); 
                }else{//carteira de saques
                    $data_array = array(
                        'db_current_balance' => $curr_balance,                       
                        'db_previous_balance' => $curr_balance,
                        );
                }
                $result = _sqlupdate('wallet',$data_array,"wallet_id = '$wallet_id'",DB_CONNECTION_LOCAL,2);                
                if ($result) {
                    $service_msg = "";
                    $service_status = "ok";  
                } else {
                    $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                    $service_status = "error";
                    return false;
                }  
            }
        }
    }


//_____________________________________________________________ SELECT UPDATED USER WALLETS__________________________________________________________________


    $where = "fk_currency_id = '$fk_currency_id' AND ti_users_wallet = '1' AND ti_active = '1' AND db_previous_balance <> db_current_balance";//I find the wallets
    $result_array2 = _sqlselectall('wallet',$where,null,DB_CONNECTION_LOCAL,2);
    if (!$result_array2){
        //nothing
              
        
    }else{    
    
    foreach($result_array2 as $key=>$val) {  //atualiza balanço de todos os endereços da carteira
                
            $wallet_id = $result_array2[$key]['wallet_id'];
            $guid = $result_array2[$key]['v_guid']; 
            $encript_pwd = $result_array2[$key]['v_pass'];
            $secret_key = _ex_get_param("kww",1); //default#pwd       
            $pwd = encrypt_decrypt('decrypt',$encript_pwd,$secret_key);
            
            $arr_list_address = btc_list_address($guid,$pwd);
            if ($arr_list_address == false)
            {
                $service_msg = "error: ". " no address found". " line:". __LINE__;//max 255 characters
                
            }else{//ok
               
                foreach($arr_list_address['addresses'] as $item) {
                    
                    $address = $item['address'];                    
                    $curr_balance = $item['balance'];
                    $curr_balance = satoshi_to_btc($curr_balance);    
                    $total_rcv = $item['total_received'];
                    $total_rcv= satoshi_to_btc($total_rcv);                    
                    $data_array2 = array(
                        'db_current_balance' => $curr_balance,                       
                        'db_total_rcv' => $total_rcv,   //garante que será lido pelo serviço de envio                     
                        );
                   
                    $result = _sqlupdate('address',$data_array2,"v_addr = '$address'",DB_CONNECTION_LOCAL,2);
                
                    if ($result) {
                              
                        
                    } else {
                       //is wallet or not exists
                    }  
                }
            }

             //_____________________________________________ UPDATE WALLET WITH CURRENT BALANCE__________________________________________________________________
                                
                
            $sql3 = "UPDATE wallet SET db_previous_balance = db_current_balance WHERE wallet_id = '$wallet_id'";
            $result = _sqlexecute($sql3,DB_CONNECTION_LOCAL,2);
            if ($result) {
                //ok    
                
            } else {
                $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                $service_status = "error";
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