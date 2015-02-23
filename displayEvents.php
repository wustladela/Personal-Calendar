<?php
require "database.php";
ini_set("session.cookie_httponly", 1);
session_start();
        //$currentMonth = $_POST['currentMonth'];
       
        if(isset($_SESSION['userid'])){
            $event_creator_id = $_SESSION['userid'];
            $current_user = $_SESSION['username'];
            $current_user2 = '%'.$current_user.'%';
            //$token = htmlentities($_POST['token']);
            //if($token!=$_SESSION['token']){
             //   json_encode(array("status"=>"forgery_attempt"));
             //   exit;
            //}
            $stmt = $mysqli->prepare("select event_name, event_descrip, event_day, event_month, event_year, event_hour, event_min, event_id, am_or_pm, category from events  where user_id = ? or shared = ? or shared like ?
                                     order by am_or_pm asc, event_hour asc, event_min asc");
            if(!$stmt){
                //printf("Query Prep Failed: %s\n", $mysqli->error);
                echo json_encode(array("status" => "failure", "error" => $mysqli->error));
                exit;
            }
            $stmt->bind_param('iss', $event_creator_id, $current_user, $current_user2);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $allEvents = array();
            $eventDays = array();
            $i = 0;
            while($row = $result->fetch_assoc()){
                $allEvents[$i]=htmlentities($row['event_name']);//body later
                $eventDays[$i]=htmlentities($row['event_day']);
                $eventDescrips[$i]=htmlentities($row['event_descrip']);
                $eventMonths[$i]=htmlentities($row['event_month']);
                $eventHours[$i]=htmlentities($row['event_hour']);
                $eventMins[$i]=htmlentities($row['event_min']);
                $eventYear[$i]=htmlentities($row['event_year']);
                $eventId[$i]=htmlentities($row['event_id']);
                $am_or_pm[$i]=htmlentities($row['am_or_pm']);
                $category[$i]=htmlentities($row['category']);
                $i++;
            }
            if($allEvents==null){
                echo json_encode(array("status"=>"noevents"));
                exit;
            }
            echo json_encode(array("status"=>"success", "title" =>$allEvents, "day"=>$eventDays,"content"=>$eventDescrips,
            "month"=>$eventMonths, "hour"=>$eventHours, "min"=>$eventMins,"year"=>$eventYear,"event_id"=>$eventId, "am_or_pm"=>$am_or_pm, "category"=>$category));
        }else{
            echo json_encode(array("status"=>"notloggedin"));
        }
?>
