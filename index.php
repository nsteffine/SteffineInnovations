<?php 

$page_name = "Login";
$page_id = "login";

include('includes/session_start.php');

include('includes/dbconn.php');

$msg = '';

if ($_POST) {
	
	//set the username and password variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password = md5($password);

	// Logging in the user
	$query = "SELECT * FROM MEMBER WHERE MEM_USERNAME = \"$username\" AND MEM_PASSWORD = \"$password\";";
	$stmt = $conn->prepare($query);
	$stmt->execute();

	// If the user is found this block of code will be executed
	if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		$_SESSION['user_found'] = true;
		$_SESSION['logged_in'] = true;

		$_SESSION['MEM_ID'] = $row['MEM_ID'];
		$_SESSION['MEM_USERNAME'] = $row['MEM_USERNAME'];
		$_SESSION['MEM_FNAME'] = $row['MEM_FNAME'];
		$_SESSION['MEM_LNAME'] = $row['MEM_LNAME'];
		$_SESSION['MEM_ADDRESS'] = $row['MEM_ADDRESS'];
		$_SESSION['MEM_CITY'] = $row['MEM_CITY'];
		$_SESSION['MEM_STATE'] = $row['MEM_STATE'];
		$_SESSION['MEM_ZIPCODE'] = $row['MEM_ZIPCODE'];
		$_SESSION['MEM_PHONE'] = $row['MEM_PHONE'];
		$_SESSION['MEM_DATEJOINED'] = $row['MEM_DATEJOINED'];
		$_SESSION['MEM_LASTLOGIN'] = $row['MEM_LASTLOGIN'];
		$_SESSION['MEM_TITLE'] = $row['MEM_TITLE'];
		$_SESSION['MEM_STATUS'] = $row['MEM_STATUS'];

		$mem_id = $_SESSION['MEM_ID'];

		// If the user is found, but never logged on before
		if ($row['MEM_LASTLOGIN'] == NULL) {

			$_SESSION['new_user'] = true;
			header('Location: createaccount.php');

		} else { // If the user is found we'll update his last login

		$query2 = "UPDATE MEMBER SET MEM_LASTLOGIN = NOW() WHERE MEM_ID = $mem_id;";
		$stmt2 = $conn->prepare($query2);
		$stmt2->execute();

		header('Location: account.php');
	}

		// If the user is an Admin we'll set his privledges
		if ($row['MEM_STATUS'] == "Admin") {
			$_SESSION['is_admin'] = true;
			$_SESSION['publisher'] = true;
		} else {
			$_SESSION['is_admin'] = NULL;
			$_SESSION['publisher'] = NULL;
		}


	} else {
		$msg = "<div class=\"alert alert-danger\" role=\"alert\"><p>Incorrect Username/Password</p></div>";
		$_SESSION['user_found'] = NULL;
		$_SESSION['logged_in'] = NULL;
	}
}

//When the user Clicks the "Logout" button
if (isset($_GET['log'])) {
	
	//destroy the session and log out
	session_destroy();

	//refreshing the page
	header("Location:index.php");
}

?>

<?php include('includes/header.php'); ?>
<body class="wrapper">
	<div class="container">

		<?php if (isset($_SESSION['logged_in']) == NULL) { ?>

			<?php if (isset($_SESSION['user_found']) == NULL) { ?>
				<?php echo $msg; ?>
			<?php } ?>

			<h2>Please Login</h2>
			<form action="index.php" method="POST" id="loginform" name="loginForm">
				<div class="table-responsive my-info" style="width: 100%;">
				    <table class="table table-striped">
				    	<tr>
				    		<th><label for="username">Username</label></th>
				    	</tr>
				    	<tr>
				    		<!-- <th><label for="username">Username</label></th> -->
				    		<td>
				    			<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">@</span>
									<input type="text" id="username" name="username" placeholder="Username" class="textfield" maxlength="20" minlength="1" autocomplete="off" autofocus required>
								</div>
				    		</td>
				    	</tr>
				    	<tr>
				    		<th><label for="password">Password</label></th>
				    	</tr>
				    	<tr>
				    		<!-- <th><label for="password">Password</label></th> -->
				    		<td><input type="password" id="password" name="password" placeholder="Password" class="textfield" maxlength="50" minlength="8" autocomplete="off" required></td>
				    	</tr>						
				    </table>
				    <table class="buttontable">
				    	<tr>
				    		<td><button type="submit" name="submit" class="buttons">Login</button></td>
				    		<td><button type="reset" name="reset" class="buttons">Reset</button></td>
				    	</tr>
				    </table>
				</div>
			</form>
			
		<?php } else { ?>

		<?php } ?>

	</div>

	<!-- <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#">Home</a>
          <a class="blog-nav-item" href="#">New features</a>
          <a class="blog-nav-item" href="#">Press</a>
          <a class="blog-nav-item" href="#">New hires</a>
          <a class="blog-nav-item" href="#">About</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">The Bootstrap Blog</h1>
        <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

          <div class="blog-post">
            <h2 class="blog-post-title">Sample blog post</h2>
            <p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>

            <p>This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>
            <hr>
            <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
            <blockquote>
              <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong> ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            </blockquote>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
            <h2>Heading</h2>
            <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
            <h3>Sub-heading</h3>
            <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
            <pre><code>Example code block</code></pre>
            <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
            <h3>Sub-heading</h3>
            <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <ul>
              <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
              <li>Donec id elit non mi porta gravida at eget metus.</li>
              <li>Nulla vitae elit libero, a pharetra augue.</li>
            </ul>
            <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>
            <ol>
              <li>Vestibulum id ligula porta felis euismod semper.</li>
              <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
              <li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>
            </ol>
            <p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.</p>
          </div><!-- /.blog-post -->

          <!-- <nav>
            <ul class="pager">
              <li><a href="#">Previous</a></li>
              <li><a href="#">Next</a></li>
            </ul>
          </nav> -->

        <!-- </div>/.blog-main -->

        <!-- <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>
          <div class="sidebar-module">
            <h4>Archives</h4>
            <ol class="list-unstyled">
              <li><a href="#">March 2014</a></li>
              <li><a href="#">February 2014</a></li>
              <li><a href="#">January 2014</a></li>
              <li><a href="#">December 2013</a></li>
              <li><a href="#">November 2013</a></li>
              <li><a href="#">October 2013</a></li>
              <li><a href="#">September 2013</a></li>
              <li><a href="#">August 2013</a></li>
              <li><a href="#">July 2013</a></li>
              <li><a href="#">June 2013</a></li>
              <li><a href="#">May 2013</a></li>
              <li><a href="#">April 2013</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Elsewhere</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Facebook</a></li>
            </ol>
          </div> -->
        <!-- </div>/.blog-sidebar -->

      <!-- </div>/.row -->

    </div><!-- /.container -->
	<?php include('includes/scripts.php'); ?>
</body>

<?php include('includes/footer.php'); ?>