<?php 

	$page_name = "My Messages";
	$page_id = "mail";

	include('includes/session_start.php');
	include('includes/header.php');
	include('includes/dbconn.php');

	$msg = '';
	$mem_id = $_SESSION['MEM_ID'];

	$query = "SELECT MEMBER.MEM_USERNAME, MESSAGES.MESS_ID
				FROM MEMBER, MESSAGES
				WHERE MESSAGES.MESS_FROM = MEMBER.MEM_ID && messages.MESS_TO = \"$mem_id\";";
	$stmt = $conn->prepare($query);
	$stmt->execute();

?>

<body class="wrapper">
	<div class="container">
		<div class="col-sm-3 col-md-2 sidebar">
	      	<ul class="nav nav-sidebar">
	      		<li>
	      			<form method="get" action="">
	      				<div class="row">
						  <div class="col-lg-12">
						    <div class="input-group">
						      <input type="text" name="searchBar" class="form-control" placeholder="Search for...">
						      <span class="input-group-btn">
						        <input class="btn btn-default" name="search" type="submit" value="GO!">
						      </span>
						    </div><!-- /input-group -->
						  </div><!-- /.col-lg-6 -->
						</div><!-- /.row -->
	      			</form>
	      		</li>
	      		<li><h3>Inbox</h3></li>
	      		<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
	            	<li><a href="messages.php?message=<?php echo $row['MESS_ID'] ?>"><?php echo $row['MEM_USERNAME']; ?></a></li>
	            <?php } ?>
	        </ul>
	        <ul class="nav nav-sidebar">
	        	<li><h3>Trash</h3></li>
	        </ul>
        </div>


        <h2>Messages</h2>
	</div>

	<?php include('includes/scripts.php'); ?>
</body>

<?php include('includes/footer.php'); ?>