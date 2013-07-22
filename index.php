<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['PHP_SELF']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php include("includes/3ButtonNav.php"); ?>
<?php
	if(isset($_GET['sub'])){
		
		$submissionWas = $_GET['sub'];
		
		if($submissionWas='successful'){
			$alertClass = "alert alert-success";
			$postSubmitMessage = "Stashed successfully! You are on a roll!";
			
		}
		else if($submissionWas='booboo'){			 
			$alertClass = "alert alert-error";
			$postSubmitMessage = "Oops! The system made a boo boo. Please give it another go.";
		}
		echo '<div class="'. $alertClass . '"><button class="close" data-dismiss="alert"><span>Cool </span>×</button>' . $postSubmitMessage . '</div>'; 
	}
?>
<?php $user = $_SESSION['email']; ?>
<div class="container">
	
	<!-- <?php echo "Signed in as: " . $user . "(id: " . $_SESSION['user_id'] . ")"; ?> -->
	<div class="row">
		<div class="span12">
			<?php 
				if(isset($_GET['action'])){
					$action = $_GET['action']; 
					//echo 'the action is: '.$action;
				
					if($action='edit'){
						$ideaID = $_GET['id'];
						$result = mysql_query("SELECT * FROM ideas WHERE user='{$user}' AND id='{$ideaID}' LIMIT 1", $connection);
						if(!$result){
							die("Database query failed: " . mysql_error());
						}
						
						while ($row = mysql_fetch_array($result)){
							
							if(!empty($row)){
						
								echo '
								<form action="edit_idea.php" method="post" class="form-vertical ideaForm">
								
									<label>Make changes to your idea below</label>
									
									<input class="span11" id="ideaID" name="ideaID" type="hidden" placeholder="ideaID" value="'.$ideaID.'">
									
									<textarea class="span12" id="ideaField" name="idea" rows="4" cols="50" placeholder="" autofocus>'.$row[2].'</textarea>	
									Tags (comma separated)
									<input class="span12" id="tags" name="tags" type="text" value="'.$row[6].'">
									<button class="btn btn-success stashItButton" id="submitButton" type="submit" value="Stash it!" name="ideaSubmit">Stash it!</button>
								
								</form>	';
							}
						}
					}
				}
				else if(!isset($_GET['action'])){
					echo '
						<form action="create_idea.php" method="post" class="form-vertical ideaForm">
						
							<input class="span11" id="month" name="month" type="hidden" placeholder="current month">
							<input class="span11" id="dayOfMonth" name="dayOfMonth" type="hidden" placeholder="current day of month">
							<input class="span11" id="year" name="year" type="hidden" placeholder="current year">
							
							<input class="span11" id="time" name="time" type="hidden" placeholder="time of the day">
							<input class="span11" id="day" name="day" type="hidden" placeholder="day of the week">
							<input class="span11" id="location" name="location" type="hidden" placeholder="approximate location">
							<label>What\'s your big idea?</label>

							<textarea class="span12" id="ideaField" name="idea" rows="4" cols="50" placeholder="" autofocus></textarea>	
							Tag your idea (comma separated)
							<input class="span12" id="tags" name="tags" type="text">
							<button class="btn btn-success stashItButton" id="submitButton" type="submit" value="Stash it!" name="ideaSubmit">Stash it!</button>
						
						</form>	';
				}
				
			?>
		</div>
	</div>
	

<?php require("includes/footer.php"); ?>
