<?php


//_____________________________________________LOAD DEFAULT VIEW___________________________


//go to same name as view
if(file_exists(BASE_LOCAL."/app/view/".$url_requested. ".php")){//verify if file exists in view    
    include_once (BASE_LOCAL."/app/view/".$url_requested. ".php");
}else{
    if(file_exists(BASE_LOCAL."/app/view/".$url_requested. "/index.php")){//verify if file index exists in view    
        include_once (BASE_LOCAL."/app/view/".$url_requested. "/index.php");
    }else{
        include_once (BASE_LOCAL."/app/view/_pagenotfound.php");
    }
        
}
//___________________________________________________________________________________________________________

?>