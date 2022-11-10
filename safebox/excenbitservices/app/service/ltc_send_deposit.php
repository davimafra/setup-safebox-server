<?php

//_________________________________DEFAULT SERVICE TEST_________________________________________
// !!! dont put echo or print here!
try{
    $service_status = "ok";//default if not ok
    $service_msg = "";
       
    //______________________________________________________________________________________________
    
    $dt	= new DateTime(gmdate("Y-m-d H:i:s"));
    $dt = $dt->format('Y-m-d H:i:s');//converto para string


    /** 
______________________________  ltc send deposit v1.0 id=44_____________________________
*/

//_____________________________________________________________ VERIFY RCV VALUES__________________________________________________________________

$currency_id = '4';
$where = "fk_user_id IS NOT NULL AND (db_total_rcv <> db_total_rcv_prev OR ti_needs_update = '1') AND fk_currency_id = '$currency_id' LIMIT 10";
$result_array = _sqlselectall('address',$where,null,DB_CONNECTION_LOCAL,2);

if (!$result_array){
    //nothing
    $service_msg = "no addresses to send";//max 255 characters
     
            
    
}else{
    
    
    foreach($result_array as $key=>$val) {       
          
        $address = $result_array[$key]['v_addr'];
        $fk_wallet_id = $result_array[$key]['fk_wallet_id'];
        $address_id = $result_array[$key]['address_id'];
        $fk_user_id = $result_array[$key]['fk_user_id'];
        $fk_currency_id  = $result_array[$key]['fk_currency_id'];        
        $number_txs  = $result_array[$key]['si_number_txs'];
        $total_rcv = $result_array[$key]['db_total_rcv'];
        $latesttx = $result_array[$key]['v_last_txid'];
        //get all txs from table and this address
        $where = "fk_address_id = '$address_id' AND fk_currency_id = '$fk_currency_id'";  //usar sempre a combinacao address id + currency id
        $arr_existents_txs = _sqlselectall('trans_deposit',$where,null);
        $tx_number_txs = '0';
        
        $json_result = ltc_rawaddr($address);
        if ($json_result == false){
            //no transactions found
            
            
            $result = _sqlsetval('address','ti_needs_update','0',"address_id = '$address_id'",DB_CONNECTION_LOCAL,2);
            if ($result) {                        
                    //ok 
                } else {
                    $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                    $service_status = "error";        
                }  
        }else{//ok
            //update current address
            $total_rcv = $json_result['data'] ['received_value']; 
            $total_balance = $json_result['data'] ['balance'];           
            $tx_number_txs = $json_result['data'] ['total_txs'];
            $need_new_update = '0';//sinaliza se precisa de nova atualizacao

                foreach($json_result['data']['txs']as $item) {
                    if (isset($item['incoming']['value'])){//se for trans recebida
                        $tx_value_rcv = $item['incoming']['value'];
                        $tx_confirms = $item['confirmations'];                    
                        $txid = $item['txid'];
                        
                        //se houve transacao de depositos         
                     
                            //insert into cada tx de saida
                            //checo as variaveis da tx de saida:
                            if ($tx_confirms > 3) {
                                $ti_confirmed = '1';
                                $data_array2 = array(
                                    'v_txid' => $txid,
                                    'db_amount' => $tx_value_rcv,
                                    'ti_txconfirmed' => $ti_confirmed,
                                    'fk_currency_id' => $fk_currency_id,
                                    'fk_user_id' => $fk_user_id,
                                    'fk_address_id' => $address_id,                                
                                    'v_addr' => $address,
                                    'i_confirms' => $tx_confirms,
                                );
                                $existe = false;
                                //verifico se existem já existem txs na tabela
                                if (isset($arr_existents_txs)){
                                    foreach ($arr_existents_txs as $key => $value) {                                        
                                        if ($arr_existents_txs[$key]['v_txid'] == $txid){
                                            $existe = true;
                                            break;
                                        }
                                    }
                               
                                }

                                if (!$existe){ 
                                    //$result = _sqlinsert('trans_deposit',$data_array2);  //insert new transactions 
                                    $sql  = "INSERT INTO trans_deposit";
                                    $sql .= " (".implode(", ", array_keys($data_array2)).")";
                                    $sql .= " VALUES ('".implode("', '", $data_array2)."') ON DUPLICATE KEY UPDATE v_txid= '$txid';";
                                    
                                    $result = _sqlexecute($sql);                 
                                    if ($result) {                        
                                        //ok 
                                        } else {
                                            $service_msg = "error: ". "sql insert". " line:". __LINE__;//max 255 characters
                                            $service_status = "error";        
                                        } 
                                }else
                                {  
                                    //exists txid    
                                }
                            }else{
                                $ti_confirmed = '0';//não enviar txs não confirmadas
                                $need_new_update = '1';//sinaliza se precisa de nova atualizacao
                                $tx_number_txs = $number_txs; //não atualiza txs enquanto houver pendentes
                            }
                            
                    }
                    
                }                              
                            
                //aumentou o numero de transações
                $data_array2 = array(
                    'db_current_balance' => $total_balance,
                    'db_total_rcv_prev' => $total_rcv,
                    'db_total_rcv' => $total_rcv,
                    'si_number_txs' => $tx_number_txs,
                    'ti_needs_update' => $need_new_update,
                    
                    ); 
                            
                $result = _sqlupdate('address',$data_array2,"address_id = '$address_id';",DB_CONNECTION_LOCAL,2);
                
                if ($result) {//sucessfully updated
                    //ok  
                }else{
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