<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$user = $_SESSION['email'];
	$idea = $_POST['idea'];
	$tags = $_POST['tags'];
	$ideaID = $_POST['ideaID'];

	
	$query = "UPDATE ideas SET idea='{$idea}', tags='{$tags}' WHERE user='{$user}' AND id='{$ideaID}'";
	
	if (mysql_query($query, $connection)) {
		header("Location: idea.php?id=$ideaID");
		exit;
		
	} else {
		header("Location: index.php?sub=booboo");
		exit;
	}
?>



<?php mysql_close($connection); ?>