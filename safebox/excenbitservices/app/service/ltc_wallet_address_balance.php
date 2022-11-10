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
______________________________  ltc update balance v1.0 16/06/2020 id=43_____________________________
*/
//_____________________________________________________________ UPDATE BALANCE ALL WALLETS__________________________________________________________________

    $where = "fk_currency_id = '$fk_currency_id' AND ti_active = '1' LIMIT 10";
    $result_array = _sqlselectall('wallet',$where,null,DB_CONNECTION_LOCAL,2);    
    if (!$result_array){
        //nothing
        $service_msg = "no wallets to update";
        
    }else{
        foreach($result_array as $key=>$val) {   
            //consulto o numero de endereços para cada carteira            
            $wallet_id = $result_array[$key]['wallet_id'];
            $address = $result_array[$key]['v_address'];
            //$guid = $result_array[$key]['v_guid'];             
            $result = ltc_get_balance_address($address);
            if (!$result)
            {
                $service_msg = "error: ". " function getting balance". " line:". __LINE__;//max 255 characters
                $service_status = "error";
            }else{//ok
            
                    
                $curr_balance = $result;//já convertido para ltc
                              
                $sql = "UPDATE wallet SET db_previous_balance = '$curr_balance', db_current_balance = '$curr_balance'WHERE wallet_id = '$wallet_id'";               
                $result = _sqlexecute($sql,DB_CONNECTION_LOCAL,2);
                if ($result) {
                    //ok   
                    
                } else {
                    $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                    $service_status = "error";
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