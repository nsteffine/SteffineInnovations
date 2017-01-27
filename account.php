<?php 

	$page_name = "My Account";
	$page_id = "myAccount";

	include('includes/session_start.php');
	include('includes/header.php');
	include('includes/dbconn.php');

	$msg = '';
	$mem_id = $_SESSION['MEM_ID'];



	if(isset($_GET['edit'])) {

		$_SESSION['edit_account'] = true;
	} else
		$_SESSION['edit_account'] = NULL;




	if (isset($_GET['editOther'])) {
		
		$_SESSION['edit_other'] = true;
		$other = $_GET['editOther'];

		$query = "SELECT * FROM MEMBER WHERE MEM_ID = \"$other\"";
		$stmt = $conn->prepare($query);
		$stmt->execute();
	} else
		$_SESSION['edit_other'] = NULL;




	if (isset($_GET['view'])) {

		$_SESSION['view_admins'] = true;

		$query = "SELECT * FROM MEMBER;";
		$stmt = $conn->prepare($query);
		$stmt->execute();
	} else
		$_SESSION['view_admins'] = NULL;




	if (isset($_GET['create'])) {
		
		$_SESSION['create_account'] = true;
	} else
		$_SESSION['create_account'] = NULL;




	if(isset($_GET['id'])) {

		$_SESSION['view_admins'] = true;
		$_SESSION['get_name'] = true;

		$memberID = $_GET['id'];

		$query = "SELECT * FROM MEMBER WHERE \"$memberID\" = MEM_ID;";

		$stmt = $conn->prepare($query);
		$stmt->execute();

		if ($memberID == $mem_id) {
			$_SESSION['cant_delete'] = true;
		} else
			$_SESSION['cant_delete'] = NULL;

	} else
		$_SESSION['get_name'] = NULL;




	if (isset($_GET['search'])) {

		$_SESSION['search_name'] = true;
		$searchStr = $_GET['searchBar'];

		$query = "SELECT * FROM MEMBER WHERE MEM_ID = \"$searchStr\" OR MEM_FNAME LIKE \"$searchStr%\" OR MEM_LNAME LIKE \"$searchStr%\";";
		$stmt = $conn->prepare($query);
		$stmt->execute();
	} else
		$_SESSION['search_name'] = NULL;




	if (isset($_GET['change'])) {
		
		$_SESSION['change_password'] = true;

		
	} else
		$_SESSION['change_password'] = NULL;




	if (isset($_GET['deleteId'])) {
		
		$_SESSION['delete_user'] = true;
		$userID = $_GET['deleteId'];

		$query = "DELETE FROM MEMBER WHERE MEM_ID = \"$userID\";";
		$stmt = $conn->prepare($query);
		$stmt->execute();

		header("Location: account.php?view=AllAdmins");
	} else
		$_SESSION['delete_user'] = NULL;




	if (isset($_GET['resetPassword'])) {
		
		$_SESSION['reset_password'] = true;

		$password = md5("password");
		$userID = $_GET['resetPassword'];

		$query = "UPDATE MEMBER SET MEM_PASSWORD = \"$password\" WHERE MEM_ID = \"$userID\";";
		$stmt = $conn->prepare($query);
		$stmt->execute();

		header("Location: account.php?view=AllAdmins");
	}




	if (isset($_GET['sendMessageTo'])) {
		
		$_SESSION['send_message'] = true;
		$userID = $_GET['sendMessageTo'];
		$_SESSION['userID'] = $userID;

		$query = "SELECT * FROM MEMBER WHERE MEM_ID = \"$userID\";";
		$stmt = $conn->prepare($query);
		$stmt->execute();

	} else
		$_SESSION['send_message'] = NULL;



// EDITING AN EMPLOYEE
	if (isset($_POST['address']) &&
		isset($_POST['city']) &&
		isset($_POST['state']) &&
		isset($_POST['zipcode']) &&
		isset($_POST['phone'])) {
		
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zipcode = $_POST['zipcode'];
		$phone = $_POST['phone'];
		$employee_id = $_SESSION['edit_other_id'];

		if ($_SESSION['MEM_ID'] == $employee_id) {

			$_SESSION['MEM_ADDRESS'] = $address;
			$_SESSION['MEM_CITY'] = $city;
			$_SESSION['MEM_STATE'] = $state;
			$_SESSION['MEM_ZIPCODE'] = $zipcode;
			$_SESSION['MEM_PHONE'] = $phone;
		}

		$query = "UPDATE MEMBER
					SET MEM_ADDRESS = \"$address\", 
						MEM_CITY = \"$city\",
						MEM_STATE = \"$state\",
						MEM_ZIPCODE = \"$zipcode\",
						MEM_PHONE = \"$phone\"
					WHERE MEM_ID = \"$employee_id\";";

		$stmt = $conn->prepare($query);
		$stmt->execute();

		header("Location: account.php?id=".$employee_id);

	}


