<?php
require "database.php";
session_start();
if(isset($_SESSION['userid'])){
    $event_creator_id = $_SESSION['userid'];
    //$current_user = $_SESSION['username'];
    

$shareFromUsername = $_POST['shareFromUser'];
$user_like = '%'.$shareFromUsername.'%';
     $permitted = false;
     $permission = $mysqli->prepare("select sharedUser from users where username = ?");
        if(!$permission){
        echo json_encode(array("status" => "failure", "error" => $mysqli->error));
        exit;
    }
$permission->bind_param('s', $shareFromUsername);
    $permission->execute();
    $permissionResult = $permission->get_result();
    $permission->close();
    $i = 0;
    while($row = $permissionResult->fetch_assoc()){  
    $permittedUser[$i]=$row['sharedUser']; 

    if ($permittedUser[$i]==$_SESSION['username']) {
        $permitted = true;
        }
    $i++; 
    }
    // 
    if ($permitted==false){
        echo json_encode(array("status" => "failure", "error" => $mysqli->error));
        exit;
    }


    $stmt = $mysqli->prepare("select event_name, event_descrip, event_day, event_month, event_year, event_hour, event_min, event_id, am_or_pm, category from events, users where (events.user_id = users.user_id && users.username=?) or shared = ? or shared like ?)
                             order by am_or_pm asc, event_hour asc, event_min asc");
    if(!$stmt){
        echo json_encode(array("status" => "failure", "error" => $mysqli->error));
        exit;
    }

    $stmt->bind_param('sss', $shareFromUsername, $shareFromUsername, $user_like);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $allEvents = array();
    $eventDays = array();
    $i = 0;
    while($row = $result->fetch_assoc()){     
            $allEvents[$i]=$row['event_name'];//body later
            $eventDays[$i]=$row['event_day'];
            $eventDescrips[$i]=$row['event_descrip'];
            $eventMonths[$i]=$row['event_month'];
            $eventHours[$i]=$row['event_hour'];
            $eventMins[$i]=$row['event_min'];
            $eventYear[$i]=$row['event_year'];
            $eventId[$i]=$row['event_id'];
            $am_or_pm[$i]=$row['am_or_pm'];
            $category[$i]=$row['category'];
            $i++;

        }
        echo json_encode(array("status"=>"success", "title" =>$allEvents, "day"=>$eventDays,"content"=>$eventDescrips,
            "month"=>$eventMonths, "hour"=>$eventHours, "min"=>$eventMins,"year"=>$eventYear,"event_id"=>$eventId, "am_or_pm"=>$am_or_pm, "category"=>$category));
    }else{
        echo json_encode(array("status"=>"notloggedin"));
    }
    ?>
