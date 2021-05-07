<html>

<?php
// declaring every variables here
$name = $_POST["name"];
$nameErr = "";
$degree = $_POST["degree"];
$degreeErr = "";
$hospital = $_POST["hospital"]; // optional
$speciality = $_POST["speciality"];
$specialityErr = "";
$tenure = $_POST["tenure"];
$tenureErr = "";
$phone = $_POST["phone"];
$phoneErr = "";
$email = $_POST["email"];
$emailErr = "";
$timing = $_POST["timing"];
$timingErr = "";
$country = $_POST["country"];
$countryErr = "";
$city = $_POST["city"];
$cityErr = "";
$area = $_POST["area"];
$areaErr = "";
$review = $_POST["review"];
$reviewErr = "";

$validity = false;
$connection = false;

// database connectivity establishment
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doctors";

// Create connection
$conn = new mysqli($servername, $username, $password);

$connection = true;
// Check connection
if ($conn->connect_error) {
	$connection = false;
}

// creating database
$dbSql = "CREATE DATABASE IF NOT EXISTS doctors";

$dbExists = false;
if ($conn->query($dbSql) === TRUE) {
	$dbExists = true;
}

// connecting to database
mysqli_select_db($conn, $dbname);

// checking if table exists
$tableExists = $conn->query('select 1 from records LIMIT 1');

// creating table if doesn't exists
if ($tableExists == false && $dbExists == true) {
	$tableSql = "CREATE TABLE records (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(100) NOT NULL,
		degree VARCHAR(100) NOT NULL,
		hospital VARCHAR(100) NOT NULL,
		speciality VARCHAR(100) NOT NULL,
		tenure VARCHAR(100) NOT NULL,
		phone int(10) NOT NULL,
		email VARCHAR(100) NOT NULL UNIQUE,
		timing VARCHAR(100) NOT NULL,
		country VARCHAR(100) NOT NULL,
		city VARCHAR(100) NOT NULL,
		area VARCHAR(100) NOT NULL,
		review VARCHAR(100) NOT NULL,
		reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";

	if ($conn->query($tableSql) === TRUE) {
		$tableExists = true;
	} else {
		$tableExists = false;
	}
}

function validateName($name)
// function to check if name is valid
{
	if ($name != "" && preg_match("/^[a-zA-Z-' ]*$/", $name)) {
		return true;
	} else {
		global $nameErr;
		$nameErr = "Your name is either invalid or empty";
		return false;
	}
}
validateName($name);

function validateEmail($email)
// function to check if email is valid or already exists or not
{
	if ($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
		global $conn;
		$result = $conn->query("SELECT * FROM records WHERE email = '" . $email . "'");
		if ($result->num_rows == 0) {
			return true;
		} else {
			global $emailErr;
			$emailErr = "Your email already exists";
			return false;
		}
	} else {
		global $emailErr;
		$emailErr = "Your email is either invalid or empty";
		return false;
	}
}
validateEmail($email);

function validatePhone($phone)
// function to check if phone is valid
{
	$numbersOnly = preg_replace("[^0-9]", "", $phone);
	$numberOfDigits = strlen($numbersOnly);
	if ($numberOfDigits == 10) {
		return true;
	} else {
		global $phoneErr;
		$phoneErr = "Your phone number is either invalid or empty";
		return false;
	}
}
validatePhone($phone);

function validateDegree($degree)
// function to check if degree is valid
{
	if ($degree != '') {
		return true;
	} else {
		global $degreeErr;
		$degreeErr = "Your degree is empty";
		return false;
	}
}
validateDegree($degree);

function validateSpeciality($speciality)
// function to check if speciality is valid
{
	if ($speciality != '') {
		return true;
	} else {
		global $specialityErr;
		$specialityErr = "Your speciality is empty";
		return false;
	}
}
validateSpeciality($speciality);

function validateTenure($tenure)
// function to check if tenure is valid
{
	if ($tenure != '') {
		return true;
	} else {
		global $tenureErr;
		$tenureErr = "Your tenure is empty";
		return false;
	}
}
validateTenure($tenure);

