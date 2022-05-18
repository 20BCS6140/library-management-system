<?php

$setVisible = 0;

require_once "config.php";

$bookid = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookid = trim($_POST["bookid"]);

    $sql = "SELECT studentname, userid, bookname, field from issuedbooks where bookcode = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_bookid);
        $param_bookid = $bookid;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {

                mysqli_stmt_bind_result($stmt, $studentname, $studentid, $bookname, $field);

                if(mysqli_stmt_fetch($stmt)){

                    setcookie("bookCode_r", $bookid, time()+3600, "/","", 0);
                    setcookie("bookName_r", $bookname, time()+3600, "/","", 0);
                    setcookie("bookField_r", $field, time()+3600, "/","", 0);
                    setcookie("studentId_r", $studentid, time()+3600, "/","", 0);
                    setcookie("studentName_r", $studentname, time()+3600, "/","", 0);


                    header('location: returnbook.php');
                }
            }
            else {
                $setVisible = 1;
            }
        }
        else {
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
	<title>Return Book</title>
</head>

<body>
	<div class="container">
		<div class="title">Return Book</div>
		<div class="content">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="user-details">
					<div class="input-box">
						<span class="details">Search Book</span>
						<input type="text" id="bookname" name="bookid" placeholder="Enter Book ID" required>
					</div>
				</div>

				<div class="button">
					<input type="submit" name="issue_book1" value="Search Book">
				</div>
				<p style="color: white;">
                <?php
                    if ($setVisible == 1)
                        echo "Book doesn't exist!";
                    else if ($setVisible == 2)
                        echo "Oops! Something went wrong. Please try again later.";
                    ?>
                </p>
		</div>
		</form>
	</div>
	</div>

</body>

</html>