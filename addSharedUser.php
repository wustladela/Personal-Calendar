<?php
require "database.php";
session_start();

$addSharedUser = htmlentities($_POST['shareToUser']);
$logged_id = $_SESSION['userid'];
$stmt = $mysqli->prepare("update users set sharedUser=? where user_id = ?");
        if(!$stmt){
           echo json_encode(array("status"=>"failure","error"=>$mysqli->error));
            exit;
        }
        $stmt->bind_param('si', $addSharedUser, $logged_id ); 
        $stmt->execute();
        $stmt->close();
        echo json_encode(array("status"=>"success"));

?>