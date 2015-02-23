<?php
ob_start();
$host="localhost"; // Host name 
$username="wustl_inst"; // Mysql username 
$password="wustl_pass"; // Mysql password 
$db_name="module6"; // Database name 

// Use a prepared statement
$mysqli = new mysqli($host, $username, $password, $db_name);
if($mysqli->connect_errno){
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
}
?>