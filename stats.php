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
			
			<!-- Creating a chart for Days -->
			
			<?php
				$sunCount = 0;
				$monCount = 0;
				$tueCount = 0;
				$wedCount = 0;
				$thuCount = 0;
				$friCount = 0;
				$satCount = 0;
				
				$result = mysql_query("SELECT * FROM ideas WHERE user='{$user}'", $connection);
				if(!$result){
					die("Database query failed: " . mysql_error());
				}
				
				while ($row = mysql_fetch_array($result)){
					/* echo $row[1]." | ".$row[2]." | ".$row[3]." | ".$row[4]." | ".$row[5]."<br/>"; */
					switch ($row[4]) {
						case "Sunday": $sunCount++; break;
						case "Monday": $monCount++; break;
						case "Tuesday": $tueCount++; break;
						case "Wednesday": $wedCount++; break;
						case "Thursday": $thuCount++; break;
						case "Friday": $friCount++; break;
						case "Saturday": $satCount++; break;
					}
				}
			?>
			
			
			<script type="text/javascript">

		      // Load the Visualization API and the piechart package.
		      google.load('visualization', '1.0', {'packages':['corechart']});
		
		      // Set a callback to run when the Google Visualization API is loaded.
		      google.setOnLoadCallback(drawChart);
		
		      // Callback that creates and populates a data table,
		      // instantiates the pie chart, passes in the data and
		      // draws it.
		      function drawChart() {
		
		        // Create the data table.
		        var dataDay = new google.visualization.DataTable();

				// Declare columns
				dataDay.addColumn('string', 'Day');
				dataDay.addColumn('number', 'Frequency');
				
				// Add data.
				dataDay.addRows([
				  ['Sunday', <?php echo($sunCount); ?>], // Example of specifying actual and formatted values.
				  ['Monday', <?php echo($monCount); ?>],                              // More typically this would be done using a
				  ['Tuesday', <?php echo($tueCount); ?>],                           // formatter.
				  ['Wednesday', <?php echo($wedCount); ?>],
				  ['Thursday', <?php echo($thuCount); ?>],
				  ['Friday', <?php echo($friCount); ?>],
				  ['Saturday', <?php echo($satCount); ?>]
				]);
		
		        // Set chart options
		        var dayOptions = {'width':360,
		                       'height':210};
		
		        // Instantiate and draw our chart, passing in some options.
		        var dayChart = new google.visualization.PieChart(document.getElementById('day-chart'));
		        dayChart.draw(dataDay, dayOptions);
		      }
		    </script>
		    
			<!--   Creating a chart for Location -->
			<?php
			$result = mysql_query("SELECT location, COUNT(location) as locationCount FROM ideas WHERE user='{$user}' GROUP BY location ORDER BY COUNT(location) DESC", $connection);
			
				if(!$result){
					die("Database query failed: " . mysql_error()); 
				}
				//$row = mysql_fetch_assoc($result);
				
				while($row = mysql_fetch_assoc($result)) { 
					$locationArray[] = $row['location'];
					$locationFrequency[] = $row['locationCount'];
				}
				
				$firstCity = (!empty($locationArray[0]) ? $locationArray[0] : ''); 
				$secondCity = (!empty($locationArray[1]) ? $locationArray[1] : ''); 
				$thirdCity = (!empty($locationArray[2]) ? $locationArray[2] : ''); 
				$fourthCity = (!empty($locationArray[3]) ? $locationArray[3] : ''); 
				$fifthCity = (!empty($locationArray[4]) ? $locationArray[4] : ''); 	
								
				$city1Count = (!empty($locationFrequency[0]) ? $locationFrequency[0] : 0);
				$city2Count = (!empty($locationFrequency[1]) ? $locationFrequency[1] : 0);
				$city3Count = (!empty($locationFrequency[2]) ? $locationFrequency[2] : 0);
				$city4Count = (!empty($locationFrequency[3]) ? $locationFrequency[3] : 0);
				$city5Count = (!empty($locationFrequency[4]) ? $locationFrequency[4] : 0);
								
			?>
			<script type="text/javascript">

		      // Load the Visualization API and the piechart package.
		      google.load('visualization', '1.0', {'packages':['corechart']});
		
		      // Set a callback to run when the Google Visualization API is loaded.
		      google.setOnLoadCallback(drawChart);
		
		      // Callback that creates and populates a data table,
		      // instantiates the pie chart, passes in the data and
		      // draws it.
		      function drawChart() {
		
		        // Create the data table.
		        var dataLocation = new google.visualization.DataTable();

				// Declare columns
				dataLocation.addColumn('string', 'Location');
				dataLocation.addColumn('number', 'Frequency');
				
				// Add data.
				dataLocation.addRows([
				  ["<?php echo($firstCity); ?>", <?php echo($city1Count); ?>], // Example of specifying actual and formatted values.
				  ["<?php echo($secondCity); ?>", <?php echo($city2Count); ?>],                              // More typically this would be done using a
				  ["<?php echo($thirdCity); ?>", <?php echo($city3Count); ?>],                           // formatter.
				  ["<?php echo($fourthCity); ?>", <?php echo($city4Count); ?>],
				  ["<?php echo($fifthCity); ?>", <?php echo($city5Count); ?>]
				]);
		
		        // Set chart options
		        var locationOptions = {'width':360,
		                       'height':210};
		
		        // Instantiate and draw our chart, passing in some options.
		        var locationChart = new google.visualization.PieChart(document.getElementById('location-chart'));
		        locationChart.draw(dataLocation, locationOptions);
		      }
		    </script>
		    
		    <!--   Creating a chart for Hours -->
			<?php
				$timeFrequency["Morning"] = 0; //morning from 5am to 11:44
				$timeFrequency["Afternoon"] = 0; //afternoon from 11:45am to 5:30pm
				$timeFrequency["Evening"] = 0; //evening from 5:31pm to 9pm
				$timeFrequency["Night"] = 0; //night from 9:01pm to 11:59pm
				$timeFrequency["Late-Night"] = 0; //late night from 12am to 4:59am
				
				$result = mysql_query("SELECT * FROM ideas WHERE user='{$user}'", $connection);
			
				if(!$result){
					die("Database query failed: " . mysql_error()); 
				}		
				while ($row = mysql_fetch_array($result)){
					switch (time_interval($row[3])) {
						case "Morning": $timeFrequency["Morning"]++; break;
						case "Afternoon": $timeFrequency["Afternoon"]++; break;
						case "Evening": $timeFrequency["Evening"]++; break;
						case "Night": $timeFrequency["Night"]++; break;
						case "Late Night": $timeFrequency["Late-Night"]++; break;
					}
				}
				
				
			?>
			
			<script type="text/javascript">

		      // Load the Visualization API and the piechart package.
		      google.load('visualization', '1.0', {'packages':['corechart']});
		
		      // Set a callback to run when the Google Visualization API is loaded.
		      google.setOnLoadCallback(drawChart);
		
		      // Callback that creates and populates a data table,
		      // instantiates the pie chart, passes in the data and
		      // draws it.
		      function drawChart() {
		
		        // Create the data table.
		        var dataTime = new google.visualization.DataTable();

				// Declare columns
				dataTime.addColumn('string', 'Interval');
				dataTime.addColumn('number', 'Frequency');
				
				// Add data.
				dataTime.addRows([
				  ["Morning", <?php echo $timeFrequency["Morning"]; ?>], // Example of specifying actual and formatted values.
				  ["Afternoon", <?php echo $timeFrequency["Afternoon"]; ?>],                              // More typically this would be done using a
				  ["Evening", <?php echo $timeFrequency["Evening"]; ?>],                           // formatter.
				  ["Night", <?php echo $timeFrequency["Night"]; ?>],
				  ["Late Night", <?php echo $timeFrequency["Late-Night"]; ?>]
				]);
		
		        // Set chart options
		        var timeOptions = {'width':360,
		                       'height':210};
		
		        // Instantiate and draw our chart, passing in some options.
		        var timeChart = new google.visualization.PieChart(document.getElementById('time-chart'));
		        timeChart.draw(dataTime, timeOptions);
		      }
		    </script>
			
			<?php
				
				//most creative day
				$topDay = mysql_query("SELECT day, COUNT(day) AS dayCount FROM ideas WHERE user='{$user}' GROUP BY day ORDER BY COUNT(*) DESC LIMIT 1");
				$topDayRow = mysql_fetch_assoc($topDay);
				$mostCreativeDay = $topDayRow['day'];
				$ideasCountDay = $topDayRow['dayCount'];
				
				//most creative location
				$topLocation = mysql_query("SELECT location, COUNT(location) AS locationCount FROM ideas WHERE user='{$user}' GROUP BY location ORDER BY COUNT(*) DESC LIMIT 1");
				$topLocationRow = mysql_fetch_assoc($topLocation);
				$mostCreativeLocation = $topLocationRow['location'];
				$ideasCountLocation = $topLocationRow['locationCount'];
				
				
				//most creative time of the day
				$mostCreativeTime = array_search(max($timeFrequency), $timeFrequency);
				$ideasCountTime = max($timeFrequency);
			?>
			
			
		    <div class="statInfoRow bottomMargin">
				<div class="statInfoHeader">Most Creative On: <span><?php echo $mostCreativeDay.' ('.$ideasCountDay.' ideas)'; ?></span></div>
				<div id="day-chart" class="chartContainer"></div>
			</div>
			
			<div class="statInfoRow bottomMargin">
				<div class="statInfoHeader">Most Creative In: <span><?php echo $mostCreativeLocation.' ('.$ideasCountLocation.' ideas)'; ?></span></div>
				<div id="location-chart" class="chartContainer"></div>
			</div>
			
			<div class="statInfoRow bottomMargin">
				<div class="statInfoHeader">Most Creative Around: <span><?php echo $mostCreativeTime.' ('.$ideasCountTime.' ideas)'; ?></span></div>
				<div id="time-chart" class="chartContainer"></div>
			</div>
			

		</div>
	</div>

<?php require("includes/footer.php"); ?>