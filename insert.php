<?php
INCLUDE_ONCE "database.php";
$title = $_POST['title'];
$content = $_POST['content']

if(mysql_query("INSERT INTO stories VALUES('$story_title','$story_content')"))
	echo "successfully inserted!";
else echo "failed to insert";
