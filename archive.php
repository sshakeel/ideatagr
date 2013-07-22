<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['PHP_SELF']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php include("includes/3ButtonNav.php"); ?>
<?php $user = $_SESSION['email']; ?>

<div class="container">
	<div class="row">
		<div class="span12">
			<div class="filters">
				<span><label><input id="hide-completed" type="checkbox"/>Hide Completed</label></span>
				<!-- <span><label><input id="heat-map" type="checkbox"/>Heat Map Mode</label></span> -->
			</div>
		</div>
		<div class="span12">
			<div id="content">
			<?php
				$result = mysql_query("SELECT * FROM ideas WHERE user='{$user}' ORDER BY hits DESC", $connection);
				if(!$result){
					die("Database query failed: " . mysql_error());
				}
				while ($row = mysql_fetch_array($result)){
					
					if(empty($row)){
						echo 'No ideas have been submitted <a href="index.php">yet</a>.';
					}
					
					$access = explode(",", $row[10]);
					$sharedIcon = (count($access)>1) ? '<i class="icon sharedIcon">E</i><i class="icon sharedIcon">E</i>' : '';
					
					$ideaTags = '';
					$tags = explode(",", $row[6]);
					
					foreach ($tags as $individualTag) {
						$ideaLinkEndTag = ($individualTag == end($tags) ? '</a>' : '</a>, ');
						$ideaTags .=  '<a href="search.php?search='.trim($individualTag).'">'.$individualTag.$ideaLinkEndTag;
					}
					
					if($row[13] > 14){$sizeClass="bigIdea";}
					else if($row[13] > 9 && $row[13] < 15){$sizeClass="mediumIdea";}
					else if($row[13] < 10){$sizeClass="smallIdea";}
					
					$completedClass = ($row[11]) ? 'completedIdeaRow' : 'inCompletedIdeaRow';
					$completedDate = ($row[11]) ? ' <span class="ideaTimeDateCompleted"> (Completed on:'.$row[12].')</span> ' : '';
					
					echo '<div hits="'.$row[13].'" class="box ideaRow '.$sizeClass.' '.$completedClass.'" onclick="javascript:window.location.href=\'idea.php?id='.$row[0].'\'"><span class="ideaBodyArchive">'.$row[2].'</span><span class="ideaTagsArchive">Tags: '.$ideaTags.'</span>'.$sharedIcon.'</div>';
				} 
			?>
			</div>
		</div>
		<div class="span12">
			<h2>Shared Stash:</h2>
			<div id="content">
			<?php
				$sharedResult = mysql_query("SELECT * FROM ideas WHERE access LIKE '%" . $user . "%' AND NOT (user='{$user}') ORDER BY hits DESC", $connection);
				if(!$sharedResult){
					die("Database query failed: " . mysql_error());
				}
				while ($sharedRow = mysql_fetch_array($sharedResult)){
					
					if(empty($sharedRow)){
						echo 'No ideas have been shared with you yet.';
					}
					
					$ideaTags = '';
					$tags = explode(",", $sharedRow[6]);
					
					foreach ($tags as $individualTag) {
						$ideaLinkEndTag = ($individualTag == end($tags) ? '</a>' : '</a>, ');
						$ideaTags .=  '<a href="search.php?search='.trim($individualTag).'">'.$individualTag.$ideaLinkEndTag;
					}
					
					if($sharedRow[13] > 14){$sizeClass="bigIdea";}
					else if($sharedRow[13] > 9 && $sharedRow[13] < 15){$sizeClass="mediumIdea";}
					else if($sharedRow[13] < 10){$sizeClass="smallIdea";}
					
					$completedClass = ($sharedRow[11]) ? 'completedIdeaRow' : 'inCompletedIdeaRow';
					$completedDate = ($sharedRow[11]) ? ' <span class="ideaTimeDateCompleted"> (Completed on:'.$sharedRow[12].')</span> ' : '';
					
					echo '<div hits="'.$sharedRow[13].'" class="box ideaRow '.$sizeClass.' '.$completedClass.'" onclick="javascript:window.location.href=\'idea.php?id='.$sharedRow[0].'\'"><span class="ideaBodyArchive">'.$sharedRow[2].'</span><span class="ideaTagsArchive">Tags: '.$ideaTags.'</span></div>';
				} 
			?>
			</div>
		</div>
	</div>

<?php require("includes/footer.php"); ?>