<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$user = $_SESSION['email'];
	$tagToPin = $_GET['pintag'];
	$action = $_GET['action'];
	 
	
	$pinnedResult = mysql_query("SELECT * FROM pinned WHERE user='{$user}' ORDER BY pinned ASC", $connection);
	if(!$pinnedResult){
		die("Database query failed: " . mysql_error());
	} 
	$pinnedTags = array();
	while ($pinnedRow = mysql_fetch_array($pinnedResult)){
		$pinnedTagRow = explode(",", $pinnedRow[2]);
		foreach($pinnedTagRow as $eachRowPinnedTag){
			$eachRowPinnedTag = trim($eachRowPinnedTag);
			if($eachRowPinnedTag!=""){array_push($pinnedTags, $eachRowPinnedTag);}
		}
	}
	
	if($action == 'pin'){
		array_push($pinnedTags, $tagToPin);
		$isPinned = 1;
	}
	elseif ($action == 'unpin'){
		if(($key = array_search($tagToPin, $pinnedTags)) !== false) {
			unset($pinnedTags[$key]);
		}
		$isPinned = 0;
	}
	
	$finalPinnedList = '';
	
	foreach($pinnedTags as $textTag){
		$finalPinnedList .= $textTag.',';
	}
	
	
	
	$updateQuery = "UPDATE pinned SET pinned='{$finalPinnedList}' WHERE user='{$user}'";
	
	if (mysql_query($updateQuery, $connection)) {
		header("Location: tags.php?sub=successful&isPinned=$isPinned");
		exit;
		
	} else {
		header("Location: tags.php?sub=booboo&isPinned=$isPinned");
		exit;
	}
?>



<?php mysql_close($connection); ?>