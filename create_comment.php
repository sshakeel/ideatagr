<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$ideaID = $_POST['ideaID'];
	$comment = $_POST['comment'];
	$user = $_SESSION['email'];
	$time = $_POST['time'];
	$day = $_POST['day'];
	$month = $_POST['month'];
	$dayOfMonth = $_POST['dayOfMonth'];
	$year = $_POST['year'];
	
	$query = "INSERT INTO comments	(
			ideaID, comment, user, time, day, month, dayOfMonth, year
		) VALUES (
			'{$ideaID}', '{$comment}', '{$user}', '{$time}', '{$day}', '{$month}', '{$dayOfMonth}', '{$year}'
		)";
	
	if (mysql_query($query, $connection)) {
		header('Location: idea.php?id='.$ideaID);
		exit;
		
	} else {
		header('Location: idea.php?id='.$ideaID);
		exit;
	}
?>



<?php mysql_close($connection); ?>