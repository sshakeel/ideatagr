<!DOCTYPE html>
<html>
	<head>
	<title>Ideatagr</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
	<meta name="description" content="Ideatagr is a Google Keep alternative that lets you jot down your ideas quickly and see what circumstances inspire them.">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/style.css?<?php echo date("Y-m-d-H:i:s"); ?>">
<!-- js scripts are being called in footer.php-->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/masonry.js"></script>
	<script src="js/moment.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		
		$(document).ready(function(){
		  $('#content').masonry({
			// options
			itemSelector : '.ideaRow',
			columnWidth : 160
		  });
		});
		
		
	</script>
	<?php 
		$user = $_SESSION['email']; 
		if ($user=='casstavares@hotmail.com'){ //
			echo '<link rel="stylesheet" href="css/cass.css">';
		}
	?>
	
	</head>
	<?php include_once("analyticstracking.php") ?>
	<body>
	
		<header class="">
			
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="index.php"><img src="img/ideatagr-logo-beta.png" /></a>
						
						<form action="search.php" method="post" class='navbar-search pull-right <?php if (!logged_in()) {echo 'hide';} ?>' >
						  <input id="search-term" name="search-term" type="text" class="search-query" placeholder="Search ideas, tags or location">
						  <button type="submit" class="btn btn-mini searchSubmit"><span class="icon">H</span></button>
						</form>
						
					</div>
					
				</div>
			</div>

		