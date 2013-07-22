		</div>
		<?php if (logged_in()){ echo '<footer class="topMargin bottomMargin"> Beta Actions: <a href="bugs.php" target="_blank">Report a Bug</a> | <a href="features.php" target="_blank">Suggest a Feature</a> | <a href="log.php" target="_blank">View Change Log</a> | <a href="logout.php">Log out</a></footer>';	} ?>
		
		

		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry,weather&sensor=false"></script>
		<script src="js/script.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
		<script src="js/script2.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
		<script src="js/bootstrap-transition.js"></script>
	    <script src="js/bootstrap-alert.js"></script>
	    <script src="js/bootstrap-modal.js"></script>
	    <script src="js/bootstrap-dropdown.js"></script>
	    <script src="js/bootstrap-scrollspy.js"></script>
	    <script src="js/bootstrap-tab.js"></script>
	    <script src="js/bootstrap-tooltip.js"></script>
	    <script src="js/bootstrap-popover.js"></script>
	    <script src="js/bootstrap-button.js"></script>
	    <script src="js/bootstrap-collapse.js"></script>
	    <script src="js/bootstrap-carousel.js"></script>
	    <script src="js/bootstrap-typeahead.js"></script>
		<script src="js/cycle.js"></script>

		<script type="text/javascript" async="" src="js/bootstrap-collapse.js"></script>
		<script>$(".alert").delay(5000).fadeOut('slow');</script>
		<script>
		  $('#myTab a').click(function (e) {
			  e.preventDefault();
			  $(this).tab('show');
			})
			
		  $('#myTab a[href="#login"]').tab('show');
		 
		  $('.dropdown-toggle').dropdown();
		</script>
		<script>
			$('#rotate').cycle();
		</script>
	</body>
</html>
<?php
	// 5. Close connection
	if (isset($connection)){mysql_close($connection);}
?>