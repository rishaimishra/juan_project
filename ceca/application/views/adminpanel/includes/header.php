<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title><?php echo $title;?> || Bidinline</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>adminassets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>adminassets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>adminassets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>adminassets/css/feathericon.min.css">

        <!-- Datatables CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>adminassets/plugins/datatables/datatables.min.css">
		
		<link rel="stylesheet" href="<?php echo base_url();?>adminassets/plugins/morris/morris.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>adminassets/css/style.css">
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            <div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="<?php echo base_url();?>AdminPanel" class="logo">
						<img src="<?php echo base_url();?>adminassets/img/logo.png" alt="Logo">
					</a>
					<a href="<?php echo base_url();?>AdminPanel" class="logo logo-small">
						<img src="<?php echo base_url();?>adminassets/img/logo-small.png" alt="Logo" width="30" height="30">
					</a>
                </div>
				<!-- /Logo -->
				
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>
				
				<div class="top-nav-search">
					<form>
						<input type="text" class="form-control" placeholder="Search here">
						<button class="btn" type="submit"><i class="fa fa-search"></i></button>
					</form>
				</div>
				
				<!-- Mobile Menu Toggle -->
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				<!-- /Mobile Menu Toggle -->
				
				<!-- Header Right Menu -->
				<ul class="nav user-menu">

					<!-- Notifications -->
					<!-- <li class="nav-item dropdown noti-dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>
						</a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/doctors/doctor-thumb-01.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span> Schedule <span class="noti-title">her appointment</span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="#">View all Notifications</a>
							</div>
						</div>
					</li> -->
					<!-- /Notifications -->
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img class="rounded-circle" src="<?php echo base_url();?>adminassets/img/profiles/avatar-01.jpg" width="31" alt="Ryan Taylor"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="<?php echo base_url();?>adminassets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6><?php echo $_SESSION['admin_data']['nombre'];?></h6>
									<p class="text-muted mb-0">
										Admin Account</p>
								</div>
							</div>
							<a class="dropdown-item" href="<?php echo base_url();?>admin/Dashboard/logout">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Right Menu -->
				
            </div>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							
							<li> 
								<a href="<?php echo base_url();?>admin/Dashboard/transactions"><i class="fe fe-document"></i> <span>All Transactions</span></a>
							</li>

							<li class="menu-title"> 
								<span>Account</span>
							</li>

							<li class="submenu">
								<a href="#"><i class="fe fe-vector"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="<?php echo base_url();?>admin/Dashboard/logout">Log Out</a></li>
								</ul>
							</li>

							


						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->
			
			<style type="text/css">
				a{
					cursor: pointer;
				}
				.card {
    border: 1px solid #f0f0f0;
    margin-bottom: 1.875rem;
    box-shadow: 1px 1px 80px 0 rgb(142 148 150 / 19%);
    border-radius: 10px;
    /* color: black; */
}
.card .text-muted {
    color: #000000 !important;
    text-transform: capitalize;
    font-weight: 500;
}
body {
    background-color: #f4f9ff;
}
.sidebar {
    background-color: #007bff;
}
.sidebar-menu li.active a {
    background-color: #f63;
    color: #fff;
}
.sidebar-menu > ul > li > a:hover {
    background-color: #f63;
    color: #fff;
}

.header .header-left .logo img {
    max-height: 64px;
    width: auto;
}
			</style>