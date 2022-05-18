<?php

session_start();
$setVisible = 0;
$setVisible1 = 0;
$setVisible2 = 0;

require_once "config.php";

$bookcode = $_COOKIE['bookCode_r'];
$bookname = $_COOKIE['bookName_r'];
$field = $_COOKIE['bookField_r'];
$studentid = $_COOKIE["studentId_r"];
$studentname = $_COOKIE["studentName_r"];
$phonenumber = $email = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql1 = "SELECT phonenumber, email from student WHERE userid = ?";

    $sql2 = "INSERT INTO `history` 
    (`STUDENTNAME`, `USERID`, `PHONENUMBER`, `EMAIL`, `TAKENORRETURNED`, `BOOKCODE`, `action_at`) 
    VALUES 
    (?, ?, ?, ?, 'return', $bookcode, current_timestamp());";

    $sql3 = "DELETE FROM issuedbooks WHERE `issuedbooks`.`BOOKCODE` = ?";

    if ($stmt = mysqli_prepare($link, $sql1)) {
        mysqli_stmt_bind_param($stmt, "s", $param_userid);
        $param_userid = $studentid;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {

                mysqli_stmt_bind_result($stmt, $phone, $mail);

                if (mysqli_stmt_fetch($stmt)) {
                    $phonenumber = $phone;
                    $email = $mail;

                    $setVisible = 1;
                }
                else
                    $setVisible = 2;
            }
            else
                $setVisible = 2;
        }
        else
            $setVisible = 2;
    }
    else
        $setVisible = 2;

    if ($stmt = mysqli_prepare($link, $sql2)) {
        mysqli_stmt_bind_param($stmt, "ssis", $param_studentname, $param_userid, $param_phonenumber, $param_email);
        $param_studentname = $studentname;
        $param_userid = $studentid;
        $param_phonenumber = $phonenumber;
        $param_email = $email;

        if (mysqli_stmt_execute($stmt))
            $setVisible1 = 1;
        else
            $setVisible1 = 2;
        mysqli_stmt_close($stmt);
    }
    else
        $setVisible1 = 2;

    if ($stmt = mysqli_prepare($link, $sql3)) {
        mysqli_stmt_bind_param($stmt, "s", $param_bookid);
        $param_bookid = $bookcode;

        if (mysqli_stmt_execute($stmt))
            $setVisible2 = 1;
        else
            $setVisible2 = 2;
        mysqli_stmt_close($stmt);
    }
    else
        $setVisible2 = 2;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="returnbook.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/books-stack-realistic_1284-4735.jpg" type="image/x-icon">
	<title>Return Book</title>
</head>

<body>
	<div class="container">
		<div class="title">Return Book</div>
		<div class="content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="user-details">
					<div class="input-box">
						<span class="details">Student Name</span>
						<input type="text" id="studentname" name="studentname" value='<?php echo $studentname; ?>' readonly>
					</div>
					<div class="input-box">
						<span class="details">Student ID</span>
						<input type="text" id="studentid" name="studentid" value='<?php echo $studentid; ?>' readonly>
					</div>
					<div class="input-box">
						<span class="details">Book Code</span>
						<input type="text" id="bookcode" name="bookcode" value="<?php echo $bookcode; ?>" readonly>
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
						<span class="details">Date of Return</span>
						<input type="date" id="dateofreturn" name="dateofissue" placeholder="Date" required>
					</div>

				</div>

				<div class="button">
					<input type="submit" name="issuebook" value="Return Book">
				</div>
				<p style="color: white;">
                    <?php
                        if ($setVisible == 1 and $setVisible1 == 1 and $setVisible2 == 1)
                            echo 'Book returned Successfully!!';
                        else if ($setVisible == 2 or $setVisible1 == 2 or $setVisible2 == 2)
                            echo "Oops! Something went wrong. Please try again later.";
                    ?>
                    </p>
		        </div>
		    </form>
	</div>
	</div>

	<script>
		const d = new Date();
		document.getElementById("dateofreturn").innerHTML = d;
	</script>


</body>

</html>