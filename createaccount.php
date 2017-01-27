<?php 

$page_name = "Create Account";
$page_id = "createAccount";
include('includes/session_start.php');

include('includes/dbconn.php');

$msg = '';

if ($_POST) {

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zipcode = $_POST['zipcode'];
	$phone = $_POST['phone'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];

	if ($password1 == $password2) {

		$password = md5($password1);
		$mem_id = $_SESSION['MEM_ID'];
		
		$query = "UPDATE `MEMBER` SET `MEM_PASSWORD`= \"$password\", `MEM_FNAME`= \"$fname\", `MEM_LNAME`= \"$lname\", `MEM_ADDRESS`= \"$address\", `MEM_CITY`= \"$city\", `MEM_STATE`= \"$state\", 
					`MEM_ZIPCODE`= \"$zipcode\", `MEM_PHONE`= \"$phone\", `MEM_DATEJOINED`= CURDATE(), `MEM_LASTLOGIN`= NOW() WHERE MEM_ID = $mem_id;";
		$stmt = $conn->prepare($query);
		$stmt->execute();

		session_destroy();

		header("Location: index.php");


	} else {

		$msg = "<div id=\"wrongcredentials\"><p>Passwords do not match</p></div>";
	}
}

include('includes/header.php');

?>

<body class="wrapper">
	<div class="container">

		<?php if (isset($_SESSION['logged_in']) == NULL) { ?>
			<h2>Please <a href="index.php">Login</a></h2>
		<?php } elseif (isset($_SESSION['new_user']) && isset($_SESSION['logged_in'])) { ?>
		<!-- If it's a new user this account signup will be displayed -->
		<?php echo $msg; ?>
		<h2>Let's finish creating your account</h2>

		<form action="createaccount.php" method="post" id="loginform">
			<input type="text" name="fname" placeholder="First Name" class="textfield" required>
			<input type="text" name="lname" placeholder="Last Name" class="textfield" required>
			<input type="text" name="address" placeholder="Address" class="textfield" required>
			<input type="text" name="city" placeholder="City" class="textfield" required>
			<select name="state" class="textfield" required>
				<?php include('includes/states.php'); ?>
			</select>
			<input type="Number" name="zipcode" placeholder="Zipcode" maxlength="5" pattern="^([\d]{5})" title="Zipcode must be integers e.g. 12345" class="textfield" required>
			<input type="tel" name="phone" placeholder="Phone Number  e.g.1234567890" class="textfield" pattern="^([\d]{10})$" title="1234567890 No dashes or parenthesis" required>
			<br><br>
			<p>
			<input type="password" name="password1" minlength="8" maxlength="50" placeholder="Password" class="textfield" pattern="^([A-Za-z\d]{8,})" title="Password must be 8 characters long" required>
			<input type="password" name="password2" minlength="8" maxlength="50" placeholder="Confirm Password" class="textfield" pattern="^([A-Za-z\d]{8,})" title="Password must be 8 characters long" required>
			*Password must be at least 8 characters long
			</p>
			<table>
				<tr>
					<td><button type="submit" name="submit" class="buttons">Submit</button></td>
					<td><button type="reset" name="reset" class="buttons">Reset</button></td>
				</tr>
			</table>

		</form>

		<?php } elseif (isset($_SESSION['new_user']) == NULL && isset($_SESSION['logged_in'])) { ?>
			<h2>You already have an account! <a href="account.php">My Account</a></h2>
		<?php } ?>

	</div>
	<?php include('includes/scripts.php'); ?>
</body>

<?php include('includes/footer.php'); ?>