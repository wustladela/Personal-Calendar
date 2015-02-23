<?php
ini_set("session.cookie_httponly", 1);
session_start();
$token = htmlentities($_POST['token']);
 if($token!=$_SESSION['token']){
  echo json_encode(array("status"=>"forgery_attempt"));
  exit;
 }
session_destroy();
echo json_encode(array("status"=>"success", "token"=>$token));
?>