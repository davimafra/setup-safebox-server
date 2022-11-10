<?php

//________________________________API EXECUTION_____________________________________
$doc_root = $_SERVER['DOCUMENT_ROOT'].'/excenbitservices';
require_once ($doc_root.('/app/config.php'));

//debug info
if (DEBUG_MODE){
    echo '<br>';    
    $current_php = __FILE__;
    echo 'RUN SERVICE: '.$current_php;   
}

if (empty($_GET["id"])) {
    echo 'invalid id';
    return false;
    } else {
        $service_id = $_GET['id'];
        $service_id = trim($service_id);
        $service_id = stripslashes($service_id);
        $service_id = htmlspecialchars($service_id);
    }
    
//busco no banco de dados o id do serviço 
        
    if (!_service_get_active($service_id)){
        //serviço inativo
    echo 'inactive'; 
    }else{//serviço ativo
        
        $name = _service_get_name($service_id);
        
        if (file_exists(BASE_LOCAL.'/app/service/'.$name.'.php')){ 
                   
            if (_run_service($service_id)) {
                echo 'done';//executado            
            }else{
                echo 'error';
            }
        }else{
            echo 'file not found: '.$name; 
        }        
    }        




?>