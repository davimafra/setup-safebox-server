<?php

function _btc_get_balance($address){//default name: _XXX_get_balance
    $balance = null;
    
    if (empty($address)) {        
        return $balance;
    }
    //https://chain.api.btc.com/v3/address/15urYnyeJe3gwbGJ74wcX89Tz7ZtsFDVew
    $url = "https://chain.api.btc.com/v3/address/".$address;
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
        if (isset($result)) {
        $result = json_decode($result,true);  
            $balance = $result['data']['balance'];
            if(isset($balance)){
                return $balance;
            }else{
                return false;//retorna false se ocorrer erro ou end invalido
            }
        }else{
            return false;//retorna false se ocorrer erro ou end invalido
        }
        
    }

}

function _btc_get_tx_info($txid){
   

}

function _ltc_get_balance($address){//default name: _XXX_get_balance
    return 0;
}

//version 1.0
function curl_execute($method,$base_url,$endpoint = '', $lista = null,$header = null, $get_params = null,$param1 = null,$value1 = null,$param2 = null,$value2 = null,$param3 = null,$value3 = null,$param4 = null,$value4 = null){

    if (isset($lista)) {
        //usa dados dos parametros
        //$get_params = '?'.$param1."=".$value1."&".$param2."=".$value2."&".$param3."=".$value3."&".$param4."=".$value4;
            if(isset($get_params)){
                $data = [
                    $param1 => $value1,
                    $param2 => $value2,
                    $param3 => $value3,
                    $param4 => $value4,
                    
                ]; 
            }
        
        }else{
        $data = $lista;    
        
        }
    //default curl
    //$ch = curl_init($url);
    $ch = curl_init();

    if (empty($header)) {
        curl_setopt($ch, CURLOPT_HEADER, false);
    }else{
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
    }

    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //formatar de acordo com o method
    switch ($method){

    //_____________________________________________________________ curl POST __________________________________________________________________
        case "POST":
            $url = $base_url.$endpoint;
            curl_setopt($ch, CURLOPT_URL,$url);

            curl_setopt($ch, CURLOPT_POST, true);
            //curl_setopt($ch, CURLOPT_POST, count($lista)); //number of parameters sent
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //parameters data       
            
            break;
    //_____________________________________________________________ curl PUT __________________________________________________________________
        case "PUT":
            $url = $base_url.$endpoint;
            curl_setopt($ch, CURLOPT_URL,$url);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //parameters data 
                                            
            break;
    //_____________________________________________________________ curl GET __________________________________________________________________
        case "GET":
            $url = $base_url.$endpoint;
            if (empty($lista)) {
                curl_setopt($ch, CURLOPT_URL,$url.$get_params);
            }else{
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //parameters data
            }                                            
            break;
    //_____________________________________________________________ curl DELETE__________________________________________________________________
        case "DELETE":
            $url = $base_url.$endpoint;
            curl_setopt($ch, CURLOPT_URL,$url);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //parameters data 
    }

    $result = curl_exec($ch);//executa o comando

    if (curl_errno($ch)) { //verifico se ocorreu algum erro com a requisição
        $error_msg = curl_error($ch);
    }else{
        unset($error_msg);
    }
    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // Check the HTTP Status code
    switch ($httpCode) {
        case 200:
            $error_status = "200: Success";
            
            break;
        case 404:
            $error_status = "404: API Not found";
            break;
        case 500:
            $error_status = "500: servers replied with an error.";
            break;
        case 502:
            $error_status = "502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
            break;
        case 503:
            $error_status = "503: service unavailable. Hopefully they'll be OK soon!";
            break;
        default:
            $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($ch);
            break;
    }
    curl_close($ch);
    $json_result = "";    

    if (isset($error_msg)) {
        // Handle cURL error accordingly
        $result =  "error";  
        
        //return false;
    }else {//se não ocorreu nenhum erro...
        $json_result = (json_decode($result, true));

        //return $json_result;
        $result =  "done";      
        $error_msg = null;
        $error_status = '';
    }
    $arr_result = array(
    'result' => $result,
    'json_result' => $json_result,
    'error_status' => $error_status,
    'error_msg' => $error_msg);
    return $arr_result;
}






















?>