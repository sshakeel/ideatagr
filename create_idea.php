<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$user = $_SESSION['email'];
	$idea = $_POST['idea'];
	$time = $_POST['time'];
	$day = $_POST['day'];
	$location = $_POST['location'];
	$tags = $_POST['tags'];
	$month = $_POST['month'];
	$dayOfMonth = $_POST['dayOfMonth'];
	$year = $_POST['year'];
	$access = $_SESSION['email'];
	
	$query = "INSERT INTO ideas	(
			user, idea, time, day, location, tags, month, dayOfMonth, year, access
		) VALUES (
			'{$user}', '{$idea}', '{$time}', '{$day}', '{$location}', '{$tags}', '{$month}', '{$dayOfMonth}', '{$year}', '{$access}'
		)";
	
	if (mysql_query($query, $connection)) {
		header("Location: index.php?sub=successful");
		exit;
		
	} else {
		header("Location: index.php?sub=booboo");
		exit;
	}
?>



<?php mysql_close($connection); ?>