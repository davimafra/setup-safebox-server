<?php

// já passou pelo router
$doc_root = $_SERVER['DOCUMENT_ROOT'].'/excenbitservices';
require_once ($doc_root.('/app/config.php'));
if (isset($_POST['_file'])){
   
    if(file_exists(BASE_LOCAL.'/app/view/'.$_POST['_file'].'.html')){
        include_once (BASE_LOCAL.'/app/view/'.$_POST['_file'].'.html');
        
    }else{
        echo 'error';       
    } 
     
        
}else{
echo 'error';

}


?>