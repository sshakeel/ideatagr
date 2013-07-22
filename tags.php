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
		$isPinned = $_GET['isPinned'];
		
		if($submissionWas='successful'){
			$alertClass = "alert alert-success";
			$postSubmitMessage = ($isPinned) ? "Tagged pinned Successfully!" : "Selected tag was unpinned.";
			
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
	<div class="row">
		<div class="span12">
			<h3>Pinned Tags:</h3>
			<?php
				$pinnedResult = mysql_query("SELECT * FROM pinned WHERE user='{$user}' ORDER BY pinned ASC", $connection);
				if(!$pinnedResult){
					die("Database query failed: " . mysql_error());
				}
				$pinnedTags = array();
				while ($pinnedRow = mysql_fetch_array($pinnedResult)){
					if(empty($pinnedRow) OR ($pinnedRow[2]==NULL) OR !isset($pinnedRow)){
						echo 'No tags have been pinned yet.';
					}
					
					$pinnedTagRow = explode(",", $pinnedRow[2]);
					foreach($pinnedTagRow as $eachRowPinnedTag){
						$eachRowPinnedTag = trim($eachRowPinnedTag);
						if($eachRowPinnedTag!=""){array_push($pinnedTags, $eachRowPinnedTag);}
					}
				}
				$cleanedPinnedTags = array_unique($pinnedTags);
				sort($cleanedPinnedTags);
				echo '<ul class="pinnedTagsListing">';
					foreach($cleanedPinnedTags as $indPinnedTags) {
						echo '<li>
									<a href="search.php?search='.$indPinnedTags.'">'.$indPinnedTags.'</a>
									<button class="btn btn-small" type="button" onclick="javascript:window.location.href=\'pin_idea.php?action=unpin&pintag='.$indPinnedTags.'\'"><span class="icon">N</span></button>
						
						</li>';
					}
				echo '</ul>';
				
			?>
		</div>
	</div>
	<div class="row topMargin">
		<div class="span12">
			<h4>All Tags</h4>
			<?php
				$result = mysql_query("SELECT * FROM ideas WHERE user='{$user}' ORDER BY tags ASC", $connection);
				if(!$result){
					die("Database query failed: " . mysql_error());
				}
				$userTags = array();
				while ($row = mysql_fetch_array($result)){
					if(empty($row)){
						echo 'No ideas have been submitted <a href="index.php">yet</a>.';
					}
					
					$tagRow = explode(",", $row[6]);
					foreach($tagRow as $eachRowTag){
						$eachRowTag = trim($eachRowTag);
						if($eachRowTag!=""){array_push($userTags, $eachRowTag);}
					}
				}
				$cleanedTags = array_unique($userTags);
				sort($cleanedTags);
				echo '<ul class="allTagsListing">';
					foreach($cleanedTags as $indTags) {
						
						echo '<li>
									<a href="search.php?search='.$indTags.'">'.$indTags.'</a>
									<button class="btn btn-small" type="button" onclick="javascript:window.location.href=\'pin_idea.php?action=pin&pintag='.$indTags.'\'"><span class="icon">I</span></button>
							</li>';
					}
				echo '</ul>';
				
			?>
		</div>
	</div>

<?php require("includes/footer.php"); ?>