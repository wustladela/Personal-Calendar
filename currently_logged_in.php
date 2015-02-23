<?php
ini_set("session.cookie_httponly", 1);
session_start();
if(!isset($_SESSION['token'])){
    $_SESSION['token'] = substr(md5(rand()), 0, 10);
}
if(isset($_SESSION['username'])){
    echo json_encode(array("status"=>"success", "username"=>$_SESSION['username'],"token"=>$_SESSION['token']));
}else{
    echo json_encode(array("status"=>"fail"));
}

?>