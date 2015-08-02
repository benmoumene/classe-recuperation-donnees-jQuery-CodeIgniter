<!doctype html>
<html class="no-js" lang="">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">		
		<title><?php echo $title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">		

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="<?php echo base_url('assets/css/normalize.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
        <script src="<?php echo base_url('assets/js/vendor/modernizr-2.8.3.min.js'); ?>"></script>

		<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/adminpanel.css'); ?>"/>
  		<link rel="stylesheet" href="<?php echo base_url('assets/css/accordion.css'); ?>">
	</head>

<body>
	<div id="body-wrapper">
		<div id="header">
			<center>Admin Control Panel</center>
		</div>
		
		<div id="left-nav">
			<div id='cssmenu'>
			<ul>
			   <li class='has-sub'><a href='#'><span>General</span></a>
			      <ul>
			         <li><a href="<?php echo base_url('jaz_auth_admin/stats/'); ?>"><span>Stats</span></a></li>
			         <li class='last'><a href="<?php echo base_url('jaz_auth_admin/history/'); ?>"><span>History</span></a></li>
			      </ul>			   	
			   </li>			   
			   <li class='has-sub'><a href='#'><span>Settings</span></a>
			      <ul>
				     <li><a href='<?php echo base_url('jaz_auth_admin/self_check/'); ?>'><span>Self Check</span></a></li>
			         <li class='last'><a href='#'><span>Reserved</span></a></li>
			      </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>Manage User</span></a>
			      <ul>
			         <li><a href="<?php echo base_url('jaz_auth_admin/list_all_users/'); ?>"><span>List All Users</span></a></li>			      	
			         <li><a href="<?php echo base_url('jaz_auth_admin/email_user/'); ?>"><span>Email User</span></a></li>			      	
			         <li><a href="<?php echo base_url('jaz_auth_admin/ban_user/'); ?>"><span>Ban User</span></a></li>			      	
			         <li><a href="<?php echo base_url('jaz_auth_admin/delete_user/'); ?>"><span>Delete User</span></a></li>
			         <li class='last'><a href="<?php echo base_url('jaz_auth_admin/password_reset/'); ?>"><span>Reset User password</span></a></li>
			      </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>Spyder</span></a>
			      <ul>
				     <li><a href="<?php echo base_url('jaz_auth_admin/crawl_email/'); ?>"><span>Crawl Emails</span></a></li>
				     <li><a href='#'><span>List Valid Emails</span></a></li>
				     <li><a href='#'><span>List Invalid Emails</span></a></li>				     				     
				     <li><a href='#'><span>List Live Sites</span></a></li>	
				     <li><a href='#'><span>List Dead Sites</span></a></li>				     
				     <li><a href='#'><span>Send Message</span></a></li>				     			     				     
			         <li class='last'><a href='#'><span>Reserved</span></a></li>
			      </ul>
			   </li>			   
			   <li class='last'><a href="<?php echo base_url('jaz_auth_admin/logout/'); ?>"><span>Logout</span></a></li>
			</ul>
			</div>	
		
		</div>
		
		<div id="right-content">
					<?php 
						if(isset($mid_sec))
						{
							echo '<br>';
							echo '<div align="center">'; 
							echo $mid_sec;
							echo '</div>';
						}
						else
						{
							//do nothing
						}
					?>		
		</div>

			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
		<div id="footer">
			<center>Copyright 2015</center>
		</div>
		
	</div>
	
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url('assets/js/vendor/jquery-1.11.3.min.js'); ?>"><\/script>')</script>
    <script src="<?php echo base_url('assets/js/plugins.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/accordion.js'); ?>"></script>
        	
</body>
</html>