<?php 

$page_name = "Our Mission";
$page_id = "ourMission";

include('includes/session_start.php');
include('includes/header.php');
include('includes/dbconn.php');

$msg = '';

if ($_POST) {

	$member = $_SESSION['MEM_ID'];
	$mission = $_POST['mission'];

	$query = "INSERT INTO `MISSION_EDITS`(`MISSEDIT_ID`, `MISSEDIT_TEXT`, `MISSEDIT_EDITDATE`, `MISSEDIT_MEM_ID`) 
				VALUES (NULL, \"$mission\", NOW(), $member)";
	$stmt = $conn->prepare($query);
	$stmt->execute();
}

$query3 = "SELECT MISSEDIT_TEXT, MISSEDIT_EDITDATE, MISSEDIT_MEM_ID, MEM_ID, MEM_USERNAME
			FROM MISSION_EDITS, MEMBER
			WHERE MEM_ID = MISSEDIT_MEM_ID
			ORDER BY MISSEDIT_EDITDATE DESC;";
$stmt3 = $conn->prepare($query3);
$stmt3->execute();



?>

<body class="wrapper">
	<div class="container">

	<!-- Carousel
    ================================================== -->
    <!-- <div id="myCarousel" class="carousel slide" data-ride="carousel"> -->
      <!-- Indicators -->
      <!-- <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="" alt="First slide" style="height: 400px; margin: auto; background: gray; width: 100%;">
          <div class="">
            <div class="carousel-caption">
              <h1>Our Mission</h1>
              	<?php 

					$query2 = "SELECT * FROM MISSION_EDITS ORDER BY MISSEDIT_ID DESC LIMIT 1;";
					$stmt2 = $conn->prepare($query2);
					$stmt2->execute();

					if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
						<p><?php echo $row['MISSEDIT_TEXT']; ?></p>
				<?php } ?>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
            </div>
          </div>
        </div>
        <div class="item"> -->
          <!-- <img class="second-slide" src="images/SI-phone.jpg" alt="Second slide" style="height: 400px; margin: auto;"> -->
          <!-- <div class="container"> -->
            <!-- <div class="carousel-caption"> -->
              <!-- <h1>Another example headline.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
           <!--  </div>
          </div>
        </div>
        <div class="item"> -->
          <!-- <img class="third-slide" src="images/Top_view.jpg" alt="Third slide" style="height: 400px; margin: auto;"> -->
          <!-- <div class="container"> -->
            <!-- <div class="carousel-caption"> -->
              <!-- <h1>One more for good measure.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p> -->
            <!-- </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div> --><!-- /.carousel -->
    	<div class="jumbotron">
			<h1 class="sub-header">Our Mission</h1>

				<?php 

				$query2 = "SELECT * FROM MISSION_EDITS ORDER BY MISSEDIT_ID DESC LIMIT 1;";
				$stmt2 = $conn->prepare($query2);
				$stmt2->execute();

				if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>

					<p><?php echo $row['MISSEDIT_TEXT']; ?></p>
					<?php if (isset($_SESSION['is_admin']) && isset($_SESSION['new_user']) == NULL) { ?>
						<a class="btn btn-primary btn-lg" href="ourmission.php?edit=mission">Edit Mission Statement</a>
					<?php } ?>
					  <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p> -->		
				
				<?php } ?>
		</div>

		

		<?php

			if (isset($_GET['edit'])) { ?>

				<form action="ourmission.php" method="post">
					<textarea name="mission" placeholder="Put new mission statement here..." style="width: 50%; margin-bottom: 15px;"></textarea>
					<table class="buttontable">
						<tr>
							<td><button type="submit" name="submit" class="buttons">Submit</button></td>
							<td><button type="reset" name="reset" class="buttons">Reset</button></td>
						</tr>
					</table>	
				</form>

		<?php }	?>



		<!-- OLD MISSION EDIT SECTION -->

		<?php if (isset($_SESSION['is_admin']) && isset($_SESSION['new_user']) == NULL) { ?>
			<div id="oldmissionSection">
				<h2 class="sub-header" id="missionEdits">Mission Statement Edits</h2>

				<?php while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) { ?>
					<div id="oldmissionedits" class="missionEdits">

						<p><?php echo $row['MISSEDIT_TEXT']; ?></p>

						<div id="missionEditInfo">
							<p>
								<?php 
								$phpdate = strtotime( $row['MISSEDIT_EDITDATE'] );
								$mysqldate = date( 'F d, Y', $phpdate ); 
								echo $mysqldate; ?> by 
								<a href="#"><?php echo $row['MEM_USERNAME']; ?></a>
							</p>
							<!-- <div id="missionEdits-buttonGroup">
								<table>
									<tr>
										<td><input type="button" value="Reply" name="reply" class="missionButtons"></td>
										<td><input type="button" value="Edit" name="edit" class="missionButtons"></td>
										<td><input type="button" value="Delete" name="deleteMission" class="missionButtons"></td>
									</tr>
								</table>
							</div> -->
						</div>

					</div>
					<hr>
				<?php } ?>

			</div>
		<?php }	?>

	</div>
	<?php include('includes/scripts.php'); ?>
</body>

<?php include('includes/footer.php'); ?>