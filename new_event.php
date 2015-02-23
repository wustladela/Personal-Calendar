<?php
   require "database.php";
   ini_set("session.cookie_httponly", 1);
   session_start();

   if(isset($_SESSION['username'])){
      $token = htmlentities($_POST['token']);
   
      if($token!=$_SESSION['token']){
         json_encode(array("status"=>"forgery_attempt"));
         exit;
      }
      $title = htmlentities($_POST['title']);
      $content = htmlentities($_POST['content']);
      $event_month = htmlentities($_POST['event_month']);
      $event_day = htmlentities($_POST['event_day']);
      $event_year = htmlentities($_POST['event_year']);
      $event_hour = htmlentities($_POST['event_hour']);
      $event_min = htmlentities($_POST['event_min']);
      $event_creator = $_SESSION['userid'];
      $am_or_pm = htmlentities($_POST['am_or_pm']);
      $category = htmlentities($_POST['category']);
      $event_users = htmlentities($_POST['event_users']);
      $stmt = $mysqli->prepare("insert into events (event_name, event_descrip, event_month, event_day, event_year, event_hour, event_min, user_id, am_or_pm, category, shared) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      if(!$stmt){
         echo json_encode(array("status"=>"failure"));
         exit;
      }
      $stmt->bind_param('sssiiiiisss', $title, $content, $event_month, $event_day, $event_year, $event_hour, $event_min, $event_creator, $am_or_pm, $category, $event_users); 
      $stmt->execute();
      $stmt->close();
      echo json_encode(array("status"=>"success",
         "title"=>htmlentities($title)));
   }else{
      echo json_encode(array("status"=>"notloggedin"));
   }
?>