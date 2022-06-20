<?php 

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}


if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);
	
	$today = date("Y-m-d");
	$diff = date_diff(date_create($dob), date_create($today));
	if ($diff->format('%y') < 18) {
		
		echo "<script>alert('You must be over 18 years to register')</script>";
	}	else {
		if ($password == $cpassword) {
			$sql = "SELECT * FROM users WHERE email='$email'";
			$result = mysqli_query($conn, $sql);
			if (!$result->num_rows > 0) {
				$sql = "INSERT INTO users (username, email, phone, dob, password)
						VALUES ('$username', '$email', '$phone', '$dob', '$password')";
				$result = mysqli_query($conn, $sql);
				if ($result) {
					echo "<script>alert('Wow! User Registration Completed.')</script>";
					$username = "";
					$email = "";
					$phone = "";
					$dob = "";
					$_POST['password'] = "";
					$_POST['cpassword'] = "";
				} else {
					echo "<script>alert('Woops! Something Wrong Went.')</script>";
				}
			} else {
				echo "<script>alert('Email Already Exists.')</script>";
			}
		}
		
		else {
			echo "<script>alert('Password Not Matched.')</script>";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Register Form </title>

	<script>
	function ageCount() {
		var now = new Date();
		var currentY= now.getFullYear();
		var currentM= now.getMonth();
		var dobget =document.getElementById("dob").value;
		var dob= new Date(dobget);
		var prevY= dob.getFullYear();
		var prevM= dob.getMonth();
		var ageY= currentY - prevY;
		var ageM = Math.abs(currentM- prevM);
		document.getElementById('demo').innerHTML = ageY + 'Years ' + ageM + 'Months';
		
	}


	</script>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" maxlength="20" minlength="3" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="tel" placeholder="Phone Number" name="phone" pattern="^\d{10}$" value="<?php echo $phone; ?>">
            </div>
            <div class="input-group">
				<input type="date" placeholder="Date of Birth" id="dob" name="dob" onchange="ageCount()" value="<?php echo $dob; ?>" required>
				<p id="demo">age </p>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html>

