<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['REQUEST_URI']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php include("includes/3ButtonNav.php"); ?>
<?php
	if(isset($_GET['sub'])){
		
		$submissionWas = $_GET['sub'];
		$marked = $_GET['marked'];
		
		if($submissionWas='successful'){
			$alertClass = "alert alert-success";
			$postSubmitMessage = ($marked) ? "Idea marked completed. Well done!" : "Idea marked incomplete.";
			
		}
		else if($submissionWas='booboo'){			 
			$alertClass = "alert alert-error";
			$postSubmitMessage = "Oops! The system made a boo boo. Please give it another go.";
		}
		echo '<div class="'. $alertClass . '"><button class="close" data-dismiss="alert"><span>Cool </span>×</button>' . $postSubmitMessage . '</div>'; 
	}
?>
<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	if(isset($_POST['commentSubmit'])){
		$ideaID = $_POST['ideaID'];
		$comment = $_POST['comment'];
		$user = $_SESSION['email'];
		$time = $_POST['time'];
		$day = $_POST['day'];
		$month = $_POST['month'];
		$dayOfMonth = $_POST['dayOfMonth'];
		$year = $_POST['year'];
		$emails = $_POST['emails'];
		
		$query = "INSERT INTO comments (
				ideaID, comment, user, time, day, month, dayOfMonth, year
			) VALUES (
				'{$ideaID}', '{$comment}', '{$user}', '{$time}', '{$day}', '{$month}', '{$dayOfMonth}', '{$year}'
			)";
		$commentResult = mysql_query($query, $connection);
		if ($commentResult) {
						
			$to      = $emails;
			$subject = $user . ' posted a comment on an idea you are part of';
			$email_message = 'Hi there!' . "\n\n" . 
						$user . ' has posted a comment on an idea that is shared with you.' . "\n\n" .
						'You can access this idea here: http://ideatagr.com/idea.php?id='. $ideaID .  "\n\n" .
						'Happy collaborating!' .  "\n\n" .
						'ideatagr.com' .  "\n\n";
			$headers = 'From: Ideatagr@ideatagr.com' . "\r\n" .
				'Reply-To: Ideatagr@ideatagr.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	
			mail($to, $subject, $email_message, $headers);

			$message = "Note submitted successfully!";
			$alertClass = "alert-success";


		}
	}
?>

<?php
	if(isset($_POST['shareIdea'])){
		$ideaID = $_POST['ideaID'];
		$user = $_SESSION['email'];
		$sharedWith = $_SESSION['idea_access'] . ',' . $_POST['share'];
		
		$shareQuery = "UPDATE ideas SET access='{$sharedWith}' WHERE user='{$user}' AND id='{$ideaID}'";
	
		$shareResult = mysql_query($shareQuery, $connection);
		if ($shareResult) {
			$message = 'Idea shared with ' . $_POST['share'] . ' successfully!';
			$alertClass = "alert-success";
		}
		
		$to      = $_POST['share'];
		$subject = $user . ' would like to share an idea with you on Ideatagr';
		$email_message = 'Hi there!' . "\n\n" . 
					$user . ' has a cool idea and would like to collaborate with you.' . "\n\n" .
					'You can access this idea here: http://ideatagr.com/idea.php?id='. $ideaID .  "\n\n" .
					'Happy collaborating!' .  "\n\n" .
					'ideatagr.com' .  "\n\n";
		$headers = 'From: Ideatagr@ideatagr.com' . "\r\n" .
				'Reply-To: Ideatagr@ideatagr.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $email_message, $headers);
	}
?>

