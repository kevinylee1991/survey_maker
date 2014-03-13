<?php
	require('new-connection.php');
	session_start();
	date_default_timezone_set('America/Los_Angeles');

	if (!isset($_SESSION['logged_in']))
	{
		header('location: process.php');
		exit();
	}

	function all_messages()
	{
		$query = "SELECT surveys.user_id, surveys.question, surveys.choice1, surveys.choice2,
					surveys.choice3, surveys.choice4, surveys.count1, surveys.count2, surveys.count3,
					surveys.count4, surveys.updated_at, surveys.id FROM surveys
					ORDER BY surveys.updated_at DESC";
		$survey_data = fetch_all($query);

		foreach($survey_data AS $survey)
		{
			$query = "SELECT users.first_name FROM surveys
						LEFT JOIN users ON users.id = surveys.user_id
						WHERE surveys.id = {$survey['id']}";
			$name_data = fetch_all($query);
			$name = $name_data[0]['first_name'];
			echo "<div class='row'>
					<div class='col-md-3'>
					</div>
					<div class='col-md-6 gray_back survey'>
						<h3>{$survey['question']}</h3>
						<h4>By: {$name}</h4>
						<form action = 'process.php' method = 'post'>
							<input type='hidden' name='action' value='vote'>
							<input type='hidden' name='survey_id' value='{$survey['id']}'>
							<div class='form-group'>
								<div class='radio'>
									<label>
										<input type='radio' name='option' value='count1'>{$survey['choice1']}
									</label>
									{$survey['count1']}
								</div>
								<div class='radio'>
									<label>
										<input type='radio' name='option' value='count2'>{$survey['choice2']}
									</label>
									{$survey['count2']}
								</div>
								<div class='radio'>
									<label>
										<input type='radio' name='option' value='count3'>{$survey['choice3']}
									</label>
									{$survey['count3']}
								</div>
								<div class='radio'>
									<label>
										<input type='radio' name='option' value='count4'>{$survey['choice4']}
									</label>
									{$survey['count4']}
								</div>
								<input type='submit' value='Vote'>
							</div>
						</form>
					</div>
				</div>";
		}
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
		<div id = "header" class = "row">
			<div class='col-md-3'></div>
			<div id = "title" class = 'col-md-6 gray_back'>
				<h1>Surveys Here</h1>
				<h2>Welcome, <?php echo $_SESSION['first_name']; ?></h2>
			</div>
		</div>
		<div id = 'new_survey' class = "row">
			<div class='col-md-3'></div>
			<div class='col-md-6 gray_back padding text_right'>
				<form action='create_new.php'>
					<label class='btn btn-primary'>
						Create new survey
						<input type='submit' class='hidden'>
					</label>
				</form>
				<br>
				<form action='process.php'>
					<label class='btn btn-danger'>
						Log off
						<input type='submit' class='hidden'>
					</label>
				</form>
			</div>
		</div>
		<?php
			all_messages();
		?>
	</div>
</body>
</html>