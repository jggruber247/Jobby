<!--AUTHOR: James Garrett Gruber-->
<!DOCTYPE html>
<html>
<head>
	<title>Login to Jobby</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="Login.css"> 
</head>

<?php
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
<?php 
//initializes variables
$ready= "true"; //boolean variable.
$userErr="Enter User ID";
$passErr="Enter Password";
$ERR="";
$user=$pass="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//checks the user variable
	if(empty($_POST["user"])){
		$userErr = "Username is required";
		$ready = "false";
	} else{
		 if(strstr($_POST["user"]," ",true) ){
			 $userErr = "No Spaces in Username";
			$ready = "false"; 
		 }else{
			$user = test_input($_POST["user"]);
		 }
	}
	//check the pass variable
	if(empty($_POST["pass"])){
		$passErr = "Password is required";
		$ready = "false";
	} else{
		 if(strstr($_POST["pass"]," ",true)){
			$passErr = "No Spaces in Password";
			$ready = "false"; 
		 }else{
			$pass = test_input($_POST["pass"]);
		 }
	}
	
	//checks to see if all variables are valid
	if($ready == "false"){
		//if not valid the message pops up
		$ERR = "Login Denied";
	}elseif($ready == "true"){
			//if it is valid a query is called to the database
			$sql = "SELECT * FROM users WHERE user_ID='$user' AND password='$pass'";
			$result = $conn->query($sql);

			//checks if the login is succesful
			if ($result->num_rows ==1) {
			$ERR= "login succesful";
				$sql = "UPDATE users". " SET status = true " . "WHERE user_ID='$user' AND password='$pass'";
			$result = $conn->query($sql);
			//takes you to home page if successful
			header( 'Location: MainPage.php' );
			} else {
				//if presents the msg
			$conn->error;
			$ERR = "Username or Password is Invalid";
			}
			//ends the connection
			$conn->close();
	}
}
	//function to help clean the variables
	function test_input($data){
		$data= trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
	return $data;}
?>
<body>
<div id="rectangle">
<!--form that takes you back to home page-->
<h1>Welcome Back to Jobby!</h1>
<h3>Please Sign In Below</h3>
<br>
<!--main form to login-->
<form method ="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="text" name="user" placeholder="<?php echo $userErr;?>"> <br><br>
	<input type="password" name="pass" placeholder="<?php echo $passErr;?>"> <br><br>
	<br><br>
	<input id ="sub" type="submit" name="submit" value="Submit">
</form>
<form  action="MainPage.php">
    <input id="return" type="submit" value="Return to Home Page" />
</form>
<h2 id="btmERR"><?php echo $ERR;?></h2>
</div>
</body>
</html>