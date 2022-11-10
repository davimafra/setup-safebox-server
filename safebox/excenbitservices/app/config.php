<?php

//define BASES
define ('BASE_URL', "http://safebox/excenbitservices/");
define ('BASE_PUBLIC', "http://safebox/excenbitservices/public/");
define ('BASE_LOCAL', $doc_root);
//define DB connections
define ('DB_CONNECTION', BASE_LOCAL."/app/model/database_connection.php");
define ('DB_CONNECTION_LOCAL', BASE_LOCAL."/app/model/database_connection_local.php");


// option de modo debug
define ('DEBUG_MODE', false);
 
if (DEBUG_MODE){
  error_reporting(1);
  echo 'BASE_URL: '; 
  echo BASE_URL;
  echo '<br>';
  echo 'BASE_LOCAL: '; 
  echo BASE_LOCAL;
  echo '<br>';
  echo 'BASE_PUBLIC: '; 
  echo BASE_PUBLIC;
  echo '<br>';

}else{
  error_reporting(0);

} 
//include  lib default
require_once BASE_LOCAL."/app/lib/_microframework.php";
require_once BASE_LOCAL."/app/lib/exchange_functions.php";
require_once BASE_LOCAL."/app/lib/btc_functions.php";
require_once BASE_LOCAL."/app/lib/ltc_functions.php";
require_once BASE_LOCAL."/app/lib/service_functions.php";
require_once BASE_LOCAL."/app/lib/secure_functions.php";




//config  bootstrap











//______________________________autoloader______________________________________
spl_autoload_register(function($className){
  include_once BASE_LOCAL."/app/lib/$className.php";
});







?>