<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['PHP_SELF']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<?php
	if(isset($_POST['bugSubmit'])){
		$tester = $_POST['bugTester'];
		$detail = $_POST['bugDetail'];
		$query = "INSERT INTO bugs (
							tester, detail
						) VALUES (
							'{$tester}', '{$detail}'
						)";
		$result = mysql_query($query, $connection);
		if ($result) {
			$message = "Bug submitted successfully. Thank you!";
			$alertClass = "alert-success";
		}
	}
?>
<?php if(!empty($message)) {echo '<div class="alert ' . $alertClass . '"><button class="close" data-dismiss="alert">Cool, thanks ×</button>' . $message . '</div>';} ?>
<div class="container">
	<div class="row">
		<div class="span12">
			<form action="bugs.php" method="post" class="form-vertical ideaForm topMargin">
					
				<textarea class="span12" id="bugDetail" name="bugDetail" rows="4" cols="50" placeholder="Describe your bug" autofocus></textarea>	
				
				<input class="span12" id="bugTester" name="bugTester" type="text" placeholder="Your name please">
				<button class="btn btn-danger stashItButton" id="submitButton" type="submit" value="Stash it!" name="bugSubmit">Squash it!</button>

			</form>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<hr/>
			<h2 class="bottomMargin">List of known issues currently plaguing the system</h2>
			
			<?php
				$result = mysql_query("SELECT * FROM bugs", $connection);
				if(!$result){
					die("Database query failed: " . mysql_error());
				}
				echo "<ol>";
				while ($row = mysql_fetch_array($result)){
					
					if(empty($row)){
						echo 'No ideas have been submitted <a href="index.php">yet</a>.';
					}
					
					if ($row[3]) {
						$markCompleted = 'completed';
					} else {
						$markCompleted = '';
					}
					echo '<li><blockquote class='.$markCompleted.'>'.$row[2].'<small>'.$row[1].'</small></blockquote></li>';
				}
				echo "</ol>";
			?>
		</div>
	</div>
	

<?php require("includes/footer.php"); ?>