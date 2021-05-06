<?php
require '../config/config.php';

$configs = include('../config/config.php');



$servername=$configs['database']['servername'];
$dbUsername=$configs['database']['dbUsername'];
$dBPassword=$configs['database']['dBPassword'];
$dBName=$configs['database']['dBName'];

$conn=mysqli_connect($servername, $dbUsername, $dBPassword, $dBName);

if(!$conn){

    die("Connection refused: ".mysqli_connect_error());

}