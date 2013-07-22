<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connections.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if (logged_in()) {redirect_to("index.php");}
	include_once("includes/form_functions.php");
	
	if(isset($_POST['register'])){
		$errors = array();

		// perform validations on the form data
		$required_fields = array('emailRegister', 'passwordRegister');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('emailRegister' => 30, 'passwordRegister' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$emailRegister = trim(mysql_prep($_POST['emailRegister']));
		$passwordRegister = trim(mysql_prep($_POST['passwordRegister']));
		$hashed_password = sha1($passwordRegister);
		
		$dateRegistered = date('l j F Y h:i:s A');
		
		//checking against duplicate user registration
		$query = "SELECT id, email ";
		$query .= "FROM users ";
		$query .= "WHERE email = '{$emailRegister}' ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query);
		confirm_query($result_set);
		if (mysql_num_rows($result_set) == 1) {
			$userAlreadyExists = true;
			$errors = array_push($errors, "duplicate user detected.");
			
		}
		
		if ( empty($errors) ) {
			
			
			
			
			$query = "INSERT INTO users (
							email, hashed_password, last_login, registered
						) VALUES (
							'{$emailRegister}', '{$hashed_password}', '{$dateRegistered}', '{$dateRegistered}'
						)";
			$result = mysql_query($query, $connection);
			if ($result) {
				$message = "The user was successfully created.";
				$alertClass = "alert-success";
				
				$_SESSION['email'] = $emailRegister;
				$idQuery = "SELECT id FROM users WHERE email = '{$emailRegister}'";
				$idResult = mysql_query($idQuery);
				confirm_query($idResult);
				$newUser = mysql_fetch_array($idResult);
				$_SESSION['user_id'] = $newUser['id'];
				
				$queryPinned = "INSERT INTO pinned (user) VALUES ('{$emailRegister}')";
				$resultPinned = mysql_query($queryPinned, $connection);
				confirm_query($resultPinned);
				
				redirect_to("index.php");
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysql_error();
				$alertClass = "alert-error";
			}
		} else {
			
			
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
				$alertClass = "alert-error";
				if ($userAlreadyExists) {
					$message = "User already exists. Please try to log in with the same email.";
					$alertClass = "alert-error";
				}
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
				$alertClass = "alert-error";
			}
		}

	}
	if (isset($_POST['login'])) { // Login form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('emailLogin', 'passwordLogin');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('emailLogin' => 30, 'passwordLogin' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$emailLogin = trim(mysql_prep($_POST['emailLogin']));
		$passwordLogin = trim(mysql_prep($_POST['passwordLogin']));
		$hashed_password = sha1($passwordLogin);
		
		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT id, email ";
			$query .= "FROM users ";
			$query .= "WHERE email = '{$emailLogin}' ";
			$query .= "AND hashed_password = '{$hashed_password}' ";
			$query .= "LIMIT 1";
			$result_set = mysql_query($query);
			confirm_query($result_set);
			if (mysql_num_rows($result_set) == 1) {
				// username/password authenticated
				// and only 1 match
				$found_user = mysql_fetch_array($result_set);
				$_SESSION['user_id'] = $found_user['id'];
				$_SESSION['email'] = $found_user['email'];
				$loginTime = date('l j F Y h:i:s A');
				//record_login_time($_SESSION['email'], $loginTime);
				$userLoggedin = $_SESSION['email'];
				if(record_login_time($userLoggedin, $loginTime)){
					redirect_to("index.php");
				}
				else{
					echo "something is wrong";
				}
				
			} else {
				// username/password combo was not found in the database
				$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
				$alertClass = "alert-error";
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
				$alertClass = "alert-error";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
				$alertClass = "alert-error";
			}
		}
	}
	else {
		
		if(isset($_GET['logout']) && $_GET['logout'] == 1){
			$message = "You have successfully logged out.";
			$alertClass = "alert-success";
		}
		
		$emailRegister = '';
		$passwordRegister = '';
		
		$emailLogin = '';
		$passwordLogin = '';
	}

