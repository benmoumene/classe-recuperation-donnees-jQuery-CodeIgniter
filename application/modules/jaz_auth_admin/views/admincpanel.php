<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN""http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>AdminS9 - Admin Control Panel</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/general.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/admincpanel.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/accordion.css'); ?>" media="screen" />	
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('js/jquery.easing.1.3.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/accordion.js'); ?>"></script>
</head>

<body>
	<div id="header">
		<?php echo $cpanel_header; ?>
	</div>
	
	<div id="nav_left">
		<div id="main">
		  <ul class="container">
		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="blue">Settings <span></span></a></li>
		            <li class="dropdown">
		                <ul>
		                    <li><a href="#">Change logo</a></li>
		                    <li><a href="#">Menu add/edit</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>
		      
		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="blue">Manage Users <span></span></a></li>          	
		            <li class="dropdown">
		                <ul>
		                    <li><a href="<?php echo base_url('admin/admin/viewedit_user/'); ?>" target="iframe_a">View/Edit user</a></li>		                    
		                    <li><a href="<?php echo base_url('admin/admin/email_user/'); ?>" target="iframe_a">Email user/users</a></li>
		                    <li><a href="<?php echo base_url('admin/admin/password_reset/'); ?>" target="iframe_a">Password reset</a></li>
		                    <li><a href="<?php echo base_url('admin/admin/delete_user/'); ?>" target="iframe_a">Delete user account</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>
		      
		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="blue">Access Control <span></span></a></li>
		            <li class="dropdown">
		                <ul>
		                    <li><a href="<?php echo base_url('admin/admin/ban_user/'); ?>" target="iframe_a">Ban/Unban user</a></li>
		                    <li><a href="#">Permissions</a></li>
		                    <li><a href="#">Groups</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>
		      
		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="red">Extras<span></span></a></li>
		            <li class="dropdown">
		                <ul>
		                    <li><a href="<?php echo base_url('admin/admin/stats/'); ?>" target="iframe_a">Statistics</a></li>
		                    <li><a href="<?php echo base_url('admin/admin/history/'); ?>" target="iframe_a">History</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>
		      
		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="blue">CMS<span></span></a></li>
		            <li class="dropdown">
		                <ul>
		                    <li><a href="<?php echo base_url('admin/admin/stats/'); ?>" target="iframe_a">Manage pages Add/Edit/Delete</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>
		      
		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="blue">Shopping Cart<span></span></a></li>
		            <li class="dropdown">
		                <ul>
		                    <li><a href="<?php echo base_url('admin/admin/stats/'); ?>" target="iframe_a">Manage pages Add/Edit/Delete</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>

		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="blue">Forums<span></span></a></li>
		            <li class="dropdown">
		                <ul>
		                    <li><a href="<?php echo base_url('admin/admin/stats/'); ?>" target="iframe_a">Manage pages Add/Edit/Delete</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>
		      
		      <li class="menu">
		          <ul>
				    <li class="button"><a href="#" class="blue">Blog<span></span></a></li>
		            <li class="dropdown">
		                <ul>
		                    <li><a href="<?php echo base_url('admin/admin/stats/'); ?>" target="iframe_a">Manage pages Add/Edit/Delete</a></li>
		                </ul>
					</li>
		          </ul>
		      </li>
		      
		  </ul>
		</div>
	</div>
	
	<div id="center">
		<iframe src="" width="800" height="1199" bordercolor="0" name="iframe_a"></iframe>
	</div>
	
	<div id="footer">
		<center>Copyright 2012</center>
	</div>
</body>
</html>