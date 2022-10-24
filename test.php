<!DOCTYPE html>
<html>

<head>
	<title>
		How to call a function
		repeatedly every 5
		seconds in JavaScript ?
	</title>
</head>

<body>
	

<p>
		Click the button to start
		timer, you will be alerted
		every 5 seconds until you
		close the window or press
		the button to stop timer
	</p>


	
	<button onclick="startTimer()">
		Start Timer
	</button>
	
	<button onclick="stopTimer()">
		Stop Timer
	</button>
	
	<script>
		var timer;
		
		function startTimer() {
			timer = setInterval(function() {
				alert("5 seconds are up");
			}, 5000);
		}
		
		function stopTimer() {
			alert("Timer stopped");
			clearInterval(timer);
		}
	</script>
</body>

</html>