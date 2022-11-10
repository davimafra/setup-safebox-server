<?php
    /** 
______________________________  secure functions v1.1 - 16/06/2020_____________________________
*/

function encrypt_decrypt($action, $string, $secret_key) {
  $output = false;
  $encrypt_method = "AES-256-CBC";
 
  $secret_iv = 'davi123';
  // hash
  $key = hash('sha256', $secret_key);
  
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  if ( $action == 'encrypt' ) {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
  } else if( $action == 'decrypt' ) {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}

function get_apicode_btc(){
return 'e17fd518-75dc-48c0-bd82-a5c568fe7d9b';

}










?>
