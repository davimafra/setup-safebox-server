<?php


// já passou pelo router
$doc_root = $_SERVER['DOCUMENT_ROOT'].'/excenbitservices';
require_once ($doc_root.('/app/config.php'));

//________________________________AJAX CONTROLLER_____________________________________
//debug info
if (DEBUG_MODE){
    echo '<br>';    
    $current_php = __FILE__;
    echo 'AJAX CONTROLLER FILE: '.$current_php;   
}
if (isset($_POST['_file'])){
   
    if(file_exists(BASE_LOCAL.'/app/ajax/'.$_POST['_file'].'.php')){
        include_once (BASE_LOCAL.'/app/ajax/'.$_POST['_file'].'.php');
        
    }else{
        echo 'error';       
    } 
     
        
}else{
echo 'error';

}

?>