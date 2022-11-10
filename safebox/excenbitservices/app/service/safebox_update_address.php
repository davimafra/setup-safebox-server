<?php

//_________________________________DEFAULT SERVICE TEST_________________________________________
// !!! dont put echo or print here!
try{
    $service_status = "ok";//default if not ok
    $service_msg = "";
    $required_actions = 10;
    $count_actions = 0;
    
    //______________________________________________________________________________________________
    
    $dt	= new DateTime(gmdate("Y-m-d H:i:s"));
    $dt = $dt->format('Y-m-d H:i:s');//converto para string
    /** 
    ______________________________  safebox update all address v1.1 23/06/2020 id=22_____________________________
    */

    //_______________________________________________________ GET REQUEST TO UPDATE AN ADDRESS__________________________________________________________________

    $where = "fk_user_id IS NOT NULL AND ti_active = '1' AND ti_needs_update = '1' LIMIT 100";
    $result_array = _sqlselectall('user_addr',$where);    
    if (!$result_array){
        //nothing
        $service_msg = "no address to update";
         
    }else{
        if(!isset($conn)){
            require (DB_CONNECTION);
        }
        $sql = "UPDATE user_addr SET ti_needs_update = '0' WHERE $where";

        $result = mysqli_query($conn, $sql);	
        if ($result){	
            //ok		
        }else{		
            //nok	
        }

        foreach($result_array as $key=>$val) {   
                    
            $fk_currency_id = $result_array[$key]['fk_currency_id'];
            $address = $result_array[$key]['v_addr'];
            $result = _sqlsetval('address','ti_needs_update','1',"v_addr = '$address' AND",DB_CONNECTION_LOCAL,2);
            if ($result) {                        
                //ok
            } else {
                $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                $service_status = "error";        
            }              
            
        }
    }



    //_____________________________________________________________ SEND NEW ADDRESS__________________________________________________________________

    //seleciono todos nao usados
    
    
    $where = "fk_user_id IS NULL AND ti_sent = '0'";//nao usa where pq faz para todos    
    $result_array = _sqlselectall('address',null,null,DB_CONNECTION_LOCAL,2);
    if (!$result_array){
        //nothing
        $service_msg = "no addresses to send";//max 255 characters
        $service_status = "ok"; 
    }else{
        if(!isset($conn)){
            require (DB_CONNECTION);
        }
        
        foreach($result_array as $key=>$val) {
           
            $address = $result_array[$key]['v_addr'];                  
            $data_array = array(
            'v_addr' => $result_array[$key]['v_addr'],
            'fk_wallet_id' => $result_array[$key]['fk_wallet_id'],
            'fk_address_id' => $result_array[$key]['address_id'],
            'fk_currency_id' => $result_array[$key]['fk_currency_id'],
            );
            $sql  = "INSERT INTO user_addr";
            $sql .= " (".implode(", ", array_keys($data_array)).")";
            $sql .= " VALUES ('".implode("', '", $data_array)."') ON DUPLICATE KEY UPDATE v_addr = '$address';";
            
            $result = _sqlexecute($sql);
            if ($result) {                        
                //ok
                } else {
                $service_msg = "error: ". "sql insert". " line:". __LINE__;//max 255 characters
                $service_status = "error";        
                } 
            $result = _sqlsetval('address','ti_sent','1',"v_addr = '$address'",DB_CONNECTION_LOCAL,2);    
            
            if ($result) {                        
                //ok
                } else {
                $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                $service_status = "error";        
                }     
            }
    }


    //_____________________________________________________________ UPDATE INFO NEW USED ADDRESS__________________________________________________________________
    
    $result_array2 = _sqlselectall('user_addr',"fk_user_id IS NOT NULL AND ti_updated = '0'");//REMOTE  
    if (!$result_array2){
        //nothing
        $service_msg = "no address to update";//max 255 characters
                      
        
    }else{
        if(!isset($conn2)){
            require (DB_CONNECTION_LOCAL);
        }
        foreach($result_array2 as $key=>$val) {               
            $user_id = $result_array2[$key]['fk_user_id'];
            $user_email = $result_array2[$key]['v_email'];
            $address = $result_array2[$key]['v_addr'];
            $fk_currency_id = $result_array2[$key]['fk_currency_id'];             
            $sql = "UPDATE address SET fk_user_id = '$user_id', fk_user_email = '$user_email' WHERE v_addr = '$address' AND fk_currency_id = '$fk_currency_id';";
            if (mysqli_query($conn2, $sql)) {//sucessfully updated
                $service_msg = "";//max 255 characters
                $service_status = "ok";
                $result = _sqlsetval('user_addr','ti_updated','1',"v_addr = '$address' AND fk_currency_id = '$fk_currency_id'");
                if ($result) {                        
                        //ok 
                    } else {
                        $service_msg = "error: ". "sql update". " line:". __LINE__;//max 255 characters
                        $service_status = "error";        
                    } 

                }else{
                    $service_msg = "error: ". "update sql". " line:". __LINE__;//max 255 characters
                    $service_status = "error";
                }
        
        }


    }

    //_____________________________________________________________ UPDATE INACTIVE ADDRESS__________________________________________________________________
    $result_array3 = _sqlselectall('user_addr',"ti_active = '0' AND ti_updated = '0'");//REMOTE    
    $result = mysqli_query($conn,$sql);
    if (!$result_array){
        //nothing
        $service_msg = "no address to update";//max 255 characters
                         
        
    }else{
        if(!isset($conn2)){
            require (DB_CONNECTION_LOCAL);
        }
        foreach($result_array3 as $key=>$val) {              
            $address = $result_array3[$key]['v_addr'];
            $fk_currency_id = $result_array2[$key]['fk_currency_id'];
            $sql = "UPDATE address SET ti_active = '0', ti_updated = '1' WHERE v_addr = '$address' AND fk_currency_id = '$fk_currency_id';";
            if (mysqli_query($conn2, $sql)) {//sucessfully updated
                
                }else{
                    $service_msg = "error: ". "update sql". " line:". __LINE__;//max 255 characters
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








