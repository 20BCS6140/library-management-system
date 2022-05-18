<?php

session_start();

// Include config file
require_once "config.php";


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        $username_err = "Please enter username.";
    }
    else {
        $username = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    }
    else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT email, userpassword FROM admin_registration WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if ($password == $hashed_password) {
                            // Redirect user to welcome page
                            header("location: index.html");
                        }
                        else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                }
                else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            }
            else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>


<html>
<head>
    <title>Library Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel = "icon" href = "images/books-stack-realistic_1284-4735.jpg" type = "image/x-icon">
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="hero">
            <div class="form-box">
                <div class="heading">Log in
                    <div class="line"> </div>
                </div>
                <form class="input-group" action= "index.html" method="POST"> 
                <p class="font">User Id </p>  <br>
                    <input type=" " class="input-field" placeholder="User Id" name="email" id="name" required> <br>
                    <p class="font"> password</p> <br>
                    <input type="password" class="input-field" placeholder="password" name="password" id="password" required> 
                    <!-- <input type="checkbox" class="check-box"> <span>Remember password</span> -->
                    <div class="redirect">
                        Don't have an account?
                        <a href="Registration.html">
                            create account 
                        </a>
                    </div>
                    <button type="submit" class="submit-btn"> Login</button>
                </form>
                
            </div>
        </div>
    </form>



</body>
</head>
</html>