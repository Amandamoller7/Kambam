<?php
$servername ="localhost";
$username ="root";
$password ="root";
$dbname ="KAMBAM";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli-> connect_error){
    die("conexao falhou:". $mysqli->connect_error);
}
?>