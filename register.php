<?php
    ini_set("session.cookie_httponly", 1);
    session_start();
    require "database.php";

    $new_user = htmlentities($_POST['new_username']);
    $new_pass = htmlentities($_POST['new_password']);
    $crypt_pass = crypt ($new_pass, '$1$awagawag$');
    //echo json_encode(array("user"=>$new_user, "password"=>$new_pass));

    $check = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username=?");
    if(!$check){
	//printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array("status"=>"fail","error"=>$mysqli->error));
	exit;
}
    $check->bind_param('s', $new_user);
    $check->execute();
    $check->bind_result($cnt);
    $check->fetch();
    $check->close();

if( htmlentities($cnt) == 0){
$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
if(!$stmt){
	//printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array("status"=>"fail","error"=>$mysqli->error));
	exit;
}
$stmt->bind_param('ss', $new_user, $crypt_pass); 
$stmt->execute();
$stmt->close();

echo json_encode(array("status"=>"success",
            "username"=>$new_user                   
                               ));
}else{
    echo json_encode(array("status"=>"fail", "error"=>"user already exists","count"=>htmlentities($cnt)));
}
?>
