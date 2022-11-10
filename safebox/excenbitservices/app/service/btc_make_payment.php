<?php
//_________________________________DEFAULT SERVICE TEST_________________________________________
// !!! dont put echo or print here!
try{
    $service_status = "ok";//default ok
    $service_msg = "";
       
    //______________________________________________________________________________________________
    
    $dt1	= new DateTime(gmdate("Y-m-d H:i:s"));
    $dt = $dt1->format('Y-m-d H:i:s');//converto para string
    $dt_dma = $dt1->format('Y-m-d');//converto para string
    $coinlabel = 'btc';
    $fk_currency_id = '3';
    
    /** 
______________________________  btc make payment v1.1 21/06/2020 id=25 _____________________________
*/


//_____________________________________________________________ SOURCE WALLET BALANCE__________________________________________________________________
    $where = "fk_currency_id = '$fk_currency_id' AND ti_users_wallet = '0' AND ti_active ='1'";
    $result_array = _sqlselectall('wallet',$where,null,DB_CONNECTION_LOCAL,2);    
    if (!$result_array){
        //nothing
        $service_msg = "no w wallet found";
        $service_status = "error";
        return false;
    }else{
        $dest_wallet = $result_array[0]['v_address'];//first wallet found                      
        $wallet_id = $result_array[0]['wallet_id'];
        $guid = $result_array[0]['v_guid']; 
        $encript_pwd = $result_array[0]['v_pass'];
        $wallet_balance = $result_array[0]['db_current_balance'];
        $wallet_balance = $wallet_balance - 0.0002;
        $sql = "SELECT SUM(db_amount) as total FROM (SELECT db_amount FROM trans_withdrawal WHERE fk_currency_id = '$fk_currency_id' AND ti_processed = '0' LIMIT 3) as tb1";
        $result = _sqlexecute($sql);
        if(!$result){
            $service_msg = "error: ". "sql SUM". " line:". __LINE__;//max 255 characters
            $service_status = "error";
            return false; 
        }else{          
            $total = $result[0]['total'];
            if ($total >= $wallet_balance){
                //nothing
                $service_msg = "enough funds";//max 255 characters
                $service_status = "error";
                return true;
            }else{
                //ok
            }    

        }
    }
    

//_____________________________________________________________ VERIFY TRANSACTIONS__________________________________________________________________

    $sql = "SELECT * FROM trans_withdrawal WHERE fk_currency_id = '$fk_currency_id' AND ti_processed = '0' LIMIT 30";
    
        $where = "fk_currency_id = '$fk_currency_id' AND ti_processed = '0' LIMIT 30";
        $result_array2 = _sqlselectall('trans_withdrawal',$where);    
        if (!$result_array2){
            //nothing            
           
        }else{
            foreach($result_array2 as $key=>$val) { 
            $trans_id = $result_array2[$key]['trans_id'];          
            $v_address = $result_array2[$key]['v_address'];
            $value = $result_array2[$key]['db_amount'];        
            //convert to satoshi
            $value = btc_to_satoshi($value);
            
            $recipients[$v_address] = $value;
            $recipients_result[$trans_id] = $v_address;

            
        }
    

        //_____________________________________________________________ CREATE JSON OBJECT __________________________________________________________________

        $json_obj = json_encode($recipients);


        //_____________________________________________________________ SEND MANY __________________________________________________________________
        $txid = "";
        $secret_key = _ex_get_param("kww",1);        
        $pwd = encrypt_decrypt('decrypt',$encript_pwd,$secret_key);
        $fee = btc_to_satoshi(0.0002);
        //$fee = "";        
        $json_result = btc_sendmany($guid,$pwd,$fee,$json_obj);
       
        if (!$json_result){
        //_____________________________________________________________ UPDATE RESULTS NOK__________________________________________________________________    
           
            foreach($recipients_result as $key => $value) {        
                $data_array = array(
                    'si_status' => '4',                       
                    'ti_processed' => '1',
                    'ti_txconfirmed' => '0',
                    'dt_processed_date' => $dt,
                    );
                $result = _sqlupdate('trans_withdrawal',$data_array,"trans_id = '$key'");                
                if (!$result) {
                    $service_msg = "error: ". "update nok". " line:". __LINE__;
                    $service_status = "error";
                    return false;
                } else {
                    
                }  
            } 
            $service_msg = "error: ". "btc_sendmany". " line:". __LINE__;
            $service_status = "error";
            return false;
        }else{
                    //__________________________________________________ UPDATE RESULTS OK__________________________________________________________________
            $txid = $json_result['tx_hash'];
              
            foreach($recipients_result as $key => $value) {        
                $data_array = array(
                    'si_status' => '2',                       
                    'ti_processed' => '1',
                    'ti_txconfirmed' => '1',
                    'v_txid' => $txid,
                    'dt_processed_date' => $dt,
                    );
                $result = _sqlupdate('trans_withdrawal',$data_array,"trans_id = '$key'");                
                if (!$result) {
                    $service_msg = "error: ". "update nok". " line:". __LINE__;
                    $service_status = "error";
                    return false;
                } else {
                    
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