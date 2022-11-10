<?php

class Router{

    // Default controller, method, params
    
    

    public function __construct()
    {

        $url = $this->url();
        $url_requested = $this->url_requested();
        if (DEBUG_MODE){
            if(isset($_GET['url'])){
                print_r ("ROUTER>>> ".$_GET['url']);  
            }else{
                print_r("ROUTER>>> ");
            }
                       
        }
       
        
        
        if(!empty($url)){ 
                      
            if(file_exists(BASE_LOCAL."/app/controller/" . $_GET['url'].".php")){//verify if file exists
                $this->controller = $url[0];
                //unset($url[0]);
                //unset($url[1]);               
                require BASE_LOCAL."/app/controller/" . $_GET['url'].".php";                
  
            } else {
                if(file_exists(BASE_LOCAL."/app/controller/" . $_GET['url']."/index.php")){//verify if file index exists
                    $this->controller = $url[0];                    
                    require BASE_LOCAL."/app/controller/" . $_GET['url']."/index.php";
                }else{                    
                    include BASE_LOCAL."/app/view/_pagenotfound.php";
                }
                    
                
            }
        }else{
            //print_r ("ROUTER>>> /");
            //$this->controller = $url[0];
            //unset($url[0]);
            //unset($url[1]);
            require BASE_LOCAL."/app/controller/index.php";//default home controller

        }
                
                
    

    }
    
    public function url(){
        if(isset($_GET['url'])){
            $url_requested = $_GET['url'];
            $url = $_GET['url'];
            $url = rtrim($url);
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            return $url;
        }
    }
    public function url_requested(){
        if(isset($_GET['url'])){
            $url_requested = $_GET['url'];           
            return $url_requested;
        }
    }

}

?>

