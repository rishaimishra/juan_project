<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin Login || Bidinline</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>adminassets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminassets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminassets/css/font-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminassets/css/style.css">
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	<div class="login-left">
							<img class="img-fluid" src="adminassets/img/logo-white.png" alt="Logo">
                        </div>
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Login</h1>
								<p class="account-subtitle">Access to Bidinline dashboard</p>
								
								<!-- Form -->
								<form action="<?php echo base_url(); ?>AdminLogin/verifyUser" method="post">
									<div class="form-group">
										<input class="form-control" type="email" placeholder="Email" name="email" autocomplete="off">
									</div>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Password" name="password" autocomplete="off">
									</div>
									<div class="form-group">
										<button class="btn btn-primary btn-block" type="submit">Login</button>
									</div>
								</form>

								<?php

							      if($this->session->flashdata('error')){  ?>
								        <div class="row">

								          <div class="col-sm-12" align="center" style="color:red;">

								            <?php echo $this->session->flashdata('error'); ?>

								          </div>

								        </div>    

							    <?php } ?>

    
								<!-- /Form -->
								
								<!-- <div class="text-center forgotpass"><a href="#">Forgot Password?</a></div>

								
								<div class="text-center dont-have">Don’t have an account? <a href="register.html">Register</a></div> -->
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="<?php echo base_url(); ?>adminassets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo base_url(); ?>adminassets/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>adminassets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo base_url(); ?>adminassets/js/script.js"></script>
		
    </body>
</html>