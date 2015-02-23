<?php
    require "database.php";
    ini_set("session.cookie_httponly", 1);
    session_start();
    
    $event_id = htmlentities($_POST['event_id']);
    $token = htmlentities($_POST['token']);
    if($token!=$_SESSION['token']){
       echo json_encode(array("status"=>"forgery_attempt"));
        exit;
   }
    if(isset($_SESSION['userid'])){
        $get_usr = $mysqli->prepare("select user_id from events where event_id=?");
        if(!$get_usr){
           echo json_encode(array("status"=>"failure","error" => $mysqli->error));
            exit;
        }
        $get_usr->bind_param('i', $event_id);
        $get_usr->execute();
        $get_usr->bind_result($user_id);
        $get_usr->fetch();
        $get_usr->close();
        
        if($_SESSION['userid']==$user_id){
            
            $stmt = $mysqli->prepare("delete from events where event_id = ?");
            if(!$stmt){
                echo json_encode(array("status"=>"failure","error" => $mysqli->error));
                exit;
            }
            $stmt->bind_param('i', $event_id); 
            $stmt->execute();
            $stmt->close();
    
            echo json_encode(array("status"=>"success"));
        }else{
            echo json_encode(array("status"=>"wronguser"));
        }
        
    }else{
        echo json_encode(array("status"=>"notloggedin"));
    }
    

        
?>