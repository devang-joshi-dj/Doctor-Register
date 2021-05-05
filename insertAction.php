<html>

<?php
// declaring every variables here
$name = $_POST["name"];
$nameErr = "";
$degree = $_POST["degree"];
$degreeErr = "";
$hospital = $_POST["hospital"]; // optional
$hospitalErr = "";
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
$conn = new mysqli($servername, $username, $password, $dbname);

$connection = true;
// Check connection
if ($conn->connect_error) {
	$connection = false;
}

function validateName($name)
// function to check if name is valid
{
	if (preg_match("/^[a-zA-Z-' ]*$/", $name) && $name != "") {
		return true;
	} else {
		global $nameErr;
		$nameErr = "Your name is invalid/empty";
		return false;
	}
}
validateName($name);

function validateEmail($email)
// function to check if email is valid
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '') {
		return true;
	} else {
		global $emailErr;
		$emailErr = "Your email is invalid/empty";
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
		$phoneErr = "Your phone number is invalid/empty";
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
		$degreeErr = "Your degree is invalid/empty";
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
		$specialityErr = "Your speciality is invalid/empty";
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
		$tenureErr = "Your tenure is invalid/empty";
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
		$timingErr = "Your timings are invalid/empty";
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
		$countryErr = "Your country is invalid/empty";
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
		$cityErr = "Your city is invalid/empty";
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
		$areaErr = "Your area is invalid/empty";
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

if (validateName($name) && validateDegree($degree) && validateSpeciality($speciality) && validateTenure($tenure) && validatePhone($phone) && validateEmail($email) && validateTiming($timing) && validateCountry($country) && validateCity($city) && validateArea($area) && validateReview($review) && checkConnection($connection))
// function to check if everything is valid
{
	$sql = "
	INSERT INTO records (name, degree, hospital,speciality, tenure, phone, email, timing, country, city, area, review)
	VALUES
	('" . $name . "', '" . $degree . "', '" . $hospital . "', '" . $speciality . "', '" . $tenure . "', '" . $phone . "', '" . $email . "', '" . $timing . "', '" . $country . "', '" . $city . "', '" . $area . "', '" . $review . "')
	";

	if ($conn->query($sql) === TRUE) {
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
			echo "<span style='font-weight:bold'>" . $nameErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $degreeErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $specialityErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $tenureErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $phoneErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $emailErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $timingErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $countryErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $cityErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $areaErr . "</span><br/>";
			echo "<span style='font-weight:bold'>" . $reviewErr . "</span><br/>";
			?>
			<h2>You are bieng redirected back to main page in 10 seconds</h2>
		</center>
	</body>

<?php
	header("refresh:5;url=index.html");
}
?>

</html>