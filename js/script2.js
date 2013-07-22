/* $(document).ready(function() {
  $("#registerForm").hide();
  $("#existingUserLink").hide();
});

$("#newUserLink").click(function() {
  $("#loginForm").fadeOut('slow');
  $("#registerForm").show();
  $("#existingUserLink").show();
  $("#newUserLink").hide();
});
$("#existingUserLink").click(function() {
  $("#registerForm").fadeOut('slow');
  $("#loginForm").show();
  $("#newUserLink").show();
  $("#existingUserLink").hide();
}); */


$("#hide-completed").on('change', function() {


 if($("#hide-completed").is(':checked')){
	  $(".completedIdeaRow").hide("slow");
	  $("#hide-completed").prop('checked', true);
  }
  else {
	  $(".completedIdeaRow").show("slow");
	  $("#hide-completed").prop('checked', false);
  }
  
});