function validateTiming($timing)
// function to check if timing is valid
{
	if ($timing != '') {
		return true;
	} else {
		global $timingErr;
		$timingErr = "Your timings are empty";
		return false;
	}
}
validateTiming($timing);

function validateCountry($country)
// function to check if country is valid
{
	if ($country != '') {
		return true;
	} else {
		global $countryErr;
		$countryErr = "Your country is empty";
		return false;
	}
}
validateCountry($country);

function validateCity($city)
// function to check if city is valid
{
	if ($city != '') {
		return true;
	} else {
		global $cityErr;
		$cityErr = "Your city is empty";
		return false;
	}
}
validateCity($city);

function validateArea($area)
// function to check if area is valid
{
	if ($area != '') {
		return true;
	} else {
		global $areaErr;
		$areaErr = "Your area is empty";
		return false;
	}
}
validateArea($area);

function validateReview($review)
// function to check if review is valid
{
	$reviewLength = strlen($review);
	if ($review != '' && $reviewLength <= 255) {
		return true;
	} else {
		global $reviewErr;
		$reviewErr = "Your review is either empty or too long";
		return false;
	}
}
validateReview($review);

function checkConnection($connection)
// function to check if connection is established or not
{
	if ($connection) {
		return true;
	} else {
		return false;
	}
}

function tableExists($tableExists)
// function to check if connection is established or not
{
	if ($tableExists) {
		return true;
	} else {
		return false;
	}
}

if (
	validateName($name) && validateDegree($degree) && validateSpeciality($speciality) && validateTenure($tenure) &&
	validatePhone($phone) && validateEmail($email) && validateTiming($timing) && validateCountry($country) && validateCity($city)
	&& validateArea($area) && validateReview($review) && checkConnection($connection) && tableExists($tableExists)
)
// function to check if everything is valid
// if everything is valid it will be added into database
{
	$insertSql = "
	INSERT INTO records
	(name, degree, hospital,speciality, tenure, phone, email, timing, country, city, area, review)
	VALUES
	('" . $name . "', '" . $degree . "', '" . $hospital . "', '" . $speciality . "', '" . $tenure . "', '" . $phone . "',
	'" . $email . "', '" . $timing . "', '" . $country . "', '" . $city . "', '" . $area . "', '" . $review . "')
	";

	if ($conn->query($insertSql) === TRUE) {
		$validity = true;
	}

	$conn->close();
}

if ($validity == true) {
?>

	<body style="background-color:rgb(25, 173, 92); display:flex; justify-content:center; align-items:center;">
		<center>
			<h1>All records are Added Successfully</h1>
			<h2>You are bieng redirected back to main page in 5 seconds</h2>
		</center>
	</body>

<?php
	header("refresh:5;url=index.html");
} else {
?>

	<body style="background-color:rgb(184, 69, 69); display:flex; justify-content:center; align-items:center;">
		<center>
			<h1>Something went wrong</h1>
			<?php
			echo "<p style='font-weight:bold'>";
			echo "<span>" . $nameErr . "</span><br/>";
			echo "<span>" . $degreeErr . "</span><br/>";
			echo "<span>" . $specialityErr . "</span><br/>";
			echo "<span>" . $tenureErr . "</span><br/>";
			echo "<span>" . $phoneErr . "</span><br/>";
			echo "<span>" . $emailErr . "</span><br/>";
			echo "<span>" . $timingErr . "</span><br/>";
			echo "<span>" . $countryErr . "</span><br/>";
			echo "<span>" . $cityErr . "</span><br/>";
			echo "<span>" . $areaErr . "</span><br/>";
			echo "<span>" . $reviewErr . "</span><br/>";
			echo "</p>";
			?>
			<h2>You are bieng redirected back to main page in 10 seconds</h2>
		</center>
	</body>

<?php
	header("refresh:10;url=index.html");
}
?>

</html>