// CREATING A NEW EMPLOYEE
	if (isset($_POST['create-fname']) &&
		isset($_POST['create-lname']) &&
		isset($_POST['create-address']) &&
		isset($_POST['create-city']) &&
		isset($_POST['create-state']) &&
		isset($_POST['create-zipcode']) &&
		isset($_POST['create-phone']) &&
		isset($_POST['create-status'])) {

		$createFname = $_POST['create-fname'];
		$fnameSplit = str_split($createFname);
		$fnameLowercase = strtolower($fnameSplit[0]);
		$createLname = $_POST['create-lname'];
		$lnameLowercase = strtolower($createLname);
		$createAddress = $_POST['create-address'];
		$createCity = $_POST['create-city'];
		$createState = $_POST['create-state'];
		$createZipcode = $_POST['create-zipcode'];
		$createPhone = $_POST['create-phone'];
		$createTitle = $_POST['create-title'];
		$createStatus = $_POST['create-status'];
		$password = md5("password");

		$query2 = "INSERT INTO `MEMBER` (`MEM_ID`, `MEM_USERNAME`, `MEM_PASSWORD`, `MEM_FNAME`, `MEM_LNAME`, `MEM_ADDRESS`, `MEM_CITY`, `MEM_STATE`, `MEM_ZIPCODE`, `MEM_PHONE`, `MEM_DATEJOINED`, `MEM_LASTLOGIN`, `MEM_TITLE`, `MEM_STATUS`) VALUES (NULL, \"$fnameLowercase$lnameLowercase\", \"$password\", \"$createFname\", \"$createLname\", \"$createAddress\", \"$createCity\", \"$createState\", \"$createZipcode\", 
			\"$createPhone\", CURDATE(), NOW(), \"$createTitle\", \"$createStatus\");";

		$stmt2 = $conn->prepare($query2);
		$stmt2->execute();

		$_SESSION['success'] = true;

		header("Location: account.php?view=AllAdmins");
	}




	if (isset($_POST['newPassword']) && 
		isset($_POST['confirmPassword'])) {

		$_SESSION['passwordChange_success'] = true;
		
		$newPassword = $_POST['newPassword'];
		$confirmPassword = $_POST['confirmPassword'];
		$newPassword = md5($newPassword);

		$query = "UPDATE MEMBER SET MEM_PASSWORD=\"$newPassword\" WHERE MEM_ID = \"$mem_id\";";
		$stmt = $conn->prepare($query);
		$stmt->execute();
	} else {
		$_SESSION['passwordChange_success'] = NULL;
	}




	if (isset($_POST['message'])) {

		$message = $_POST['message'];
		$messageTo = $_SESSION['userID'];

		$query = "INSERT INTO MESSAGES (`MESS_ID`, `MESS_MESSAGE`, `MESS_TIME_SENT`, `MESS_TO`, `MESS_FROM`) VALUES (NULL, \"$message\", NULL, \"$messageTo\", \"$mem_id\")";
		$stmt = $conn->prepare($query);
		$stmt->execute();

		$_SESSION['message_success'] = true;
	}




	$query5 = "SELECT COUNT(MEMBER.MEM_USERNAME) AS \"num_username\"
				FROM MEMBER, MESSAGES
				WHERE MESSAGES.MESS_FROM = MEMBER.MEM_ID && messages.MESS_TO = \"$mem_id\";";
	$stmt5 = $conn->prepare($query5);
	$stmt5->execute();

?>

