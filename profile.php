<?php 

$page_name = "My Profile";
$page_id = "myProfile";

include('includes/session_start.php');
include('includes/header.php');
include('includes/dbconn.php');

?>

<body class="wrapper">
	<div class="container">

		<h2><?php echo $_SESSION['MEM_FNAME'].' '.$_SESSION['MEM_LNAME']; ?></h2>

		<div id="profile-content">

			<div >
				
			</div>

		</div>
	</div>

	<?php include('includes/scripts.php'); ?>
</body>

<?php include('includes/footer.php'); ?>