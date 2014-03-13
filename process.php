<?php
	session_start();
	require('new-connection.php');
	date_default_timezone_set('America/Los_Angeles');

	if(isset($_POST['action']) && $_POST['action'] == 'register')
	{
		//call to function
		register_user($_POST);
	}

	else if(isset($_POST['action']) && $_POST['action'] == 'login')
	{
		login_user($_POST);
	}

	else if(isset($_POST['action']) && $_POST['action'] == 'new_survey')
	{
		new_survey($_POST);
	}

	else if(isset($_POST['action']) && $_POST['action'] == 'vote')
	{
		vote($_POST);
	}

	else //malicious navigation to process.php OR someone is trying to log off
	{
		session_destroy();
		header('location: index.php');
		exit();
	}

	function register_user($post)
	{
		$_SESSION['errors'] = array();

		//begin validation checks
		if(empty($post['first_name']))
		{
			$_SESSION['errors'][] = "first name can't be blank!";
		}
		if(empty($post['last_name']))
		{
			$_SESSION['errors'][] = "last name can't be blank!";
		}
		if(empty($post['password']))
		{
			$_SESSION['errors'][] = "password field is required!";
		}
		if($post['password'] !== $post['confirm_password'])
		{
			$_SESSION['errors'][] = "passwords must match!";
		}
		if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['errors'][] = "please use a valid email address!";
		}
		//end of validation checks

		if(count($_SESSION['errors']) > 0) //if any errors at all
		{
			header('location: index.php');
			exit();
		}
		else //now to insert the data into the database
		{
			$salt = bin2hex(openssl_random_pseudo_bytes(22));
			$hash = crypt($post['password'], $salt);

			$query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at) 
					  VALUES ('{$post['first_name']}', '{$post['last_name']}', '{$hash}', '{$post['email']}', NOW(), NOW())";
			run_mysql_query($query);
			$_SESSION['success_message'] = "User successfully created!";
			header('location: index.php');
			exit();
		}
	}

	function login_user($post)
	{
		$query = "SELECT * FROM users WHERE users.email = '{$post['email']}'";
		$user = fetch_all($query); //go and attempt to grab user with above credentials
		if(count($user) > 0)
		{
			if(crypt($post['password'], $user[0]['password']) == $user[0]['password'])
			{
				$_SESSION['user_id'] = $user[0]['id'];
				$_SESSION['first_name'] = $user[0]['first_name'];
				$_SESSION['logged_in'] = TRUE;
				header('location: surveys.php');
			}
			else
			{
				$_SESSION['errors'][] = "Incorrect Password";
			}
		}
		else
		{
			$_SESSION['errors'][] = "can't find a user with those credentials";
			header('location: index.php');
			exit();
		}
	}

	function new_survey($post)
	{
		if ( (isset($post['question']) && strlen($post['question']) > 0) && 
			(isset($post['choice1']) && strlen($post['choice1']) > 0) && 
			(isset($post['choice2']) && strlen($post['choice2']) > 0) && 
			(isset($post['choice3']) && strlen($post['choice3']) > 0) &&
			(isset($post['choice4']) && strlen($post['choice4']) > 0) )
		{
			$query = "INSERT INTO surveys (user_id, question, choice1, choice2, choice3, choice4, created_at, updated_at)
						VALUES ({$_SESSION['user_id']}, '" . mysql_real_escape_string($post['question']) . "','" .
						mysql_real_escape_string($post['choice1']) . "','" . mysql_real_escape_string($post['choice2']) .
						"','" . mysql_real_escape_string($post['choice3']) . "','" . mysql_real_escape_string($post['choice4']) .
						"', NOW(), NOW())";
			run_mysql_query($query);

			header('location: surveys.php');
			exit();
		}

		else
		{
			// $query = "DELETE FROM surveys WHERE surveys.id > 0";
			// run_mysql_query($query);
			$_SESSION['error'] = 'Please make sure to fill in every option';
			header('location: create_new.php');
			exit();		
		}
	}

	function vote($post)
	{
		if(isset($post['option']))
		{
			$choice = $post['option'];
			$query = "UPDATE surveys SET {$_POST['option']} = ({$_POST['option']} + 1)
			WHERE surveys.id = {$_POST['survey_id']}";
			run_mysql_query($query);
			$query = "UPDATE surveys SET updated_at = NOW()
			WHERE surveys.id = {$_POST['survey_id']}";
			run_mysql_query($query);
			header('location: surveys.php');
			exit();
		}
		else
		{
			header('location: surveys.php');
			exit();
		}
	}
?>