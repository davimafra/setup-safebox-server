<?php

	/**
	 * verify if an address is valid
	 * @param string $check_address	 
	
	 */
function is_valid_ltc_address($check_address){

    if (empty($check_address)) {        
        return false;
    }

    /** 
______________________________  LIMITE DE 10 REQ. POR SEGUNDO! _____________________________
*/
    sleep(2);//limitador de requisições

    $url = "https://sochain.com/api/v2/is_address_valid/LTC/".$check_address;
    //https://sochain.com/api/v2/is_address_valid/LTC/LcAczq3siFwZmTJL8vxt1NDmpykg3FvFdt
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando

    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }

    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
       
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['status'] == 'success'){    
            
            if ($json_result['data']['is_valid'] == 'true'){
                return true;
            }else{
                return false;
            }  
        
        }else{
         return false;
        }
       
    }

}


function ltc_rawaddr($address){
    global $json_result;
    sleep(2);//limitador de requisições
    if (empty($address)) {
        
        return false;
    }
    
    //https://sochain.com/api/v2/address/LTC/LcAczq3siFwZmTJL8vxt1NDmpykg3FvFdt
    $url = "https://sochain.com/api/v2/address/LTC/$address";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando
    
    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
       
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['status'] == 'success'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
    }
      
}   
function ltc_get_tx_received($address,$latesttx = ''){
    global $json_result;
    sleep(2);//limitador de requisições
    if (empty($address)) {
        
        return false;
    }
    
    //https://sochain.com/api/v2/get_tx_received/LTC/LcAczq3siFwZmTJL8vxt1NDmpykg3FvFdt
    $url = "https://sochain.com/api/v2/get_tx_received/LTC/$address/$latesttx";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando
    
    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
       
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['status'] == 'success'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
    }
      
}   

function ltc_get_balance_address($address){
    global $json_result;
    sleep(2);//limitador de requisições
    //alternativa:https://ltc-chain.api.btc.com/v3/address/LcAczq3siFwZmTJL8vxt1NDmpykg3FvFdt

    //https://sochain.com/api/v2/get_address_balance/LTC/LcAczq3siFwZmTJL8vxt1NDmpykg3FvFdt    
    $url = "https://sochain.com/api/v2/get_address_balance/LTC/$address";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando
    
    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
        //echo 'the address you provided was not recognized';
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = json_decode($result, true);
        if ($json_result['status'] == 'success'){  
            
            $balance = $json_result['data']['confirmed_balance'];       
            return $balance;
            
        }else{
            return false;
        }
    }   
}

function ltc_create_wallet(){
    global $json_result;

    
    
    $url = "http://localhost:3005/create_wallet";    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando
    
    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
        //echo 'the address you provided was not recognized';
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['status'] == 'success'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}   


function ltc_sendall($address,$privkey,$fee){
    global $json_result;

    $url = "http://localhost:3005/sendall?privkey=$privkey&address=$address&fee=$fee";   
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando
    
    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
        //echo 'the address you provided was not recognized';
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['status'] == 'success'){    
            
         return true;
        
        }else{
         return false;
        }
       
        }
      
}   

function ltc_send_payment($address,$privkey,$amount,$fee){
    global $json_result;

    $url = "http://localhost:3005/send?privkey=$privkey&address=$address&amount=$amount&fee=$fee";   
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando
    
    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
        //echo 'the address you provided was not recognized';
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['status'] == 'success'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}   


    



function satoshi_to_ltc($amount){
return $amount/100000000 ;
}
function ltc_to_satoshi($amount){
    return $amount*100000000 ;    
}



function ltc_send_many($privkey){//funcao apenas de teste
    global $json_result;

    $url = "http://localhost:3005/send_many?privkey=$privkey";   
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);//executa o comando
    
    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        // Handle cURL error accordingly
        //echo 'the address you provided was not recognized';
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['status'] == 'success'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}   



?>