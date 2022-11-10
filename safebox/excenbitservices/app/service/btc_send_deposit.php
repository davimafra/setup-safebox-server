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
______________________________  safebox send deposit v1.1 19/06/2020 ID=24_____________________________
*/

//_____________________________________________________________ VERIFY RCV VALUES__________________________________________________________________

$currency_id = '3';
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
        //get all txs from table and this address
        $where = "fk_address_id = '$address_id' AND fk_currency_id = '$fk_currency_id'";  //usar sempre a combinacao address id + currency id
        $arr_existents_txs = _sqlselectall('trans_deposit',$where,null);

        if ($number_txs > 12){
            $latesttx = 50;
        }else{
            $latesttx = "";
        }
        $json_result = btc_rawaddr($address,$latesttx);
        if ($json_result == false){
            //no transactions found
            $tx_number_txs = '0';
            
            $data_array2 = array(
                'db_total_rcv' => $total_rcv,                        
                'db_total_rcv_prev' => $total_rcv, 
                'si_number_txs' => $tx_number_txs,
                'ti_needs_update' => '0',
                
                ); 
                     
            $result = _sqlupdate('address',$data_array2,"address_id = '$address_id';",DB_CONNECTION_LOCAL,2);
            
            if ($result) {                        
                   //ok 
                } else {
                    $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                    $service_status = "error";
                    return false;        
                }  
        }else{//ok
            
                      
            $tx_number_txs = $json_result['data']['total_count']; 
            if ($tx_number_txs == $number_txs){
                //nao houve alterações no numero de transacoes entaõ nao faço nada e continua atualizando até aparecer
            }else{

                    $need_new_update = '0';//sinaliza se precisa de nova atualizacao
                    foreach($json_result['data']['list']as $item) {
                        $tx_value_rcv = 0;
                        $tx_confirms = $item['confirmations'];
                    
                        $tx_block =  $item['block_height'];
                        
                        $txid = $item['hash'];
                                
                        foreach($item['inputs'] as $subitem1) {
                            foreach($subitem1['prev_addresses'] as $subitem11) {
                                if ($subitem11 == $address){
                                    
                                    $tx_value_send =  $subitem1['prev_value'];
                                    $tx_value_send = satoshi_to_btc($tx_value_send);
                                }
                            }                    
                        }

                        foreach($item['outputs'] as $subitem2) {
                            foreach($subitem2['addresses'] as $subitem22) {
                                if ($subitem22 == $address){
                                                                
                                    $tx_value_rcv = $subitem2['value'];
                                    $tx_value_rcv = satoshi_to_btc($tx_value_rcv);
                                } 
                            }                   
                        }
                        if ($tx_value_rcv == '0'){

                        }else{   //se houve transacao de depositos         
                        
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
                                'i_block' => $tx_block,
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
                                        return false;       
                                        } 
                                    
                                }else
                                {  
                                    //exists txid
                                                           
                                                        
                                }


                            }else{
                                $ti_confirmed = '0';
                                $need_new_update = '1';//sinaliza se precisa de nova atualizacao
                            }
                            
                        }

                    }   
            }
            if ($need_new_update == '1'){//prepara para nova atualização para tentar confirmar a tx
                $tx_number_txs = $number_txs;
            }else{
                
            }
           
            $data_array2 = array(
            'db_total_rcv' => $total_rcv,                        
            'db_total_rcv_prev' => $total_rcv, 
            'si_number_txs' => $tx_number_txs,
            'ti_needs_update' => $need_new_update,                        
            ); 
                     
            $result = _sqlupdate('address',$data_array2,"address_id = '$address_id';",DB_CONNECTION_LOCAL,2);                    
            if ($result) {//sucessfully updated
                //ok  
            }else{
                $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                $service_status = "error";
                return false; 

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