<?php
//________________________________CONTROLLER_____________________________________
//debug info
if (DEBUG_MODE){
    echo '<br>';    
    $current_php = __FILE__;
    echo 'INIT CONTROLLER FILE: '.$current_php;   
}






//verify Session


//load user info
require (DB_CONNECTION);

$status = _service_get_status(2,DB_CONNECTION_REMOTE,$conn2);
//$status = _service_get_status(2);















//load view

include (BASE_LOCAL."/app/lib/_default_view.php");


?>


