<?php

$setVisible = 0;

// Include config file
require_once "config.php";

$studentid = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $studentid = trim($_POST["userid"]);

    $sql = "SELECT firstname, phonenumber, email from student where userid = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $studentid;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                
                mysqli_stmt_bind_result($stmt, $firstname, $phonenumber, $email);

                while(mysqli_stmt_fetch($stmt)){
                    setcookie("studentUserId", $studentid, time()+3600, "/","", 0);
                    setcookie("studentName", $firstname, time()+3600, "/","", 0);
                    setcookie("phoneNumber", $phonenumber, time()+3600, "/","", 0);
                    setcookie("email", $email, time()+3600, "/","", 0);

                    header('location: searchbook.php');
                }
            }
            else 
            {
                $setVisible = 1;
            }
        }
        else
        {
            $setVisible = 2;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="issuebook.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/books-stack-realistic_1284-4735.jpg" type="image/x-icon">
	<title>Issue Book</title>
</head>

<body>
	<div class="container">
		<div class="title">Issue Book</div>
		<div class="content">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="user-details">
					<div class="input-box">
						<span class="details">Search student</span>
						<input type="text" id="bookname" name="userid" placeholder="Enter User ID" required>
					</div>
				</div>

				<div class="button">
					<input type="submit" name="issue_book1" value="Search User">
				</div>
				<p style="color: white;">
                <?php 
                    if($setVisible == 1)
                        echo "User doesn't exist!";
                    else if($setVisible == 2)
                        echo "Oops! Something went wrong. Please try again later.";
                ?>
                </p>
		</div>
		</form>
	</div>
	</div>

</body>

</html>