<body class="wrapper">
	<div class="container">

		<?php if(isset($_SESSION['logged_in'])) { ?>
			<div class="col-sm-3 col-md-2 sidebar">
		      	<ul class="nav nav-sidebar">
		      		<li>
		      			<form method="get" action="account.php?search=<?php echo $_GET['searchBar']; ?>">
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
		      		<li>
		      			<a href="messages.php" class="list-group-item">Messages 
		      			<span class="badge btn-primary"><?php if ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) { echo $row5['num_username']; } ?></span></a>
		      		</li>
		            <li><a onclick="something()" class="<?php echo ($_SESSION['edit_account'] == true ? "active" : ""); ?> list-group-item" href="account.php?edit=Account">Edit Account Details</a></li>
		            <li><a class="<?php echo ($_SESSION['view_admins'] == true ? "active" : ""); ?> list-group-item" href="account.php?view=AllAdmins">View All Employees</a></li>	            	            
	            	<?php if (isset($_SESSION['is_admin'])) { ?>
	            		<li><a class="<?php echo ($_SESSION['create_account'] == true ? "active" : ""); ?> list-group-item" href="account.php?create=Employee">Create New Employee</a></li>
	            	<?php } ?>
	            	<li><a href="account.php?change=Password" class="<?php echo ($_SESSION['change_password'] == true ? "active" : ""); ?> list-group-item">Change Password</a></li>
		            
		            <!-- <li><a href="#">Analytics</a></li>
		            <!-- <li><a href="#">Export</a></li> -->
		      	<!-- </ul>
		          	<ul class="nav nav-sidebar">
		            <li><a href="">Nav item</a></li>
		            <li><a href="">Nav item again</a></li>
		            <li><a href="">One more nav</a></li>
		            <li><a href="">Another nav item</a></li>
		            <li><a href="">More navigation</a></li>
		      	</ul>
		          	<ul class="nav nav-sidebar">
		            <li><a href="">Nav item again</a></li>
		            <li><a href="">One more nav</a></li>
		            <li><a href="">Another nav item</a></li>
		      	</ul> -->
	        </div>
        <?php } ?>

<!------------------------------------------------------------

	USER IS NOT LOGGED IN

-------------------------------------------------------------->

		<?php if (isset($_SESSION['logged_in']) == NULL) { ?>
			<h2>Please <a href="index.php">Login</a></h2>

<!------------------------------------------------------------

	WHEN THE USER IS LOGGED IN AND AT THEIR DASHBOARD

-------------------------------------------------------------->

		<?php } elseif (isset($_SESSION['logged_in']) && 
						isset($_SESSION['new_user']) == NULL && 
						isset($_SESSION['edit_account']) == NULL && 
						isset($_SESSION['view_admins']) == NULL && 
						isset($_SESSION['get_name']) == NULL &&
						isset($_SESSION['search_name']) == NULL &&
						isset($_SESSION['edit_other']) == NULL &&
						isset($_SESSION['create_account']) == NULL &&
						isset($_SESSION['change_password']) == NULL &&
						isset($_SESSION['delete_user']) == NULL &&
						isset($_SESSION['send_message']) == NULL) { ?>

	<div class="container">		
		<div class="table-responsive my-info accountExpand">

			<?php if (isset($_SESSION['message_success'])) { ?>
				<div class="alert alert-success" role="alert" style="text-align: center;">
					<p>Message sent successfully</p>
				</div>
			<?php $_SESSION['message_success'] = NULL; } ?>

			<h2 id="accountExpand">Welcome, <?php echo $_SESSION['MEM_FNAME'].' '.$_SESSION['MEM_LNAME']; ?> </h2>
			<div class="card">
			  	<img src="images/person_fillin_male.png" alt="Avatar" class="img-rounded" style="width: 40%; height:25%;">

		    	<table class="table table-striped">
					<tr>
						<th>ID</th>
						<td><?php echo $_SESSION['MEM_ID']; ?></td>
					</tr>
					<tr>
						<th>Username</th>
						<td><?php echo $_SESSION['MEM_USERNAME']; ?></td>
					</tr>
					<tr>
						<th>Name</th>
						<td><?php echo $_SESSION['MEM_FNAME'].' '.$_SESSION['MEM_LNAME']; ?></td>
					</tr>
					<tr>
						<th>Address</th>
						<td><?php echo $_SESSION['MEM_ADDRESS'].'<br>'.$_SESSION['MEM_CITY'].', '.$_SESSION['MEM_STATE'].' '.$_SESSION['MEM_ZIPCODE']; ?></td>
					</tr>
					<tr>
						<th>Phone</th>
						<td><?php echo $_SESSION['MEM_PHONE']; ?></td>
					</tr>
					<tr>
						<th>Title</th>
						<td><?php echo $_SESSION['MEM_TITLE']; ?></td>
					</tr>
					<tr>
						<th>Membership Status</th>
						<td><?php echo $_SESSION['MEM_STATUS']; ?></td>
					</tr>
					<tr>
						<th>Date Joined</th>
						<td><?php $datejoined = strtotime( $_SESSION['MEM_DATEJOINED'] );
									$mysqldatejoined = date( 'F d, Y', $datejoined ); 
									echo $mysqldatejoined; ?></td>
					</tr>
					<tr>
						<th>Last Login</th>
						<td><?php $last_login = strtotime( $_SESSION['MEM_LASTLOGIN'] );
									$mysqlLastLogin = date( 'F d, Y g:i a', $last_login ); 
									echo $mysqlLastLogin; ?></td>
					</tr>
					<tr>
						<th>My Permissions</th>
						<td>
							<?php if($_SESSION['is_admin']) { echo "<p>Administrator</p>";} ?>
							<?php if($_SESSION['publisher']) { echo "<p>Publisher</p>";} ?>
						</td>
					</tr>
				</table>

			</div>
		</div>				
	</div>

<!------------------------------------------------------------

	VIEW ALL ADMINS

-------------------------------------------------------------->

		<?php } elseif (isset($_SESSION['logged_in']) && 
						isset($_SESSION['new_user']) == NULL && 
						isset($_SESSION['edit_account']) == NULL && 
						isset($_SESSION['view_admins']) && 
						isset($_SESSION['get_name']) == NULL &&
						isset($_SESSION['search_name']) == NULL &&
						isset($_SESSION['edit_other']) == NULL &&
						isset($_SESSION['create_account']) == NULL &&
						isset($_SESSION['change_password']) == NULL &&
						isset($_SESSION['send_message']) == NULL) { ?>

			

			<div class="table-responsive my-info-admins">

				<?php if(isset($_SESSION['success'])) { ?>
					<div class="alert alert-success" role="alert" style="text-align: center;">
						<p>User Account Created Successfully</p>
					</div>
				<?php $_SESSION['success'] = NULL; } elseif (isset($_SESSION['delete_user'])) { ?>

					<div class="alert alert-success" role="alert" style="text-align: center;">
						<p>User Deleted Successfully</p>
					</div>
				<?php $_SESSION['delete_user'] = NULL; } elseif (isset($_SESSION['reset_password'])) { ?>

					<div class="alert alert-success" role="alert" style="text-align: center;">
						<p>User Password was Reset Successfully</p>
					</div>
				<?php $_SESSION['reset_password'] = NULL; } ?>

				<h2 style="text-align: center;">Employees</h2>
		            <table class="table table-striped table-hover table-condensed">
						<tr>
							<th>Name</th>
							<th>Status</th>
							<th>Title</th>
						</tr>
						<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>			
							<tr>							
								<td><a href="account.php?id=<?php echo $row['MEM_ID']; ?>"><?php echo $row['MEM_FNAME'].' '.$row['MEM_LNAME'] ?></a></td>
								<td><?php echo $row['MEM_STATUS']; ?>
								<td><?php echo $row['MEM_TITLE'] ?></td>							
							</tr>
						<?php } ?>
					</table>
					
				</div>

