<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['PHP_SELF']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php include("includes/3ButtonNav.php"); ?>
<?php $user = $_SESSION['email']; ?>

<?php 
	
	$searchRequest = $_SERVER['REQUEST_METHOD'];
	//echo $searchRequest;
	
	if ($searchRequest = 'POST' && isset($_POST['search-term'])){	
		$searchTerm = $_POST['search-term'];
		//echo $searchTerm;
	}
	else if ($searchRequest = 'GET' && isset($_GET['search'])){
		$searchTerm = $_GET['search'];
		//echo $searchTerm;
	}
	
	
?>

<div class="container">
	<div class="row">
		<div class="span12">
			
			<?php
				$result = mysql_query("SELECT * FROM ideas WHERE (user='{$user}' AND (tags LIKE '%" . $searchTerm . "%' OR idea LIKE '%" . $searchTerm . "%' OR location LIKE '%" . $searchTerm . "%' OR month LIKE '%" . $searchTerm . "%' OR year LIKE '%" . $searchTerm . "%')) ORDER BY hits DESC", $connection);
				if(!$result){
					die("Database query failed: " . mysql_error());
				}
				if(mysql_num_rows($result) > 0) {
					echo '<p class="muted bottomMargin">'.mysql_num_rows($result).' result(s) found for "<strong>' . $searchTerm . '</strong>".</p>';
					echo '<div id="content">';
					while ($row = mysql_fetch_array($result)){
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
						
						echo '<div hits="'.$row[13].'" class="box ideaRow '.$sizeClass.' '.$completedClass.'" onclick="javascript:window.location.href=\'idea.php?id='.$row[0].'\'"><span class="ideaBodyArchive">'.$row[2].'</span><span class="ideaTagsArchive">Tags: '.$ideaTags.'</span></div>';
					}
				}
				else{
					echo '<p class="text-error">Your search "<strong>' . $searchTerm . '</strong>" did not match any ideas.</p>';
				}
			?>
			</div> <!--end of #content-->
		</div>
	</div>

<?php require("includes/footer.php"); ?>

