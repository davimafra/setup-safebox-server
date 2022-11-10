<?php
//________________________________CONTROLLER_____________________________________
//debug info
if (DEBUG_MODE){
    echo '<br>';    
    $current_php = __FILE__;
    echo 'INIT CONTROLLER FILE: '.$current_php;   
}






//verify Session login
//require (BASE_LOCAL."/app/model/_authorizer.php");

//load user info and session info
//require (BASE_LOCAL."/app/model/_load_user_info.php");







//return from model




//load view
require_once (BASE_LOCAL."/app/lib/_default_view.php");


?>