<!------------------------------------------------------------

	SEARCHING FOR AN EMPLOYEE

-------------------------------------------------------------->

		<?php } elseif (isset($_SESSION['logged_in']) && 
						isset($_SESSION['new_user']) == NULL && 
						isset($_SESSION['edit_account']) == NULL && 
						isset($_SESSION['view_admins']) == NULL && 
						isset($_SESSION['get_name']) == NULL &&
						isset($_SESSION['search_name']) &&
						isset($_SESSION['edit_other']) == NULL &&
						isset($_SESSION['create_account']) == NULL &&
						isset($_SESSION['change_password']) == NULL &&
						isset($_SESSION['delete_user']) == NULL &&
						isset($_SESSION['send_message']) == NULL) { ?>

			<p><strong>Searching for: </strong><?php echo $searchStr; ?></p>

			<div class="table-responsive my-info-admins">
	            <table class="table table-striped table-hover table-condensed">
					<tr>
						<th>ID</th>
    					<th>Name</th>
    					<th>Status</th>
    					<th>Title</th>
    					<!-- <th>Misc</th> -->
        			</tr>
	            	<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>	            		
	            		<tr>
	            			<td><?php echo $row['MEM_ID']; ?></td>
	            			<td><a href="account.php?id=<?php echo $row['MEM_ID']; ?>"><?php echo $row['MEM_FNAME'].' '.$row['MEM_LNAME']; ?></a></td>
	            			<td><?php echo $row['MEM_STATUS'] ?></td>
							<td><?php echo $row['MEM_TITLE'] ?></td>
							<?php if (isset($_SESSION['is_admin'])) { ?>
								<!-- <td>
									<a class="btn btn-default" href="account.php?editOther=<?php echo $row['MEM_ID']; ?>">Edit</a>
								</td> -->
							<?php } ?>
	            		</tr>
	            	<?php } //else { ?>
	            		<!-- <p>No Employee with that ID exists</p> -->
	            	<?php //} ?>

	            </table>
			</div>

<!------------------------------------------------------------

	MORE DETAILED PAGE OF AN ADMIN

