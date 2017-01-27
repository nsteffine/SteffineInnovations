<?php 

$page_name = "Contact";
$page_id = "contact";

include('includes/session_start.php');
include('includes/header.php');
include('includes/dbconn.php');

if ($_POST) {
	
	$to = "nicholas.steffine@gmail.com";
	$subject = "Contact Form";
	$text = $_POST["message"];
	$msg = $text;
	//Get senders email
	$from = $_POST["email"];
	//set the headers
	$headers = "From: " . $from;

	//send email
	mail($to, $subject, $msg, $headers);

	$_SESSION["email-sent"] = true;
}

?>

<body class="wrapper">
	<div class="container">		
		<h2>Contact us</h2>
			<h3>Under Construction</h3>
		<!-- <?php if (isset($_SESSION["email-sent"]) == NULL) { ?>
			<form id="contactUs" action="contact.php" method="POST">
				<input type="text" name="name" placeholder="Name" class="textfield" minlength="1" maxlength="25" required><br>
				<input type="email" name="email" placeholder="Email" class="textfield" minlength="1" maxlength="100" required>
				<textarea rows="10" cols="100" name="message" placeholder="Message" class="textfield" minlength="1" maxlength="255" required autocomplete="off"></textarea>
				<table class="buttontable">
					<tr>
						<td><button type="submit" name="submit" class="buttons">Submit</button></td>
						<td><button type="reset" name="reset" class="buttons">Reset</button></td>
					</tr>
				</table>
			</form>
		<?php } else { ?>
			<h3 style="color: green;">Email Sent Successfully</h3>
			<p><a href="contact.php">Send </a>Another?</p>
		<?php $_SESSION["email-sent"] = NULL; } ?> -->
	</div>
</body>

<?php include('includes/footer.php'); ?>