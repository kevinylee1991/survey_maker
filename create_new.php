<?php
	session_start();
	date_default_timezone_set('America/Los_Angeles');

	if (!isset($_SESSION['logged_in']))
	{
		header('location: process.php');
		exit();
	}
?>

<html>
<head>
	<title>Surveys</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type='text/css' href='surveys.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div id = "survey_form" class = "row">
			<div class='col-md-3'></div>
			<div id = "title" class = 'col-md-6 gray_back'>
				<h3>New Survey</h3>
				<?php
					if (isset($_SESSION['error']))
					{
						echo "<p class='red'>" . $_SESSION['error'] . "</p>";
						unset($_SESSION['error']);
					}
				?>
				<form action='process.php' method='post' role='form'>
					<input type='hidden' name='action' value='new_survey'>
					<div class="form-group">
					    <label>Question</label>
					    <textarea class='form-control' rows='2' name = 'question' placeholder='Your question here'></textarea>
 					</div>
 					<div class='form-group'>
 						<label>Choice 1</label>
 						<input type='text' class='form-control' name='choice1' placeholder='Input answer'>
 					</div>
 					<div class='form-group'>
 						<label>Choice 2</label>
 						<input type='text' class='form-control' name='choice2' placeholder='Input answer'>
 					</div>
 					<div class='form-group'>
 						<label>Choice 3</label>
 						<input type='text' class='form-control' name='choice3' placeholder='Input answer'>
 					</div>
 					<div class='form-group'>
 						<label>Choice 4</label>
 						<input type='text' class='form-control' name='choice4' placeholder='Input answer'>
 					</div>
 					<div id='submit_survey'>
 						<label class='btn btn-primary'>
 							Submit survey
 							<input type='submit' class='hidden'>
 						</label>
 					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>