<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['PHP_SELF']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<?php $user = $_SESSION['email']; ?>
<?php
	if(isset($_POST['featureSubmit'])){
		$suggester = $_POST['featureSuggester'];
		$detail = $_POST['featureDetail'];
		$query = "INSERT INTO features (
							suggester, detail
						) VALUES (
							'{$suggester}', '{$detail}'
						)";
		$result = mysql_query($query, $connection);
		if ($result) {
			$message = "Feature suggestion submitted successfully. Thank you!";
			$alertClass = "alert-success";
		}
	}
?>
<?php if(!empty($message)) {echo '<div class="alert ' . $alertClass . '"><button class="close" data-dismiss="alert">Cool, thanks ×</button>' . $message . '</div>';} ?>
<div class="container">
	<div class="row">
		<div class="span12">
			<form action="features.php" method="post" class="form-vertical ideaForm topMargin">
					
				<textarea class="span12" id="featureDetail" name="featureDetail" rows="4" cols="50" placeholder="Describe your feature" autofocus></textarea>	
				
				<input class="span12" id="featureSuggester" name="featureSuggester" type="text" placeholder="Your name please">
				<button class="btn btn-primary stashItButton" id="submitButton" type="submit" value="Suggest it!" name="featureSubmit">Suggest it!</button>
				<!--
<?php echo POWER_USER; ?>
				<?php echo $user; ?>
-->
			</form>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<?php
				if($user = POWER_USER){
					echo '<hr/>
					<h2 class="bottomMargin">Running list of suggested features</h2>';
				
				
					$result = mysql_query("SELECT * FROM features", $connection);
					if(!$result){
						die("Database query failed: " . mysql_error());
					}
					echo "<ol>";
					while ($row = mysql_fetch_array($result)){
						
						if(empty($row)){
							echo 'No features have been submitted <a href="index.php">yet</a>.';
						}
						
						if ($row[3]) {
							$markCompleted = 'completed';
						} else {
							$markCompleted = '';
						}
						echo '<li><blockquote class='.$markCompleted.'>'.$row[2].'<small>'.$row[1].'</small></blockquote></li>';
					}
					echo "</ol>";
				}
				
			?>
		</div>
	</div>
	

<?php require("includes/footer.php"); ?>