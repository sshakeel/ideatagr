<?php require_once("includes/session.php"); ?>
<?php $_SESSION['last_url'] = $_SERVER['REQUEST_URI']; ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php include("includes/3ButtonNav.php"); ?>
<?php $user = $_SESSION['email']; ?>
<?php if(!empty($message)) {echo '<div class="alert ' . $alertClass . '"><button class="close" data-dismiss="alert"><span>Cool </span>?</button>' . $message . '</div>';} ?>

<script>
    var today = moment().format('MMMM D YYYY');
    var dayToday = moment().format('D');
    var thisMonth = moment().format('MMMM');
    var thisYear = moment().format('YYYY');
    
    /*
$(document).ready(function(){
		  $('#today').append('(').append(today).append(')');
	});
*/
</script>
<?php 
	if ($user == "shakeels22@gmail.com" || $user == "salman@sshakeel.ca" || $user == "kevin_timms@hotmail.com"){
		$today = date('l j F Y');
		
		$dayNow = date('j');
		$monthNow = date('F');
		$yearNow = date('Y');
		
		$thisWeek = strtotime('last week');
		
		// **********************
		$user_result = mysql_query("SELECT * FROM users WHERE last_login LIKE '{$today}%'", $connection);
		
		if(!$user_result){
			die("Database query failed: " . mysql_error());
		}
		
		$usersLoggedInToday = 0;
		while ($user_row = mysql_fetch_array($user_result)){
			$usersLoggedInToday++;
			$loggedIn[] = $user_row[1];
		}
		
		// **********************
		$registered_result = mysql_query("SELECT * FROM users WHERE registered LIKE '{$today}%'", $connection);
		
		if(!$registered_result){
			die("Database query failed: " . mysql_error());
		}
		
		$usersRegisteredToday = 0;
		while ($user_row = mysql_fetch_array($registered_result)){
			$usersRegisteredToday++;
			$registered[] = $user_row[1];
		}
		// **********************
		
		$ideas_result = mysql_query("SELECT * FROM ideas WHERE month='{$monthNow}' AND dayOfMonth='{$dayNow}' AND year='{$yearNow}'", $connection);
		
		if(!$ideas_result){
			die("Database query failed: " . mysql_error());
		}
		
		$ideasToday = 0;
		while ($user_row = mysql_fetch_array($ideas_result)){
			$ideasToday++;
		}
		
		// **********************
		$month_user_result = mysql_query("SELECT * FROM users WHERE last_login LIKE '%{$monthNow}%'", $connection);
		
		if(!$month_user_result){
			die("Database query failed: " . mysql_error());
		}
		
		$usersLoggedInThisMonth = 0;
		while ($month_user_row = mysql_fetch_array($month_user_result)){
			$usersLoggedInThisMonth++;
			$loggedInThisMonth[] = $month_user_row[1];
		}
		// **********************
		$month_registered_result = mysql_query("SELECT * FROM users WHERE registered LIKE '%{$monthNow}%'", $connection);
		
		if(!$month_registered_result){
			die("Database query failed: " . mysql_error());
		}
		
		$usersRegisteredThisMonth = 0;
		while ($month_registered_row = mysql_fetch_array($month_registered_result)){
			$usersRegisteredThisMonth++;
			$registeredInThisMonth[] = $month_registered_row[1];
		}
		// **********************
		
		$month_ideas_result = mysql_query("SELECT * FROM ideas WHERE month='{$monthNow}'", $connection);
		
		if(!$month_ideas_result){
			die("Database query failed: " . mysql_error());
		}
		
		$ideasThisMonth = 0;
		while ($user_row = mysql_fetch_array($month_ideas_result)){
			$ideasThisMonth++;
		}
		
		// **********************
		$all_user_result = mysql_query("SELECT * FROM users", $connection);
		
		if(!$all_user_result){
			die("Database query failed: " . mysql_error());
		}
		
		$allUsersLoggedIn = 0;
		while ($all_user_row = mysql_fetch_array($all_user_result)){
			$allUsersLoggedIn ++;
			$allLoggedIn[] = $all_user_row[1];
		}
		
		// **********************
		
		$all_ideas_result = mysql_query("SELECT * FROM ideas", $connection);
		
		if(!$all_ideas_result){
			die("Database query failed: " . mysql_error());
		}
		
		$allIdeas = 0;
		while ($all_ideas_row = mysql_fetch_array($all_ideas_result)){
			$allIdeas++;
		}
		
		echo'
			<div class="container">
				<div class="row">
					<div class="span12"><h3>Today <span id="today">('.$today.')</span></h3></div>
					<div class="span4 infoBox bottomMargin">
						Users Signed In: <strong>'.$usersLoggedInToday.'</strong><br/>';
				if(isset($loggedIn) && !empty($loggedIn)){
					foreach($loggedIn as $eachLoggedInUser)	{
						echo '<br/>' . $eachLoggedInUser;
					}	
				}
		echo 	'</div>
					<div class="span4 infoBox bottomMargin">
						Users Registered: <strong>'.$usersRegisteredToday.'</strong><br/>';
				if(isset($registered) && !empty($registered)){
					foreach($registered as $eachRegisteredUser)	{
						echo '<br/>' . $eachRegisteredUser;
					}	
				}
		echo 	'</div>
					<div class="span4 infoBox bottomMargin">
						Total Ideas: <strong>'.$ideasToday.'</strong><br/>
						
			
					</div>
				</div>
				
				<div class="row">
					<div class="span12"><h3>This Month (' . $monthNow . ')</h3></div>
					<div class="span4 infoBox bottomMargin">
						Users Signed In: <strong>' . $usersLoggedInThisMonth . '</strong><br/>';
				if(isset($loggedInThisMonth) && !empty($loggedInThisMonth)){
					foreach($loggedInThisMonth as $eachLoggedInUserThisMonth)	{
						echo '<br/>' . $eachLoggedInUserThisMonth;
					}	
				}
		echo 	'</div>
					<div class="span4 infoBox bottomMargin">
						Users Registered: <strong>' . $usersRegisteredThisMonth . '</strong><br/>';
				if(isset($registeredInThisMonth) && !empty($registeredInThisMonth)){
					foreach($registeredInThisMonth as $eachRegisteredUserThisMonth)	{
						echo '<br/>' . $eachRegisteredUserThisMonth;
					}	
				}
		echo 	'</div>
					<div class="span4 infoBox bottomMargin">
						Total Ideas: <strong>' . $ideasThisMonth . '</strong><br/>
						
			
					</div>
				</div>
				<div class="row">
					<div class="span12"><h3>All Time</h3></div>
					<div class="span4 infoBox bottomMargin">
						Users: <strong>' . $allUsersLoggedIn . '</strong><br/>
					</div>
					
					<div class="span4 infoBox bottomMargin">
						Total Ideas: <strong>' . $allIdeas . '</strong><br/>
						
			
					</div>
				</div>
			</div>
		';
	}
	else{
		echo'
			<div class="container">
				<div class="row">
					<div class="span12">
					
						<p>Permission Denied.</p>
						
			
					</div>
				</div>
			</div>
		';
	}
?>

<?php require("includes/footer.php"); ?>