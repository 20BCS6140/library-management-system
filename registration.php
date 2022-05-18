<?php
// Include config file
require_once "config.php";
$setVisible = false;

// Define variables and initialize with empty values
$firstname = $userid = $lastname = $email = $gender = $phonenumber = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $phonenumber = trim($_POST["phonenumber"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $gender = trim($_POST["gender"]);
    $confirm_password = trim($_POST["confirm_password"]);

    $sql = "INSERT INTO `admin_registration` (`FIRST_NAME`, `LAST_NAME`, `PHONE_NUMBER`, `EMAIL`, `USERPASSWORD`, `GENDER`, `created_at`) 
    VALUES 
    (?, ?, ?, ?, ?, ?, current_timestamp());";

    if ($password == $confirm_password) {
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssisss", $param_firstname, $param_lastname, $param_phonenumber, $param_email, $param_password, $param_gender);

            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_phonenumber = $phonenumber;
            $param_email = $email;
            $param_password = $password;
            $param_gender = $gender;

            if (mysqli_stmt_execute($stmt))
                header("location: login.php");
            else
                echo "Oops! Something went wrong. Please try again later.";
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="registrationstyles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/books-stack-realistic_1284-4735.jpg" type="image/x-icon">
	<title>Library Admin Registration</title>
</head>

<body>
	<div class="container">
		<div class="title">Library Registration</div>
		<div class="content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="user-details">
					<div class="input-box">
						<span class="details">First Name</span>
						<input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>
					</div>
					<div class="input-box">
						<span class="details">Last Name</span>
						<input type="text" id="lastname" name="lastname" placeholder="Enter your second name" required>
					</div>
					<div class="input-box">
						<span class="details">Phone Number</span>
						<input type="text" id="phonenumber" name="phonenumber" placeholder="Enter your number" required>
					</div>
					<div class="input-box">
						<span class="details">Email</span>
						<input type="email" id="email" name="email" placeholder="Enter your email" required>
					</div>
					<div class="input-box">
						<span class="details">Password</span>
						<input type="password" id="password" name="password" placeholder="Enter your password" required>
					</div>
					<div class="input-box">
						<span class="details">Confirm Password</span>
						<input type="password" name="confirm_password" placeholder="Confirm your password" required>
					</div>
				</div>
				<div class="gender-details">
					<input type="radio" name="gender" id="dot-1" value="Male">
					<input type="radio" name="gender" id="dot-2" value="Female">
					<input type="radio" name="gender" id="dot-3" value="others">
					<span class="gender-title">Gender</span>
					<div class="category">
						<label for="dot-1">
							<span class="dot one"></span>
							<span class="gender">Male</span>
						</label>
						<label for="dot-2">
							<span class="dot two"></span>
							<span class="gender">Female</span>
						</label>
						<label for="dot-3">
							<span class="dot three"></span>
							<span class="gender">others</span>
						</label>
					</div>
				</div>
				<div>
					Already have an account?
					<a href="login.php">Login</a>
				</div>
				<div class="button">
					<input type="submit" name="submit" value="submit">
				</div>
			</form>
		</div>
	</div>

</body>

</html>