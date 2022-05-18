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
    $userid = trim($_POST["userid"]);
    $email = trim($_POST["email"]);
    $phonenumber = trim($_POST["studentphonenumber"]);
    $gender = trim($_POST["gender"]);

    $sql = "INSERT INTO `student` 
    (`FIRSTNAME`, `LASTNAME`, `USERID`, `PHONENUMBER`, `EMAIL`, `GENDER`) 
    VALUES 
    (?, ?, ?, ?, ?, ?);";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssiss", $param_firstname, $param_lastname, $param_userid, $param_phonenumber, $param_email, $param_gender);

        $param_firstname = $firstname;
        $param_lastname = $lastname;
        $param_userid = $userid;
        $param_phonenumber = $phonenumber;
        $param_email = $email;
        $param_gender = $gender;

        if (mysqli_stmt_execute($stmt)) {
            $setVisible = true;
        }
        else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<link rel="icon" href="images/books-stack-realistic_1284-4735.jpg" type="image/x-icon">
	<title>Add Student</title>
	<link rel="stylesheet" href="registrationstyles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<div class="container">
		<div class="title">Add Student</div>
		<div class="content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="user-details">
					<div class="input-box">
						<span class="details">First Name</span>
						<input type="text" id="firstname" name="firstname" placeholder="Enter your first name"
							required>
					</div>
					<div class="input-box">
						<span class="details">Last Name</span>
						<input type="text" id="lastname" name="lastname" placeholder="Enter your second name"
							required>
					</div>
					<div class="input-box">
						<span class="details">User ID</span>
						<input type="text" id="Id" name="userid" placeholder="Enter your User Id" required>
					</div>
					<div class="input-box">
						<span class="details">Phone Number</span>
						<input type="text" id="phonenumber" name="studentphonenumber" placeholder="Enter your number"
							required>
					</div>
					<div class="input-box">
						<span class="details">Email</span>
						<input type="email" id="email" name="email" placeholder="Enter your email" required>
					</div>
				</div>
				<div class="gender-details">
					<input type="radio" name="gender" id="dot-1" value="male">
					<input type="radio" name="gender" id="dot-2" value="female">
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
				<div class="button">
					<input type="submit" name="Add_Student" value="Add Student">
				</div>
                <p style="color: white; ">
                    <?php
                    if ($setVisible == true)
                        echo 'Student Added Successfully!';
                    ?>
                </p>
			</form>
		</div>
	</div>

</body>

</html>