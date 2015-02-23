<?php
   require "database.php";
   ini_set("session.cookie_httponly", 1);
   session_start();

   $title = htmlentities($_POST['title']);
   $content = htmlentities($_POST['content']);
   $month = htmlentities($_POST['month']);
   $year = htmlentities($_POST['year']);
   $event_id = htmlentities($_POST['event_id']);
   $day = htmlentities($_POST['day']);
   $hour = htmlentities($_POST['hour']);
   $min = htmlentities($_POST['min']);
   $am_or_pm = htmlentities($_POST['am_or_pm']);
   $category = htmlentities($_POST['category']);

   htmlentities($token = $_POST['token']);
   if($token!=$_SESSION['token']){
      json_encode(array("status"=>"forgery_attempt"));
      exit;
   }
   if(isset($_SESSION['userid'])){
      $get_usr = $mysqli->prepare("select user_id, shared from events where event_id=?");
      if(!$get_usr){
         echo json_encode(array("status"=>"failure","error" => $mysqli->error));
         exit;
      }
      $get_usr->bind_param('i', $event_id);
      $get_usr->execute();
      $get_usr->bind_result($user_id, $shared_usr);
      $get_usr->fetch();
      $get_usr->close();
      
      if(($shared_usr!=null)&&($_SESSION['userid']!=$user_id)){
            $current_user = '%'.$_SESSION['username'].'%';
            if ($title!="") {
            $stmt = $mysqli->prepare("update events set event_name = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('sis', $title, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();    
         }
         if ($content!=""){
            $stmt = $mysqli->prepare("update events set event_descrip = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('sis', $content, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();    
         }
         if($month!=""){
            $stmt = $mysqli->prepare("update events set event_month = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('sis', $month, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();     
         }
         if($year!=""){
            $stmt = $mysqli->prepare("update events set event_year = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('iis', $year, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();     
         }
         if($day!=""){
            $stmt = $mysqli->prepare("update events set event_day = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('iis', $day, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();     
         }
         if($hour!=""){
            $stmt = $mysqli->prepare("update events set event_hour = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('iis', $hour, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();     
         }
         if($min!=""){
            $stmt = $mysqli->prepare("update events set event_min = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('iis', $min, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();     
         }
         if($category!=""){
            $stmt = $mysqli->prepare("update events set category = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('sis', $category, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();     
         }
         if($category=="none"){
            $stmt = $mysqli->prepare("update events set category = ? where event_id = ? and shared like ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $nocategory = null;
            $stmt->bind_param('sis', $nocategory, $event_id, $current_user); 
            $stmt->execute();
            $stmt->close();     
         }
         $stmt = $mysqli->prepare("update events set am_or_pm = ? where event_id = ? and shared like ?");
         if(!$stmt){
            echo json_encode(array("status"=>"failure"));
            exit;
         }
         $stmt->bind_param('sis', $am_or_pm, $event_id, $current_user); 
         $stmt->execute();
         $stmt->close();

         echo json_encode(array("status"=>"success",
            "title"=>$title));
            
      }
      if($_SESSION['userid']==$user_id){  
         if ($title!="") {
            $stmt = $mysqli->prepare("update events set event_name = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('si', $title, $event_id); 
            $stmt->execute();
            $stmt->close();    
         }
         if ($content!=""){
            $stmt = $mysqli->prepare("update events set event_descrip = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('si', $content, $event_id); 
            $stmt->execute();
            $stmt->close();    
         }
         if($month!=""){
            $stmt = $mysqli->prepare("update events set event_month = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('si', $month, $event_id); 
            $stmt->execute();
            $stmt->close();     
         }
         if($year!=""){
            $stmt = $mysqli->prepare("update events set event_year = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('ii', $year, $event_id); 
            $stmt->execute();
            $stmt->close();     
         }
         if($day!=""){
            $stmt = $mysqli->prepare("update events set event_day = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('ii', $day, $event_id); 
            $stmt->execute();
            $stmt->close();     
         }
         if($hour!=""){
            $stmt = $mysqli->prepare("update events set event_hour = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('ii', $hour, $event_id); 
            $stmt->execute();
            $stmt->close();     
         }
         if($min!=""){
            $stmt = $mysqli->prepare("update events set event_min = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('ii', $min, $event_id); 
            $stmt->execute();
            $stmt->close();     
         }
         if($category!=""){
            $stmt = $mysqli->prepare("update events set category = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $stmt->bind_param('si', $category, $event_id); 
            $stmt->execute();
            $stmt->close();     
         }
         if($category=="none"){
            $stmt = $mysqli->prepare("update events set category = ? where event_id = ?");
            if(!$stmt){
               echo json_encode(array("status"=>"failure"));
               exit;
            }
            $nocategory = null;
            $stmt->bind_param('si', $nocategory, $event_id); 
            $stmt->execute();
            $stmt->close();     
         }
         $stmt = $mysqli->prepare("update events set am_or_pm = ? where event_id = ?");
         if(!$stmt){
            echo json_encode(array("status"=>"failure"));
            exit;
         }
         $stmt->bind_param('si', $am_or_pm, $event_id); 
         $stmt->execute();
         $stmt->close();

         echo json_encode(array("status"=>"success",
            "title"=>$title));
      }
   }else{
      echo json_encode(array("status"=>"notloggedin"));
   }

?>