<!DOCTYPE html>
<html lang="en">

<head>
	<title>NONESCOST Biology Learning App</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" media="all">
	<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="../css/popup-box.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">
	<link rel="icon" href="../images/logo.png">
	<link rel="stylesheet" href="../css/font-awesome.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Arapey:400,400i">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300i,400,400i,600,600i,700">
</head>

<body>
	<div id="start">
		<div id="particles-js"></div>
		<div class="starting-table-main">
			<h3 class="title-w3 three">NONESCOST Biology Students Learning App</h3>
			<p class="sub-text fs-4">A gamified application for Biology Students</p>
			<div class="starting-table-grids">
				<form action="teacher-login-check.php" method="post" class="start_form slideanim">
					<div class="form">
						<div class="col-lg-6 col-md-6 col-sm-12 grid_6 c1">
							<img src="../images/logo.png" alt="NONESCOST LOGO">
							<input type="text" name="username" placeholder="Username" class="fs-4" required>
							<input type="password" name="password" placeholder="Password" class="fs-4" required>
							<button type="submit" class="btn-custom mt-4 w-50">Login</button>
							<div class="d-flex justify-content-start mt-5">
								<a href="../index.php" class="text-white fs-4">
									<i class="fa fa-arrow-left"></i>
									&nbsp; Back to main
								</a>
							</div>
							<?php
							if (isset($_GET['invalid'])) {
							?>
								<p class="d-flex align-items-center justify-content-between bg-danger text-white rounded-5 fs-3 p-3 mt-5">
									<span></span>
									<?php echo $_GET['invalid'], "Invalid username or password."; ?>
									<a href="teacher-login.php">
										<button type="button" class="btn-close text-white fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
									</a>
								</p>
								
							<?php
							}
							?>
						</div>
<<<<<<< HEAD
						<div class="col-lg-6 col-md-6 col-sm-12 grid_6 c1">
							<div class="starter-block agile">
								<div class="starter-gd-top">
									<h3>Teacher</h3>
								</div>
								<div class="starter-gd-bottom">
									<div class="starter-list fs-3">
										<h6 class="bed"><i class="fa fa-user-md" aria-hidden="true"></i></h6>
									</div>
									<div class="starter-selet">
										<a class="fs-4" href="teacher-signup.php">
											<button class="btn-custom w-50" type="button">Signup</button>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="../js/jquery-2.2.3.min.js"></script>
	<script src="../js/particles.js"></script>
	<script src="../js/app.js"></script>
</body>

</html>
