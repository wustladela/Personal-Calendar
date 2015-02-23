<?php
ini_set("session.cookie_httponly", 1);
session_start();
require "database.php";

$stmt = $mysqli->prepare("SELECT COUNT(*), user_id, password FROM users WHERE username=?");
$user = $_POST['username'];
$stmt->bind_param('s', $user);
$stmt->execute();
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
$stmt->close();
$pwd_guess = $_POST['password'];

if( $cnt == 1 && crypt($pwd_guess, '$1$awagawag$')==$pwd_hash){

	$_SESSION['username'] = $user;
        $_SESSION['userid'] = $user_id;
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
        echo json_encode(array("status"=>"success",
            "username"=>htmlentities($user), "userid"=>htmlentities($user_id), "token"=>$_SESSION['token']                   
                               ));
        //echo "true";
        //header("location:logged_in.php");
	
}else{
    echo json_encode(array("status"=>"fail"));
    //echo "false";   
}

?>