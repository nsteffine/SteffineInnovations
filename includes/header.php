dfdf<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	    <!-- Bootstrap -->
	    <link rel="stylesheet" href="css/bootstrap.min.css">

	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->

	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
		<title><?php echo $page_name; ?></title>
	</head>

	<header>

		<div id="logo">
			<!-- <img src="images/Preview2.jpg"> -->
		</div>

		<nav class="navbar navbar-default">

			<div class="navbar-header">
	          	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
	          	</button>
        	</div>

			<div id="navbar" class="navbar-collapse collapse">
          		<ul class="nav navbar-nav">
          			<li><a href="index.php" class="<?php echo ($page_id == "login" ? "active btn disabled" : ""); ?>">Home</a></li>
          			<li><a href="ourmission.php" class="<?php echo ($page_id == "ourMission" ? "active btn disabled" : ""); ?>">Our Mission</a></li>
          			<li><a href="projects.php" class="<?php echo ($page_id == "projects" ? "active btn disabled" : ""); ?>">Projects</a></li>

          			<!-- If the user is logged in, "My Account" will display; otherwise "Login" will display -->
          			<?php if (isset($_SESSION['logged_in'])) { ?>
						<li class="drop">
							<a href="account.php" id="profile" class="<?php echo ($page_id == "myAccount" ? "active btn disabled" : ""); ?>">My Dashboard</a>

							<!-- NOT SURE HOW I FEEL ABOUT THIS DROPDOWN BOX -->
							<!-- <div class="drop-content">
								<a href="account.php" class="<?php echo ($page_id == "myAccount" ? "active" : ""); ?> dropdown-toggle">My Account</a>
								<a href="#" class="<?php echo ($page_id == "mail" ? "active" : ""); ?>">My Mail</a>
							</div> -->
						</li>
					<?php } ?>					
          		</ul>
          		<!-- Once the user is logged in "Logout" will display -->
				<ul class="nav navbar-nav navbar-right">
			        <?php if (isset($_SESSION['logged_in'])) { ?>
						<li class="drop">							
							<a href="index.php?log=out">Logout</a>
							<div class="drop-content">
								<span style="font-size: 15px;">Logout of <?php echo $_SESSION["MEM_USERNAME"]; ?></span>
							</div>
						</li>
					<?php } else { ?>
						<li>
							<!-- <a href="index.php" class="<?php echo ($page_id == "login" ? "active" : ""); ?>">Login</a> -->
							<form class="form-inline" action="index.php" method="POST" name="loginForm">
							  	<div class="form-group">
								    <label for="username">Username</label>
								    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
							 	</div>
							 	<div class="form-group">
								    <label for="password">Password</label>
								    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
							  	</div>
							  	<button type="submit" class="btn btn-default">Login</button>
							</form>
						</li>
								<!-- <td>
									<form action="index.php" method="POST" id="loginform" name="loginForm">
										
										<input type="text" name="username" placeholder="Username" class="textfield-sm" style="width: 50%;" maxlength="20" minlength="1" autocomplete="off" required>					
										<input type="password" name="password" placeholder="Password" class="textfield-sm" style="width: 50%;" maxlength="50" minlength="8" autocomplete="off" required>
										<button type="submit" name="submit" class="buttons-sm">Login</button>
									</form>
								</td> -->
					<?php } ?>
		      	</ul>
          	</div>

		</nav>

	</header>