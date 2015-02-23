<?php
   require "database.php";
   ini_set("session.cookie_httponly", 1);
   session_start();

   $event_id = htmlentities($_POST['event_id']);
   //$event_id = 46;
   $token = htmlentities($_POST['token']);
   
   if($token!=$_SESSION['token']){
      json_encode(array("status"=>"forgery_attempt"));
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
      
      $get_usr2 = $mysqli->prepare("select shared from events where event_id=?");
      if(!$get_usr2){
         echo json_encode(array("status"=>"failure","error" => $mysqli->error));
         exit;
      }
      $get_usr2->bind_param('i', $event_id);
      $get_usr2->execute();
      $get_usr2->bind_result($shared_usr);
      $get_usr2->fetch();
      $get_usr2->close();
      
      if($_SESSION['userid']==$user_id){
         $stmt = $mysqli->prepare("select event_name, event_descrip, event_month, event_day, event_year, event_hour, event_min, am_or_pm, category, username from events join users on (events.user_id=users.user_id) where event_id = ?");
         if(!$stmt){
            echo json_encode(array("status"=>"failure","error" => $mysqli->error));
            exit;
         }
         $stmt->bind_param('i', $event_id); 
         $stmt->execute();
         $stmt->bind_result($event_name, $event_descrip, $event_month, $event_day, $event_year, $event_hour, $event_min, $am_or_pm, $category, $event_creator);
         $stmt->fetch();
         $stmt->close();
         $_SESSION['event_id']= htmlentities($event_id);
         $_SESSION['event_name'] = htmlentities($event_name);
         $_SESSION['event_descrip'] = htmlentities($event_descrip);
         echo json_encode(array("status"=>"success", "event_id"=>htmlentities($event_id),"event_name"=>htmlentities($event_name), "event_descrip"=>htmlentities($event_descrip), "event_month"=>htmlentities($event_month), "event_day"=>htmlentities($event_day), "event_year"=>htmlentities($event_year), "event_hour"=>htmlentities($event_hour),
            "event_min"=>htmlentities($event_min), "event_creator"=>htmlentities($event_creator),"am_or_pm"=>htmlentities($am_or_pm), "category"=>htmlentities($category)));           
      }
      
      if(($shared_usr!=null)&&($_SESSION['userid']!=$user_id)){
            $current_user = '%'.$_SESSION['username'].'%';
            $stmt = $mysqli->prepare("select event_name, event_descrip, event_month, event_day, event_year, event_hour, event_min, am_or_pm, category, username from events join users on (events.user_id=users.user_id) where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure","error" => $mysqli->error));
               exit;
            }
            $stmt->bind_param('is', $event_id, $current_user); 
            $stmt->execute();
            $stmt->bind_result($event_name, $event_descrip, $event_month, $event_day, $event_year, $event_hour, $event_min, $am_or_pm, $category, $event_creator);
            $stmt->fetch();
            $stmt->close();
            $_SESSION['event_id']= htmlentities($event_id);
            $_SESSION['event_name'] = htmlentities($event_name);
            $_SESSION['event_descrip'] = htmlentities($event_descrip);
            echo json_encode(array("status"=>"success", "event_id"=>htmlentities($event_id),"event_name"=>htmlentities($event_name), "event_descrip"=>htmlentities($event_descrip), "event_month"=>htmlentities($event_month), "event_day"=>htmlentities($event_day), "event_year"=>htmlentities($event_year), "event_hour"=>htmlentities($event_hour),
               "event_min"=>htmlentities($event_min), "event_creator"=>htmlentities($event_creator),"am_or_pm"=>htmlentities($am_or_pm), "category"=>htmlentities($category)));           
         
      }
      
   }else{
        echo json_encode(array("status"=>"notloggedin"));
    }
?>