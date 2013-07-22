<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['PHP_SELF']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<div class="container">
	<div class="row">
		<div class="span12">
			<h2 class="bottomMargin">Change Log</h2>
			<ul>
				<li><blockquote>Users can now share an idea with another person by specifying their email address.<small>Feb 24, 2013</small></blockquote></li>
				<li><blockquote>System now remembers the URL that was being accessed before user logs in.<small>Feb 24, 2013</small></blockquote></li>
				<li><blockquote>Implemented a feature called "pin a tag" under tags section. This is to let users "pin" their most valuable tags to serve as categories. <small>Nov 25, 2012</small></blockquote></li>
				<li><blockquote>Added ability to mark ideas as complete. Adjusted UI to properly reflect completed and incomplete ideas.<small>Nov 25, 2012</small></blockquote></li>
				<li><blockquote>System will now let users know if they have already registered with an email address.<small>Nov 23, 2012</small></blockquote></li>
				<li><blockquote>Added a search button (magnifying glass) beside the search bar to have it as another alternative for searching (besides just pressing enter).<small>Nov 23, 2012</small></blockquote></li>
				<li><blockquote>Added a "New Idea" button to make new idea submission a bit more convenient.<small>Nov 23, 2012</small></blockquote></li>				
				<li><blockquote>Tracking user registered date and time and last login time for better troubleshooting & reporting.<small>Nov 18, 2012</small></blockquote></li>				
				<li><blockquote>Users are now able to take notes (comment) on ideas to better organize the thought process. This will lead to a "collaboration" feature where other users (when allowed) can comment on your ideas as well.<small>Nov 17, 2012</small></blockquote></li>
				<li><blockquote>Archive and Search results now display tags as links. Clicking on a tag will display all ideas under that specific tag<small>Nov 11, 2012</small></blockquote></li>
				<li><blockquote>Stats: The most productive variable displays above its relative graph along with the number of ideas<small>Nov 09, 2012</small></blockquote></li>
				<li><blockquote>Archive: added ability to edit individual ideas<small>Nov 08, 2012</small></blockquote></li>
				<li><blockquote>added ability to auto capture day of the month, month and year along with your idea<small>Nov 02, 2012</small></blockquote></li>
				<li><blockquote>added ability to search ideas by their text, tags, month, year, location<small>Nov 02, 2012</small></blockquote></li>
				<li><blockquote>started a rough foundation of having different themes/color schemes unique to users<small>Nov 02, 2012</small></blockquote></li>
				
			</ul>
		</div>
	</div>
	
	

<?php require("includes/footer.php"); ?>