?>
<!DOCTYPE html>
<html>
	<head>
	<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
	<link rel="stylesheet" href="css/reset.css">
	<!--<link rel="stylesheet" href="css/bootstrap.css"> 
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/style.css">-->
	<link rel="stylesheet" href="css/landing.css">
<!-- js scripts are being called in footer.php-->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>

</head>
	<body>
		<?php if(!empty($message)) {echo '<div class="alert ' . $alertClass . '"><button class="close" data-dismiss="alert">×</button>' . $message . '</div>';} ?>
		<header class="">
			
			
		</header> 
		<div class="firefly-banner">
			<a href="" class="logo"><img src="img/ideatagr-logo-beta.png" /></a>
			<div class="thePitch">
				<div class="pitchWholeLine">
					<span>Capture your ideas in seconds!</span>
				
					<p>Ideatagr lets you jot down your ideas quickly and see what circumstances inspire them.</p>
					
					<div class="userChoices">
						
						<ul class="nav nav-tabs" id="myTab">
						  <li><a href="#register" name="registerMe" >Register</a></li>
						  <li class="active"><a href="#login">Log in</a></li>
						</ul>
						 
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane" id="register">
							<form action="login.php" method="post" class="form-vertical topMargin registerForm" id="registerForm">
								<h3>Free Sign Up</h3>
								<input class="span11 topMargin bottomMargin" id="emailRegister" name="emailRegister" placeholder="Email" type="text" maxlength="30" value="<?php echo htmlentities($emailRegister); ?>">
								<input class="span11 bottomMargin" id="passwordRegister" name="passwordRegister" placeholder="Password"  type="password" maxlength="30" value="<?php echo htmlentities($passwordRegister); ?>">
								
								<button class="btn btn-success stashItButton" id="Register" type="submit" value="Register" name="register">Register</button>				
								
							</form>
						  </div>
						  <div class="tab-pane active" id="login">
							<form action="login.php" method="post" class="form-vertical topMargin loginForm" id="loginForm">
								<input class="span11 topMargin bottomMargin" id="emailLogin" name="emailLogin" placeholder="Email" type="text">
								<input class="span11 bottomMargin" id="passwordLogin" name="passwordLogin" placeholder="Password"  type="password">
								
								<button class="btn btn-success stashItButton" name="login" id="login" type="submit" value="Log in">Log in</button>				
								
							</form>
						  </div>

						</div>
						 
						
						
						
					</div>
				</div>
			</div>
		</div>
		<div class="features-listing">
			<!-- <p>We're looking to enhance your creativity by reimagining the way you capture ideas.</p>-->
			<h2>How does it work?</h2>
			<ul>
				<li class="type"><span>1. Type</span> Simply type out your idea</li>
				<li class="tag"><span>2. Tag</span>Tag it with relevant keywords</li>
				<li class="analyze"><span>3. Analyze</span>Look at what helped inspired those ideas</li>
			</ul>
		</div>
		<div class="about-stats">
			<h2>Analyze what inspires you to be creative</h2>
			<p>Look at which day of the week, what time of the day and what place brings in the most ideas.</p>
			<ul>
				<li class="day">Most creative on: <span>Thursday</span> <img src="http://ideatagr.com/img/daychart.png"/></li>
				<li class="time">Most creative around: <span>Afternoon</span><img src="http://ideatagr.com/img/timechart.png"/></li>
				<li class="place">Most creative in: <span>Newmarket, ON</span><img src="http://ideatagr.com/img/locationchart.png"/></li>
			</ul>
		</div>
		
		<div class="more-features">
			<h2>Even More Features</h2>
			<ul>
				<li class="pin">Pin Tags</li>
				<li class="notes">Takes Notes</li>
				<li class="responsive">Device Independent Access</li>
				<li class="collab">Share and Collaborating</li>
			</ul>
		</div>
		
		<div class="more-features">
			<a class="register-me" href="#registerMe">Free Sign Up</a>
		</div>
		
<?php require("includes/footer.php"); ?>