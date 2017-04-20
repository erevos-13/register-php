<?php 



	
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$problem = false; // No problems so far.
	
	// Check for each value...
	if (empty($_POST['first_name'])) {
		$problem = true;
		print '<p class="text--error">Please enter your first name!</p>';
	}
	
	if (empty($_POST['last_name'])) {
		$problem = true;
		print '<p class="text--error">Please enter your last name!</p>';
	}

	if (empty($_POST['email'])) {
		$problem = true;
		print '<p class="text--error">Please enter your email address!</p>';
	}

	if (empty($_POST['password1'])) {
		$problem = true;
		print '<p class="text--error">Please enter a password!</p>';
	}

	if ($_POST['password1'] != $_POST['password2']) {
		$problem = true;
		print '<p class="text--error">Your password did not match your confirmed password!</p>';
	} 
	
	if (!$problem) { // If there weren't any problems...
		
		//connect to database for register
		include('connect/mysqli_connect.php');

		$name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['first_name'])));
		$lastName = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['last_name'])));
		$emaildb = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['email'])));
		$password = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['password1'])));
	 	

		$query = "INSERT INTO users ( userID, email, pass, userName, fullname ) VALUES  
		( Null,'$emaildb', '$password', '$name', '$lastName' )";

		//mia if gia to an katafera na grafto
				// Execute the query:
		if (@mysqli_query($dbc, $query)) {

			//here we start the session for the cookie
			//we can hold info we like to use
			session_start();
			$_SESSION['emailLogin'] = $name;
			$_SESSION['time'] = date('g:i a l F j');
			$_SESSION['name'] = $_POST['first_name'];
			
			ob_end_clean();
			
			exit();
			

			
		} else {
			print '<p style="color: red;">Could not add user because:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
		}

		mysqli_close($dbc);


	} else { // Forgot a field.
	
		print '<p class="text--error">Please try again!</p>';
		
	}

} // End of handle form IF.

// Create the form:
?>
<form action="register.php" method="post" class="register">

	<h2>Registration Form</h2>
	<p>Register so that you can take advantage of certain features like this, that, and the other thing.</p>

	<p><label for="first_name">First Name:</label><input type="text" name="first_name" size="20" value="
	<?php if (isset($_POST['first_name'])) { print htmlspecialchars($_POST['first_name']); } ?>"></p>

	<p><label for="last_name">Last Name:</label><input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name'])) { print htmlspecialchars($_POST['last_name']); } ?>"></p>

	<p><label for="email">Email Address:</label><input type="email" name="email" size="20" value="<?php if (isset($_POST['email'])) { print htmlspecialchars($_POST['email']); } ?>"></p>

	<p><label for="password1">Password:</label><input type="password" name="password1" size="20" value="<?php if (isset($_POST['password1'])) { print htmlspecialchars($_POST['password1']); } ?>"></p>
	<p><label for="password2">Confirm Password:</label><input type="password" name="password2" size="20" value="<?php if (isset($_POST['password2'])) { print htmlspecialchars($_POST['password2']); } ?>"></p>

	<p><input type="submit" name="submit" value="Register!"></p>
	
</form>