-------------------------------------------------------------->

		<?php } elseif (isset($_SESSION['logged_in']) && 
						isset($_SESSION['new_user']) == NULL && 
						isset($_SESSION['edit_account']) == NULL && 
						isset($_SESSION['view_admins']) && 
						isset($_SESSION['get_name']) &&
						isset($_SESSION['search_name']) == NULL &&
						isset($_SESSION['edit_other']) == NULL &&
						isset($_SESSION['create_account']) == NULL &&
						isset($_SESSION['change_password']) == NULL &&
						isset($_SESSION['delete_user']) == NULL &&
						isset($_SESSION['send_message']) == NULL) { ?>


        	<?php if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

        		<a href="account.php?sendMessageTo=<?php echo $row['MEM_ID']; ?>" class="btn btn-info">Message</a>
        		<a href="account.php?editOther=<?php echo $row['MEM_ID']; ?>" class="btn btn-info">Edit Employee</a>
        		
        		<?php if(isset($_SESSION['cant_delete']) == NULL) { ?>
        			<button id="resetPWBtn" class="btn btn-info">Reset Password</button>
        			<button id="deleteUserBtn" class="btn btn-danger">Delete Employee</button>
        		<?php } ?>

        		<h2 id="accountExpand"><?php echo $row['MEM_FNAME'].' '.$row['MEM_LNAME']; ?> </h2>
				<div class="table-responsive my-info accountExpand">
        			<table class="table table-striped">
		        		<div class="card">
						  	<img src="images/person_fillin_male.png" alt="Avatar" class="img-rounded" style="width: 25%; height:25%;">
						  	<div class="container">
								<tr>
			            			<th>Name</th>
			            			<td><?php echo $row['MEM_FNAME'].' '.$row['MEM_LNAME']; ?></td>
			            		</tr>
						    	<tr>
									<th>Title</th>
									<td><?php echo $row['MEM_TITLE']; ?></td>
								</tr>
								<tr>
									<th>Address</th>
									<td><?php echo $row['MEM_ADDRESS'].'<br>'.$row['MEM_CITY'].', '.$row['MEM_STATE'].' '.$row['MEM_ZIPCODE']; ?></td>
								</tr>
								<tr>
									<th>Phone</th>
									<td><?php echo $row['MEM_PHONE']; ?></td>
								</tr>								
								<tr>
									<th>Membership Status</th>
									<td><?php echo $row['MEM_STATUS']; ?></td>
								</tr>
								<tr>
									<th>Date Joined</th>
									<td><?php $datejoined = strtotime( $row['MEM_DATEJOINED'] );
												$mysqldatejoined = date( 'F d, Y', $datejoined ); 
												echo $mysqldatejoined; ?></td>
								</tr>
								<tr>
									<th>Last Login</th>
									<td><?php $last_login = strtotime( $row['MEM_LASTLOGIN'] );
												$mysqlLastLogin = date( 'F d, Y g:i a', $last_login ); 
												echo $mysqlLastLogin; ?></td>
								</tr>
						  	</div>
						</div>
        			</table>
	            </div>
	            <!-- The Delete User Modal -->
				<div id="deleteUserModal" class="modal">

				  <!-- Modal content -->
				  	<div class="modal-content">
				  		<span class="close1">&times;</span>
				    	<h2 class="bg-danger">Delete User</h2>
				    	<p>Are you sure you want to delete this user?</p>
				    	<a href="account.php?deleteId=<?php echo $row['MEM_ID']; ?>" class="btn btn-danger">Yes</a>
				    	<a href="#" id="noBtn1" class="btn btn-default">No</a>
				  	</div>
				</div>
				<!-- The Reset Password Modal -->
				<div id="resetPasswordModal" class="modal">

				  <!-- Modal content -->
				  	<div class="modal-content">
				  		<span class="close2">&times;</span>
				    	<h2>Password Reset</h2>
				    	<p>Are you sure you want to Reset this user's password?</p>
				    	<a href="account.php?resetPassword=<?php echo $row['MEM_ID']; ?>" class="btn btn-danger">Yes</a>
				    	<a href="#" id="noBtn2" class="btn btn-default">No</a>
				  	</div>
				</div>
        	<?php } ?>

<!------------------------------------------------------------

	EDIT ACCOUNT PAGE