<?php $user = $_SESSION['email']; ?>
<?php if(!empty($message)) {echo '<div class="alert ' . $alertClass . '"><button class="close" data-dismiss="alert"><span>Cool </span>×</button>' . $message . '</div>';} ?>
<div class="container">
	<div class="row">
		<div class="span12">
			<?php
				
				$result = mysql_query("SELECT * FROM ideas WHERE id='{$id}' ORDER BY id LIMIT 1", $connection);
				if(!$result){
					die("Database query failed: " . mysql_error());
				}
				
				
				while ($row = mysql_fetch_array($result)){
					$ideaHits = $row[13];
					$ideaHits = $ideaHits + 1;
					
					$hitQuery = "UPDATE ideas SET hits=hits+1 WHERE user='{$user}' AND id='{$id}'";
		
					$hitResult = mysql_query($hitQuery, $connection);
					if ($hitResult) {
						//echo $ideaHits . 'idea hit added successfully!';
					}
					$access = explode(",", $row[10]);
					if (!in_array($user, $access)){
						echo 'You may not have permission to access this idea.'; 
					}
					
					else if (in_array($user, $access)){
						$sharedIcon = (count($access)>1) ? '<i class="icon sharedIcon">E</i><i class="icon sharedIcon">E</i>' : '';
						$ideaTags = '';
						$tags = explode(",", $row[6]);
						
						foreach ($tags as $individualTag) {
							$ideaLinkEndTag = ($individualTag == end($tags) ? '</a>' : '</a>, ');
							$ideaTags .=  '<a href="search.php?search='.trim($individualTag).'">'.$individualTag.$ideaLinkEndTag;
						}
						
						$completedClass = ($row[11]) ? 'completedIdeaRow' : 'inCompletedIdeaRow';
						$completedDate = ($row[11]) ? ' <span class="ideaTimeDateCompleted"> (Completed on:'.$row[12].')</span> ' : '';
						
						$_SESSION['idea_access'] = $row[10];
						
						echo '<div class="ideaRowIndividual '.$completedClass.'"><span class="ideaTimeDate">'.$row[3].' on '.$row[7].' '.$row[8].', '.$row[9].'</span><span class="ideaLocation">'.$row[5].'</span><span class="ideaBody">'.$row[2].'</span><span class="ideaTags">Tags: '.$ideaTags.'</span>'.$completedDate.'
						<div class="clearfix ideaFunctions topMargin bottomMargin">';
							if(!$row[11]){
								echo '<div class="ideaFunctionButton pull-left rightMargin"><button class="btn btn-small btn-success" type="button" onclick="javascript:window.location.href=\'mark_idea_status.php?id='.$row[0].'&completed=1\'"><span class="ideaFunctionIcon">Q</span> Mark Complete</button></div>';
							}
							else{
								echo '<div class="ideaFunctionButton pull-left rightMargin"><button class="btn btn-small btn-primary" type="button" onclick="javascript:window.location.href=\'mark_idea_status.php?id='.$row[0].'&completed=0\'"><span class="ideaFunctionIcon">S</span> Mark Incomplete</button></div>';
							}
							
							
							echo '<div class="ideaFunctionButton rightMargin"><button class="btn btn-small" type="button" onclick="javascript:window.location.href=\'index.php?action=edit&id='.$row[0].'\'"><span class="ideaFunctionIcon">a</span> Edit</button></div>';
							echo '<div class="ideaFunctionButton rightMargin">
									<div class="btn-group">
									  <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
										Color Tag
										<span class="caret"></span>
									  </a>
									  <ul class="dropdown-menu">
										<li>color 1</li>
										<li>color 2</li>
										<li>color 3</li>
										<li>color 4</li>
									  </ul>
									</div>
							</div>';
							echo '<div class="ideaFunctionButton pull-right"><button class="btn btn-small btn-danger" type="button" onclick="javascript:window.location.href="><span class="ideaFunctionIcon">l</span> Delete</button></div>
						</div></div>';
						
		echo '</div>
			</div>
			<div class="row">
				<div class="span8">
		';
		
						
						$result = mysql_query("SELECT * FROM comments WHERE ideaID='{$id}' ORDER BY id", $connection);
						if(!$result){
							die("Database query failed: " . mysql_error());
						}
						
						$commentCountResult = mysql_query("SELECT *, COUNT(*) AS commentCount FROM comments WHERE ideaID='{$id}' ORDER BY id", $connection);
						$commentCountRow = mysql_fetch_assoc($commentCountResult);
						$totalComments = $commentCountRow['commentCount'];
						
						echo '<p>'.$totalComments.' note(s)</p>';
						echo '<ul class="commentSection">';
						while ($row = mysql_fetch_array($result)){
							
							if(empty($row)){
								echo 'No notes submitted yet.';
							}
							
							echo '<li><blockquote class='.$markCompleted.'>'.$row[2].'<small>'.$row[3].'</small></blockquote></li>';
						}
						echo "</ul>";
						
						echo'<form action="idea.php?id='.$id.'" method="post" class="form-vertical ideaForm commentForm topMargin">
							
							<input class="span8" id="ideaID" name="ideaID" type="hidden" placeholder="ideaID" value="'.$id.'">
							<input class="span8" id="month" name="month" type="hidden" placeholder="current month">
							<input class="span8" id="dayOfMonth" name="dayOfMonth" type="hidden" placeholder="current day of month">
							<input class="span8" id="year" name="year" type="hidden" placeholder="current year">
							
							<input class="span8" id="time" name="time" type="hidden" placeholder="time of the day">
							<input class="span8" id="day" name="day" type="hidden" placeholder="day of the week">
							<input class="span8" id="emails" name="emails" type="hidden" placeholder="emails" value="'.implode(", ", $access).'">
							
							<textarea class="span8" id="comment" name="comment" rows="4" cols="50" placeholder="Leave a note on this idea"></textarea>	
							
							<input class="span8" id="user" name="user" type="hidden" placeholder="Your name please" value="'.$user.'"/>
							<button class="btn stashItButton btn-success" id="submitButton" type="submit" value="Save Note" name="commentSubmit">Save Note</button>

						</form>';
				 	echo'
					</div>
					<div class="span4 shareSection">
						<strong>Share this idea</strong>';
						
						echo'<form action="idea.php?id='.$id.'&action=shared" method="post" class="form-vertical shareForm topMargin">
							<input class="span4" id="ideaID" name="ideaID" type="hidden" placeholder="ideaID" value="'.$id.'">
							<input class="span4" id="user" name="user" type="hidden" placeholder="Your name please" value="'.$user.'"/>
							
							<input class="span4" id="share" name="share" type="text" placeholder="Enter an email address to share this idea">
							<button class="btn shareButton" id="shareIdea" type="submit" value="Share Idea" name="shareIdea">Share Idea</button>
						</form>
						
						<hr/>
						<strong>Users on this idea</strong><br/></br>
						<ul>
						';
						
						foreach($access as $key => $val) {
							if($key === 0) {echo '<li>'.$val.' (creator)</li>';}      
							else {echo '<li>'.$val.'</li>';}
						  
						}
						echo'
						</ul>
					</div>	';
					}
					
					
				}
			?>
		
		
	
			
		
	</div>

<?php require("includes/footer.php"); ?>