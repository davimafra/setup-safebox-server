<?php

//_________________________________DEFAULT SERVICE TEST_________________________________________
// !!! dont put echo or print here!
try{
    $service_status = "error";//default if not ok
    $service_msg = "";
    $required_actions = 10;
    $count_actions = 0;
    
    //______________________________________________________________________________________________
    
    $dt	= new DateTime(gmdate("Y-m-d H:i:s"));
    $dt = $dt->format('H:i:s');//converto para string
    
    for ($i=1; $i <= $required_actions; $i++) { 
        $count_actions ++;
        sleep(1);
        //echo '<br>';
        //echo 'counting...'.$i;
    }
    
    
    
    if ($count_actions >= $required_actions ){
        $service_msg = "safebox executed: ".$i." at ".$dt;
        //$service_msg = "";
        $service_status = "ok";  
    }else{
        $service_msg = "failed in actions! required actions:".$required_actions." actions executed:".$count_actions;
        //$service_msg = "";
        $service_status = "error";
    }

//____________________________________________________________________
return true;
} catch (\Throwable $th) {
    $service_status = "error";
    $service_msg = "exception";
}

?>
