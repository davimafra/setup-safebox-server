<?php
$servername = "127.0.0.1";
$username = "root"; //excenbit
$password = "admin";//admin
$database = "safebox";

//$username = "root";
//$password = "admin";
//$database = "u924550487_exchange";

// Create connection local

ini_set('mysql.connect_timeout', 50000);
ini_set('default_socket_timeout', 50000);
ini_set('max_allowed_packet',5000);

global $conn2;
$conn2 = new mysqli($servername, $username, $password,$database);

//Checa se a conexão obteve sucesso
if ($conn2->connect_error){
  die("Connection Error:" .$conn2->connect_error);
  } else {
  //echo "Conectado";
  }
?>
