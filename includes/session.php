<?php
	session_start();

	function logged_in() {
		return isset($_SESSION['user_id']);
		//this can be used to perform more sophisticated checks for user session ID. Perhaps check for premium users.
	}
	function confirm_logged_in() {
		// $theURL = 'login.php'.$url;
		
		if (!logged_in()){
			
			
			redirect_to('login.php');
		}
	}
?>