var now = new Date();
/*now.setDate(now.getDate()+30);
alert(now.getDay());*/

/* get current month */

var months = new Array(13);
   months[0]  = "January";
   months[1]  = "February";
   months[2]  = "March";
   months[3]  = "April";
   months[4]  = "May";
   months[5]  = "June";
   months[6]  = "July";
   months[7]  = "August";
   months[8]  = "September";
   months[9]  = "October";
   months[10] = "November";
   months[11] = "December";
var monthname = months[now.getMonth()];
$("#month").val(monthname);

/* get current dayOfMonth */
var monthday    = now.getDate();
$("#dayOfMonth").val(monthday);

/* get current year */
var year        = 1900+now.getYear();

$("#year").val(year);

/* get current time */
var a_p = "";
var d = new Date();
var curr_hour = d.getHours();
if (curr_hour < 12)
   {
   a_p = "AM";
   }
else
   {
   a_p = "PM";
   }
if (curr_hour == 0)
   {
   curr_hour = 12;
   }
if (curr_hour > 12)
   {
   curr_hour = curr_hour - 12;
   }

var curr_min = d.getMinutes();

curr_min = curr_min + "";

if (curr_min.length == 1)
   {
   curr_min = "0" + curr_min;
   }


$("#time").val(curr_hour + ":" + curr_min + " " + a_p);

/* get current day of the week */
var weekday=new Array(7);
weekday[0]="Sunday";
weekday[1]="Monday";
weekday[2]="Tuesday";
weekday[3]="Wednesday";
weekday[4]="Thursday";
weekday[5]="Friday";
weekday[6]="Saturday";
var day = weekday[now.getDay()];

$("#day").val(day);

/* get current location */

if (navigator.geolocation) {
	var timeoutVal = 10 * 1000 * 1000;
	navigator.geolocation.getCurrentPosition(
		displayPosition, 
		displayError,
		{ enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
	);
}
else {
  alert("Geolocation is not supported by this browser");
}



function displayPosition(position) {
	var userLat = position.coords.latitude;
	var userLong = position.coords.longitude;
	/*$("#location").val(userLat+","+userLong);*/
	
	geocoder = new google.maps.Geocoder();				
	var latlng = new google.maps.LatLng(userLat, userLong);
	
	geocoder.geocode({'location': latlng}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[4]) {
				$("#location").val(results[3].formatted_address);
			} else {
				$("#location").val("something is wrong here");
			
			}
	
		} else {
			alert("Geocoder failed due to: " + status);
		}
	});
	 
	 
	
	
 
}
function displayError(error) {
  var errors = { 
	1: 'Permission denied.',
	2: 'Position unavailable.',
	3: 'Request timeout.'
  };
  $("#location").val("Error: Cannot retrieve location. " + errors[error.code]);
}

  

/* get current weather */

/*userWeather = new google.maps.weather.WeatherForecast();
alert(userWeather.description);*/
			
