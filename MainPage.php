<!--AUTHOR: James Garrett Gruber-->
<!DOCTYPE html>
<html>
<head>
	<title>Jobby: The Job Search Organizer</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="MainPage.css"> 
</head>
<?php
//this block of php code connects to the database
// note your servername, username, and password should be the same, check your privlidges section in one of the databases to find out
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobbydb";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<script>
var logged = false;


function isLoggedIn(status) {
	if (status == "true") {
		document.getElementById('login').style.display='none';
		document.getElementById('logout').style.display='block';
		document.getElementById('welcome').style.display='block';
		document.getElementById('prompt').style.display='none';
		logged = true;
	}
}
</script>

<?php 
	$status = "false";
	$sql = "Select * from users where status = 1;";
	$result = $conn->query($sql);
			//goes through the variable $result which is now an array filled with info from the above sql query
				if ($result->num_rows >=1) {
				$status = "true";
				$cow = $result->fetch_assoc();
				}
?>

<?php 
// Logs the user out
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if($_POST["logout"]) {
		$sql = "UPDATE users SET status = 0 where status = 1;";
		$result = $conn->query($sql);
		header( 'Location: MainPage.php' );
	}
}
?>
<body onLoad = isLoggedIn('<?php print $status; ?>');>
<div class="topper">
	<p id="welcome">Welcome back, <?php echo $cow["user_name"]; ?>!</p>
	<p id="prompt">Please sign in to use Jobby</p>
	<form action="Login.php">
		<input id="login" type="submit" value="Login" />	
	</form>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input name="logout" id="logout" type="submit" value="Logout" />
	</form>
</div>


<div id="title">
<h1>Jobby: Organizing your job search since 2019!</h1>
</div>
<div id="navbar">
	<ul class="tabs">
		<li class="tab" id="about">About
			<ul class="dropdown">
				<li class="item">What is Jobby?</li>
				<li class="item">How does it work?</li>
				<li class="item">FAQ</li>
				<li class="bott">.</li>
			</ul>
		</li>
		<li class="tab" id="yourjobs">Your Jobs
			<ul class="dropdown">
				<li class="item">New Application</li>
				<li class="item">Application History</li>
				<li class="bott">.</li>
			</ul>
		</li>
		<li class="tab" id="calender">Calender
			<ul class="dropdown">
				<li class="item">View Calender</li>
				<li class="item">Import Calender</li>
				<li class="item">Export Calender</li>
				<li class="bott">.</li>
			</ul>
		</li>
		<li class="tab" id="support">Support
			<ul class="dropdown">
				<li class="item">Forum</li>
				<li class="item">Privacy Policy</li>
				<li class="item">Contact Us</li>
				<li class="bott">.</li>
			</ul>
		</li>
		<li class="tab" id="youraccount">Your Account
			<ul class="dropdown">
				<li class="item">Edit Profile</li>
				<li class="item">Link Accounts</li>
				<li class="item">Preferences</li>
				<li class="bott">.</li>
			</ul>
		</li>
	</ul>
</div>
<?php
$conn->close();
//ends the connection
	echo "<br>";
?>
</body>
</html>