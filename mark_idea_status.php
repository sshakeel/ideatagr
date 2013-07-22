<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$user = $_SESSION['email'];
	$ideaID = $_GET['id'];
	$completed = $_GET['completed'];
	$dateCompleted = date('l j F Y h:i:s A');
	
	$query = "UPDATE ideas SET completed='{$completed}', completedOn='{$dateCompleted}' WHERE user='{$user}' AND id='{$ideaID}'";
	
	if (mysql_query($query, $connection)) {
		header("Location: idea.php?id=$ideaID&marked=$completed&sub=successful");
		exit;
		
	} else {
		header("Location: idea.php?id=$ideaID&marked=$completed&sub=booboo");
		exit;
	}
?>



<?php mysql_close($connection); ?>