-------------------------------------------------------------->

		<?php } elseif (isset($_SESSION['logged_in']) && 
						isset($_SESSION['new_user']) == NULL && 
						isset($_SESSION['edit_account']) && 
						isset($_SESSION['view_admins']) == NULL && 
						isset($_SESSION['get_name']) == NULL &&
						isset($_SESSION['search_name']) == NULL &&
						isset($_SESSION['edit_other']) == NULL &&
						isset($_SESSION['create_account']) == NULL &&
						isset($_SESSION['change_password']) == NULL &&
						isset($_SESSION['delete_user']) == NULL &&
						isset($_SESSION['send_message']) == NULL) { ?>
			
			<?php $_SESSION['edit_other_id'] = $_SESSION['MEM_ID']; ?>
			<div class="table-responsive my-info accountExpand">
	            
	            <h2 id="accountExpand">Welcome, <?php echo $_SESSION['MEM_FNAME'].' '.$_SESSION['MEM_LNAME']; ?> </h2>
            	<form action="account.php?myAccount=edit" method="post">
	            	<table class="table table-striped">
						<tr>
							<th>ID</th>
							<td><?php echo $_SESSION['MEM_ID']; ?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?php echo $_SESSION['MEM_FNAME'].' '.$_SESSION['MEM_LNAME']; ?></td>
						</tr>
						<tr>
							<th><label for="address">Address</label></th>
							<td><input type="address" id="address" name="address" value="<?php echo $_SESSION['MEM_ADDRESS']; ?>" class="textfield-sm" autofocus></td>
						</tr>
						<tr>
							<th><label for="city">City</label></th>
							<td><input type="city" id="city" name="city" value="<?php echo $_SESSION['MEM_CITY']; ?>" class="textfield-sm"></td>
						</tr>
						<tr>
							<th><label for="state">State</label></th>
							<td>
								<select id="state" name="state" class="textfield-sm" style="border-radius: 2px;" value="<?php echo $_SESSION['MEM_STATE']; ?>" required>
									<option><?php echo $_SESSION['MEM_STATE']; ?></option>
									<?php include('includes/states.php'); ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="zipcode">Zipcode</label></th>
							<td><input type="zipcode" id="zipcode" name="zipcode" value="<?php echo $_SESSION['MEM_ZIPCODE']; ?>" class="textfield-sm"></td>
						</tr>
						<tr>
							<th><label for="edit-phone">Phone</label></th>
							<td><input type="text" id="edit-phone" minlength="10" name="phone" value="<?php echo $_SESSION['MEM_PHONE']; ?>" class="textfield-sm"></td>
							<p id="demo"></p>					
						</tr>
						<tr>
							<th>Title</th>
							<td><?php echo $_SESSION['MEM_TITLE']; ?></td>
						</tr>
						<tr>
							<th>Membership Status</th>
							<td><?php echo $_SESSION['MEM_STATUS']; ?></td>
						</tr>
						<tr>
							<th>Date Joined</th>
							<td><?php $datejoined = strtotime( $_SESSION['MEM_DATEJOINED'] );
										$mysqldatejoined = date( 'F d, Y', $datejoined ); 
										echo $mysqldatejoined; ?></td>
						</tr>
						<tr>
							<th>Last Login</th>
							<td><?php $last_login = strtotime( $_SESSION['MEM_LASTLOGIN'] );
										$mysqlLastLogin = date( 'F d, Y g:i a', $last_login ); 
										echo $mysqlLastLogin; ?></td>
						</tr>
					</table>
					<table class="buttontable">
						<tr>
							<td><button type="submit" name="submit" class="buttons">Submit</button></td>
							<td><button type="reset" name="reset" class="buttons">Reset</button></td>
						</tr>
					</table>						
				</form>
			</div>

<!------------------------------------------------------------

	EDIT OTHER ACCOUNTS PAGE

-------------------------------------------------------------->

			<?php } elseif (isset($_SESSION['logged_in']) && 
						isset($_SESSION['new_user']) == NULL && 
						isset($_SESSION['edit_account']) == NULL && 
						isset($_SESSION['view_admins']) == NULL && 
						isset($_SESSION['get_name']) == NULL &&
						isset($_SESSION['search_name']) == NULL &&
						isset($_SESSION['edit_other']) &&
						isset($_SESSION['create_account']) == NULL &&
						isset($_SESSION['change_password']) == NULL &&
						isset($_SESSION['delete_user']) == NULL &&
						isset($_SESSION['send_message']) == NULL) { ?>
				
            	<?php if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            		$_SESSION['edit_other_id'] = $row['MEM_ID']; ?>
            		<div class="table-responsive my-info accountExpand">
            			<h2><?php echo $row['MEM_FNAME'].' '.$row['MEM_LNAME']; ?> </h2>
			            <form action="account.php?empid=<?php echo $row['MEM_ID']; ?>" method="post">
	            			<table class="table table-striped">
		            		
								<tr>
									<th>ID</th>
									<td><?php echo $row['MEM_ID']; ?></td>
								</tr>
								<tr>
									<th>Name</th>
									<td><?php echo $row['MEM_FNAME'].' '.$row['MEM_LNAME']; ?></td>
								</tr>
								<tr>
									<th>Address</th>
									<td><input type="address" name="address" value="<?php echo $row['MEM_ADDRESS']; ?>" class="textfield-sm"></td>
								</tr>
								<tr>
									<th>City</th>
									<td><input type="city" name="city" value="<?php echo $row['MEM_CITY']; ?>" class="textfield-sm"></td>
								</tr>
								<tr>
									<th>State</th>
									<td><input type="state" name="state" value="<?php echo $row['MEM_STATE']; ?>" class="textfield-sm"></td>
								</tr>
								<tr>
									<th>Zip Code</th>
									<td><input type="zipcode" name="zipcode" value="<?php echo $row['MEM_ZIPCODE']; ?>" class="textfield-sm"></td>
								</tr>
								<tr>
									<th>Phone</th>
									<td><input type="phone" name="phone" value="<?php echo $row['MEM_PHONE']; ?>" class="textfield-sm"></td>
								</tr>
								<tr>
									<th>Title</th>
									<td><?php echo $row['MEM_TITLE']; ?></td>
								</tr>
								<tr>
									<th>Membership Status</th>
									<td><?php echo $row['MEM_STATUS']; ?></td>
								</tr>
								<tr>
									<th>Date Joined</th>
									<td><?php $datejoined = strtotime( $row['MEM_DATEJOINED'] );
												$mysqldatejoined = date( 'F d, Y', $datejoined ); 
												echo $mysqldatejoined; ?></td>
								</tr>
								<tr>
									<th>Last Login</th>
									<td><?php $last_login = strtotime( $row['MEM_LASTLOGIN'] );
												$mysqlLastLogin = date( 'F d, Y g:i a', $last_login ); 
												echo $mysqlLastLogin; ?></td>
								</tr>							
							</table>
							
							<div class="buttontable">
								<button type="submit" name="submit" class="buttons">Submit</button>
								<button type="reset" name="reset" class="buttons">Reset</button>
							</div>
						</form>
					</div>
				<?php } ?>
				
