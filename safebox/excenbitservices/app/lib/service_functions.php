<?php


function _service_get_status($service_id) {
    if(!isset($conn)){
        require (DB_CONNECTION);
    }
    $cmdsql = "SELECT * FROM sys_service WHERE service_id = '$service_id'";
    $resultcmd = mysqli_query($conn, $cmdsql);
    
    if (!$resultcmd or mysqli_num_rows($resultcmd) == 0){  
        //not found 
        return false;
    }else
        {   //found
            $row = mysqli_fetch_assoc($resultcmd);
                           
            if ($row['v_status'] == 'ok'){
                //ok
                return true;
            }else{//nok
                return false;
            }
        }    
}

function _service_get_active($service_id) {
    if(!isset($conn)){
        require (DB_CONNECTION);
    }
    $cmdsql = "SELECT * FROM sys_service WHERE service_id = '$service_id'";
    $resultcmd = mysqli_query($conn, $cmdsql);
    
    if (!$resultcmd or mysqli_num_rows($resultcmd) == 0){  
        //not found 
        
    }else
        {   //founded
            $row = mysqli_fetch_assoc($resultcmd);
            $active = $row['ti_active'];                     
            if ($row['ti_active'] == '0'){
                //serviço inativo
                return false;
            }else{//serviço ativo
                return true;
            }
        }    
}

function _service_get_name($service_id) {
    if(!isset($conn)){
        require (DB_CONNECTION);
    }
    $resp = "not found";
    $cmdsql = "SELECT * FROM sys_service WHERE service_id = '$service_id'";
    $resultcmd = mysqli_query($conn, $cmdsql);
    
    if (!$resultcmd or mysqli_num_rows($resultcmd) == 0){  
        //not found 
        return $resp;
    }else
        {   //founded
            $row = mysqli_fetch_assoc($resultcmd);            
            $name = $row['v_name'];                    
            return $name;
        }    
}

function _run_service($service_id) {//rodo o serviço ativo pelo id 
    
    require (DB_CONNECTION);
    
    global $service_status;
    global $service_msg;
    $service_status = "";
    $service_msg = "";
    
    $cmdsql = "SELECT * FROM sys_service WHERE service_id = '$service_id' and ti_active ='1'";
    $resultcmd = mysqli_query($conn, $cmdsql);
    if (!$resultcmd or mysqli_num_rows($resultcmd) == 0){  
        return false;           
    }else
        { 
            $row = mysqli_fetch_assoc($resultcmd);               
            $name = $row['v_name'];
            $alert = $row['ti_send_alert'];
            if (file_exists(BASE_LOCAL.'/app/service/'.$name.'.php')){
                include (BASE_LOCAL.'/app/service/'.$name.'.php');
                $dt			= gmdate('Y-m-d H:i:s');
                
                require (DB_CONNECTION);//force new connection
                
                $sql = "UPDATE sys_service SET v_status = '$service_status', v_msg_error = '$service_msg', dt_last_update = '$dt' WHERE service_id = '$service_id'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    if ($service_status == 'ok'){ //alert
                        return true;    
                    }else{
                        $data_array = array(
                        'v_service_name' => $name,
                        'v_msg_error' => $service_msg,
                        'ti_send_alert' => $alert,                        
                        'i_service_id' => $service_id);
                        $result = _sqlinsert('service_alert',$data_array);
                    }
                    return true;                        
                }else{                        
                    return false;
                }
            }else{
                return false;
            }
        }
}

?>