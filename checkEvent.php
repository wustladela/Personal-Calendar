<?php
session_start();

echo json_encode(array("title"=>$_SESSION['event_name'], "content"=>$_SESSION['event_descrip']));
?>