<!------------------------------------------------------------

	CREATING A NEW EMPLOYEE

-------------------------------------------------------------->

			<?php } elseif (isset($_SESSION['logged_in']) && 
					isset($_SESSION['new_user']) == NULL && 
					isset($_SESSION['edit_account']) == NULL && 
					isset($_SESSION['view_admins']) == NULL && 
					isset($_SESSION['get_name']) == NULL &&
					isset($_SESSION['search_name']) == NULL &&
					isset($_SESSION['edit_other']) == NULL &&
					isset($_SESSION['create_account']) &&
					isset($_SESSION['is_admin']) &&
					isset($_SESSION['change_password']) == NULL &&
					isset($_SESSION['delete_user']) == NULL &&
					isset($_SESSION['send_message']) == NULL) { ?>

				<div class="table-responsive my-info accountExpand">
		            <table class="table table-striped">
		            <h2 id="accountExpand">Create New Employee</h2>
		            	<span id="confirmMessage"></span>
		            	<form action="account.php" method="post">
							<tr>
								<th><label for="fname">First Name</label></th>
								<td><input id="fname" type="text" name="create-fname" placeholder="First Name" class="textfield-sm" autofocus required><span class="error"></td>
							</tr>
							<tr>
								<th><label for="lname">Last Name</label></th>
								<td><input id="lname" type="text" name="create-lname" placeholder="Last Name" class="textfield-sm" required></td>
							</tr>
							<tr>
								<th><label for="address">Address</label></th>
								<td><input id="address" type="text" name="create-address" placeholder="Address" class="textfield-sm" required></td>
							</tr>
							<tr>
								<th><label for="city">City</label></th>
								<td><input id="city" type="text" name="create-city" placeholder="City" class="textfield-sm" required></td>
							</tr>
							<tr>
								<th><label for="state">State</label></th>
								<td>
									<select id="state" name="create-state" class="textfield-sm" style="border-radius: 2px;" required>
										<?php include('includes/states.php'); ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><label for="zipcode">ZipCode</label></th>
								<td>
									<input id="zipcode" type="number" name="create-zipcode" placeholder="Zipcode" maxlength="5" pattern="^([\d]{5})" title="Zipcode must be integers e.g. 12345" class="textfield-sm" required>
								</td>
							</tr>
							<tr>
								<th><label for="phone">Phone</label></th>
								<td>
									<input id="create-phone" onkeyup="phoneNumber(); return false;" type="text" name="create-phone" placeholder="Phone Number" class="textfield-sm" required>
								</td>
							</tr>
							<tr>
								<th><label for="title">Title</label></th>
								<td><input id="title" type="text" name="create-title" placeholder="Title" class="textfield-sm"></td>
							</tr>
							<tr>
								<th><label for="status">Membership Status</label></th>
								<td>
									<select id="status" name="create-status" class="textfield-sm" style="border-radius: 2px;" required>
										<option value="Admin">Admin</option>
										<option value="Employee">Employee</option>
									</select>
								</td>
							</tr>
							<tr class="buttontable">
								<td><button type="submit" name="submit" class="buttons">Submit</button></td>
								<td><button type="reset" name="reset" class="buttons">Reset</button></td>
							</tr>
						</form>
					</table>
				</div>

<!------------------------------------------------------------

	CHANGE LOGGED IN USER'S PASSWORD

-------------------------------------------------------------->

<?php } elseif (isset($_SESSION['logged_in']) && 
					isset($_SESSION['new_user']) == NULL && 
					isset($_SESSION['edit_account']) == NULL && 
					isset($_SESSION['view_admins']) == NULL && 
					isset($_SESSION['get_name']) == NULL &&
					isset($_SESSION['search_name']) == NULL &&
					isset($_SESSION['edit_other']) == NULL &&
					isset($_SESSION['create_account']) == NULL &&
					isset($_SESSION['change_password']) &&
					isset($_SESSION['delete_user']) == NULL &&
					isset($_SESSION['send_message']) == NULL) { ?>
	<h2>Change Password</h2>
	<span id="confirmMessage"></span>		
	
	<div class="table-responsive my-info accountExpand">

		<?php if(isset($_SESSION['passwordChange_success'])) { ?>
			<div class="alert alert-success" role="alert" style="text-align: center;">
				<p>Password Changed Successfully</p>
			</div>
		<?php $_SESSION['passwordChange_success'] = NULL; } ?>

		<form action="account.php?change=Success" method="post">
		    <table class="table table-striped">
		    	<tr>
		    		<th><label for="newPassword">New Password</label></th>
		    		<td><input type="password" name="newPassword" id="newPassword" placeholder="New Password" class="textfield-sm" autofocus required></td>
		    	</tr>
		    	<tr>
		    		<th><label for="confirmPassword">Confirm Password</label></th>
		    		<td><input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="textfield-sm" onkeyup="checkPass(); return false;" required></td>
		    	</tr>
		    </table>
		    <table class="buttontable">
		    	<tr>
		    		<td><button type="submit" name="submit" class="buttons">Change</button></td>
		    		<td><button type="reset" name="reset" class="buttons">Reset</button></td>
		    	</tr>
		    </table>
		</form>
	</div>

<!------------------------------------------------------------

	SENDING A USER A PERSONAL MESSAGE

-------------------------------------------------------------->

<?php } elseif (isset($_SESSION['logged_in']) && 
					isset($_SESSION['new_user']) == NULL && 
					isset($_SESSION['edit_account']) == NULL && 
					isset($_SESSION['view_admins']) == NULL && 
					isset($_SESSION['get_name']) == NULL &&
					isset($_SESSION['search_name']) == NULL &&
					isset($_SESSION['edit_other']) == NULL &&
					isset($_SESSION['create_account']) == NULL &&
					isset($_SESSION['change_password']) == NULL &&
					isset($_SESSION['delete_user']) == NULL &&
					isset($_SESSION['send_message'])) { ?>

	<div class="table-responsive my-info accountExpand">		
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
					<h3 class="panel-title">Sending message to <?php echo $row['MEM_FNAME'].' '.$row['MEM_LNAME']; ?></h3>
				<?php } ?>
			</div>
			<div class="panel-body">
				<form action="account.php" method="post">			        												
					<textarea id="message" name="message" placeholder="Message..." autofocus required></textarea>
					<table class="buttontable">
				    	<tr>
				    		<td><button type="submit" name="submit" class="buttons">Send</button></td>
				    	</tr>
				    </table>
			    </form>
			</div>
		</div>		
	</div>





		<!-- If the user is logged in, but is a new user
			This will send them to the createaccount.php page -->
		<?php } else { ?>
			<p>You must finish creating your account. <a href="createaccount.php">Create Account</a></p>
		<?php } ?>

	</div>



	<?php include('includes/scripts.php'); ?>
</body>

<?php include('includes/footer.php'); ?>