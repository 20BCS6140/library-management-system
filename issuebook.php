<?php

session_start();
$setVisible1 = 0;
$setVisible2 = 0;

require_once "config.php";

$bookcode = $_COOKIE['bookCode'];
$bookname = $_COOKIE['bookName'];
$field = $_COOKIE['bookField'];
$studentid = $_COOKIE["studentUserId"];
$studentname = $_COOKIE["studentName"];
$phonenumber = $_COOKIE['phoneNumber'];
$email = $_COOKIE['email'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql1 = "INSERT INTO `issuedbooks` 
    (`STUDENTNAME`, `USERID`, `BOOKCODE`, `BOOKNAME`, `FIELD`, `issued_at`) 
    VALUES 
    (?, ?, ?, ?, ?, current_timestamp());";

    $sql2 = "INSERT INTO `history` 
    (`STUDENTNAME`, `USERID`, `PHONENUMBER`, `EMAIL`, `TAKENORRETURNED`, `BOOKCODE`, `action_at`) 
    VALUES 
    (?, ?, ?, ?, 'taken', $bookcode, current_timestamp());";

    if ($stmt = mysqli_prepare($link, $sql1)) {
        mysqli_stmt_bind_param($stmt, "sssss", $param_studentname, $param_userid, $param_bookcode, $param_bookname, $param_field);
        $param_studentname = $studentname;
        $param_userid = $studentid;
        $param_bookcode = $bookcode;
        $param_bookname = $bookname;
        $param_field = $field;

        if (mysqli_stmt_execute($stmt))
            $setVisible1 = 1;
        else
            $setVisible1 = 2;
        mysqli_stmt_close($stmt);
    }
    else
        $setVisible1 = 2;

    if ($stmt = mysqli_prepare($link, $sql2)) {
        mysqli_stmt_bind_param($stmt, "ssis", $param_studentname, $param_userid, $param_phonenumber, $param_email);
        $param_studentname = $studentname;
        $param_userid = $studentid;
        $param_phonenumber = $phonenumber;
        $param_email = $email;

        if (mysqli_stmt_execute($stmt))
            $setVisible2 = 1;
        else
            $setVisible2 = 2;
        mysqli_stmt_close($stmt);
    }
    else
        $setVisible1 = 2;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="addbook.css">
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
						<span class="details">Student Name</span>
						<input type="text" id="studentname" name="studentname" value='<?php echo $studentname; ?>' readonly>
					</div>
					<div class="input-box">
						<span class="details">Student ID</span>
						<input type="text" id="usertid" name="userid" value='<?php echo $studentid; ?>' readonly>
					</div>
					<div class="input-box">
						<span class="details">Book Code</span>
						<input type="text" id="bookcode" name="bookcode" value='<?php echo $bookcode; ?>' readonly>
					</div>
					<div class="input-box">
						<span class="details">Book Name</span>
						<input type="text" id="bookname" name="bookname" value='<?php echo $bookname; ?>' readonly>
					</div>
					<div class="input-box">
						<span class="details">Field</span>
						<input type="text" id="field" name="field" value='<?php echo $field; ?>' readonly>
					</div>
					<div class="input-box">
						<span class="details">Date of issue</span>
						<input type="date" id="dateofissue" name="dateofissue" placeholder="Date" required>
					</div>

				</div>

				<div class="button">
					<input type="submit" name="issuebook" value="Issue Book">
				</div>
				<p style="color: white;">
                    <?php
                        if($setVisible1 == 1 and $setVisible2 == 1)
                            echo 'Book issued Successfully!!';
                        else if($setVisible1 == 2)
                            echo "Oops! Something went wrong. Please try again later."; 
                        else if($setVisible2 == 2)
                            echo "Oops!! Something went wrong. Please try again later."; 
                    ?>
                </p>
		</div>
		</form>
	</div>
	</div>

</body>

</html>