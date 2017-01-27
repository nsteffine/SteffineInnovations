<?php 

$page_name = "Projects";
$page_id = "projects";

include('includes/session_start.php');
include('includes/header.php');
include('includes/dbconn.php');

?>

<body class="wrapper">
	<div class="container">

		<div class="jumbotron"">

			<h1 class="sub-header">Projects</h1>			

			<p>Here at Steffine Innovations we encourage you to submit an idea and watch it come to life!</p>
				<a class="btn btn-primary btn-sm" href="">Add a Project</a>
			  <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p> -->		
					
		</div>
		
	</div>
</body>

<?php include('includes/footer.php'); ?>