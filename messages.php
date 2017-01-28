<?php 

	$page_name = "My Messages";
	$page_id = "mail";

	include('includes/session_start.php');
	include('includes/header.php');
	include('includes/dbconn.php');

	$msg = '';
	$mem_id = $_SESSION['MEM_ID'];

	$query = "SELECT MEMBER.MEM_USERNAME, MESSAGES.MESS_ID, MESSAGES.MESS_MESSAGE, MESSAGES.MESS_TIME_SENT, MESSAGES.MESS_READ
				FROM MEMBER, MESSAGES
				WHERE MESSAGES.MESS_FROM = MEMBER.MEM_ID && MESSAGES.MESS_TO = \"$mem_id\";";
	$stmt = $conn->prepare($query);
	$stmt->execute();




	if (isset($_GET['message'])) {

		$_SESSION['get_message'] = true;

		
		$mess_id = $_GET['message'];

		$query2 = "SELECT MESS_MESSAGE FROM MESSAGES WHERE MESS_ID = \"$mess_id\" && MESS_TO = \"$mem_id\";";
		$query3 = "UPDATE MESSAGES SET MESS_READ = TRUE WHERE MESS_ID = \"$mess_id\";";
		$stmt2 = $conn->prepare($query2);
		$stmt3 = $conn->prepare($query3);
		$stmt2->execute();
		$stmt3->execute();
	} else
		$_SESSION['get_message'] = NULL;




	$query5 = "SELECT COUNT(MEMBER.MEM_USERNAME) AS \"num_username\", MESSAGES.MESS_READ
				FROM MEMBER, MESSAGES
				WHERE MESSAGES.MESS_FROM = MEMBER.MEM_ID && MESSAGES.MESS_TO = \"$mem_id\" && MESSAGES.MESS_READ = FALSE;";
	$stmt5 = $conn->prepare($query5);
	$stmt5->execute();

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
	      		<li><h3>Inbox <span class="badge"><?php if ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) { echo $row5['num_username']; } ?></span></a></h3></li>
	      		<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
	            	<li>
	            		<a href="messages.php?message=<?php echo $row['MESS_ID'] ?>"><?php echo $row['MEM_USERNAME']; ?><br>
		            		<span>
		            			<?php 
									$phpdate = strtotime( $row['MESS_TIME_SENT'] );
									$mysqldate = date( 'M d, y g:i a', $phpdate ); 
									echo $mysqldate; ?>
		            		</span>
		            		<?php if ($row['MESS_READ'] == FALSE) { ?>
		            			<span class="badge">1</span>
		            		<?php } ?>
	            		</a>
	            	</li>
	            <?php } ?>
	        </ul>
	        <ul class="nav nav-sidebar">
	        	<li><h3>Trash</h3></li>
	        </ul>
        </div>


        <h2>Messages</h2>
        <hr>
        <?php if(isset($_SESSION['get_message'])) { ?>
	        <?php if ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
	        	<p><?php echo $row2['MESS_MESSAGE']; ?></p>
	        <?php } ?>
        <?php } ?>
	</div>

	<?php include('includes/scripts.php'); ?>
</body>

<?php include('includes/footer.php'); ?>