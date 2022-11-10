<?php
$servername = "45.13.252.52";
$username = "u924550487_adm";
$password = "Senhalixo123$";
$database = "u924550487_exchange";

//$username = "root";
//$password = "admin";
//$database = "u924550487_exchange";

// Create connection
ini_set('mysql.connect_timeout', 50000);
ini_set('default_socket_timeout', 50000);
ini_set('max_allowed_packet',500);

global $conn;
$conn = new mysqli($servername, $username, $password,$database);

//Checa se a conexão obteve sucesso
if ($conn->connect_error){
  die("Connection Error:" .$conn->connect_error);
  } else {
  //echo "Conectado";
  }
?>
