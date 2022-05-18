
<?php
// Include config file
require_once "config.php";
$setVisible = false;


// Define variables and initialize with empty values
$bookname = $bookcode = $authorname = $field = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


	$bookname = trim($_POST["bookname"]);
	$bookcode = trim($_POST["bookcode"]);
	$authorname = trim($_POST["author"]);
	$field = trim($_POST["field"]);

	$sql = "INSERT INTO `books` 
    (`BOOKNAME`, `BOOKCODE`, `AUTHOR`, `FIELD`, `created_at`) 
    VALUES 
    (?, ?, ?, ?, current_timestamp());";

	if ($stmt = mysqli_prepare($link, $sql)) {
		mysqli_stmt_bind_param($stmt, "ssss", $param_bookname, $param_bookcode, $param_authorname, $param_field);

		$param_bookname = $bookname;
		$param_bookcode = $bookcode;
		$param_authorname = $authorname;
		$param_field = $field;

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
	<link rel="stylesheet" href="addbook.css">
	<title>Add Book</title>
	<link rel="icon" href="images/books-stack-realistic_1284-4735.jpg" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

	<div class="container">
		<div class="title">Add Book</div>
		<div class="content">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="user-details">
					<div class="input-box">
						<span class="details">Book Name</span>
						<input type="text" id="bookname" name="bookname" placeholder="Enter book name" required>
					</div>
					<div class="input-box">
						<span class="details">Book code</span>
						<input type="text" id="bookcode" name="bookcode" placeholder="Enter book code" required>
					</div>
					<div class="input-box">
						<span class="details">Author Name</span>
						<input type="text" id="author" name="author" placeholder="Enter author name" required>
					</div>
					<div class="input-box">
						<span class="details">Date of issue</span>
						<input type="date" id="dateofissue" name="dateofissue" placeholder="Date" required>
					</div>
					<div class="details">
						<label for="field" class="details">Field</label>
						<div class="input">
							<select name="field" id="field" class="in">
								<option value="CSE">CSE</option>
								<option value="EEE">EEE</option>
								<option value="ECE">ECE</option>
								<option value="IT">IT</option>
								<option value="CIVIL ENGINEERING">CIVIL ENGINEERING</option>
								<option value="BIOTECHNOLOGY">BIOTECHNOLOGY</option>
								<option value="AUTOMOBILE">AUTOMOBILE</option>
								<option value="AERONAUTICAL">AERONAUTICAL</option>
								<option value="PETROLEUM">PETROLEUM</option>
								<option value="CHEMICAL">CHEMICAL</option>
								<option value="BIOMEDICAL">BIOMEDICAL</option>
								<option value="OTHERS">OTHERS</option>
							</select>

						</div>

					</div>

					<div class="button">
						<input type="submit" name="Add_Student" value="Add Book" id="submit">
					</div>
                    <p style="color: white; ">
                    <?php
						if ($setVisible == true)
							echo 'Book Added Successfully!';
						?>
                    </p>
				</div>
			</form>
		</div>
	</div>
<script src="add_book.js"></script>
</body>

</html>