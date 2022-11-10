<?php


function is_valid_btc_address($check_address){

    if (empty($check_address)) {        
        return false;
    }

    /** 
______________________________  LIMITE DE 10 REQ. POR SEGUNDO! _____________________________
*/
    sleep(3);//limitador de requisições

    $url = "https://blockchain.info/q/addressbalance/".$check_address;
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
        if ($result >= 0) {
            return true;
        }else{
            return false;
        }
    
    
    }

}

function btc_address_info($address){
    global $json_result;
    sleep(1);//limitador de requisições
    
    $url = "https://chain.api.btc.com/v3/address/$address";
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

        if ($json_result['err_no'] == '0'){    
            
            if (is_null($json_result['data'])){    
            
                return false;
               
               }else{
                return $json_result;
                
               }
        
        }else{
         return false;
        }
       
        }      
}   

function btc_rawaddr($address,$offset = ""){//Optional offset parameter to show first n transactions default = 50
    global $json_result;
    sleep(1);//limitador de requisições
    if (empty($address)) {
        
        return false;
    }
    if ($offset == NULL){
        $offset = '';
    }else{
        
        $offset = "?pagesize=".$offset;
       
    }
    
    //https://sochain.com/api/v2/address/BTC/176HXEBuiXZbLzKUbmhJK2NkkK7kj47Sr9
    //https://chain.api.btc.com/v3/address/3Qv5jH9yQeqGxJiBk6oWh1ctHAVEmVUEeF/tx?pagesize=100
    $url = "https://chain.api.btc.com/v3/address/$address/tx".$offset;
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

function btc_get_balance_address($guid,$password,$address){
    global $json_result;

    if (empty($address) or empty($guid) or empty($password)) {
        
        return false;
    }
        
    $url = "http://localhost:3000/merchant/$guid/address_balance?password=$password&address=$address";
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

        if ($json_result['balance'] >= '0'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}   
function btc_get_balance_wallet($guid,$password){
    global $json_result;

    if (empty($guid) or empty($password)) {
        
        return false;
    }
        
    $url = "http://localhost:3000/merchant/$guid/balance?password=$password";
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

        if ($json_result['balance'] >= '0'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}   

function btc_create_wallet($password,$api_code, $label){
    global $json_result;

    if (empty($password) or empty($api_code)) {
        
        return false;
    }
    //$json_url = "http://localhost:3000/merchant/$guid/sendmany?password=$firstpassword&second_password=$secondpassword&recipients=$recipients";
    
    $url = "http://localhost:3000/api/v2/create?password=$password&api_code=$api_code&label=$label";    
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

        if ($json_result['label'] <> 'error'){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}   


function btc_create_address($guid,$password){
    global $json_result;

    if (empty($password) or empty($guid)) {
        
        return false;
    }
    
    
    $url = "http://localhost:3000/merchant/$guid/new_address?password=$password";    
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

        if ($json_result['address'] <> ''){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}   


    
function btc_list_address($guid,$password){
    global $json_result;

    if (empty($password) or empty($guid)) {
        
        return false;
    }
    
    
    $url = "http://localhost:3000/merchant/$guid/list?password=$password";    
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

        return $json_result;
       
        }
      
}    
    
function btc_send_payment($guid,$password,$amount, $fee, $recipient){
    global $json_result;

    if (empty($password) or empty($guid) or empty($amount) or empty($recipient)) {
        
        return false;
    }
    if ($fee == NULL){
        $fee = '';
    }else{
        
        $fee = "&fee=".$fee;
        
    }   
       
    $url = "http://localhost:3000/merchant/$guid/payment?password=$password&to=$recipient&amount=$amount". $fee;    
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

        if ($json_result['tx_hash'] <> ''){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
        }
      
}    

function btc_sendmany($guid,$password,$fee,$recipients){
    global $json_result;

    if (empty($password) or empty($guid) or empty($recipients)) {
        
        return false;
    }
    if ($fee == NULL){
        $fee = '';
    }else{
        
        $fee = "&fee=".$fee;
        
    }   
    //$recip = urlencode($recipients)
    $url = "http://localhost:3000/merchant/$guid/sendmany?password=$password&recipients=$recipients".$fee;    
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
        //echo 'the address you provided was not recognized';
       
        return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        if ($json_result['tx_hash'] <> ''){    
            
         return $json_result;
        
        }else{
         return false;
        }
       
       
        }
      
}    


function satoshi_to_btc($amount){
return $amount/100000000 ;
}
function btc_to_satoshi($amount){
    return $amount*100000000 ;    
}

?>