<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>AdminS9 - Admin password page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/adminpassword.css'); ?>" media="screen" />
	
	
</head>

<body>
	<div id="header">
		<center><?php echo $password_header; ?></center>
	</div>

	<div id="center">
		<div id="error_msg">
			<center><b><?php echo $message; ?></b></center>
		</div>		
		
		<div id="adminpassform">
			<?php echo form_open('jaz_auth_admin/login'); ?>
			<table width="600" border="0">
			  <tr>
			    <td colspan="4"><div align="center"><strong>Admin Login </strong></div></td>
			  </tr>
			  <tr>
			    <td rowspan="2" width="100"><div align="center"><img name="iconlock" src="<?php echo base_url('assets/icons/icon-adminlock.png'); ?>" width="60" height="60" alt=""></div></td>
			    <td width="80"><div align="left"><strong>username</strong></div></td>
			    <td width="100"><div align="left">
					<?php echo form_input('username', set_value('username')); ?>
			    </div></td>
				<td style="color: red;" width="320"><?php echo ' ' . form_error('username'); ?></td>
			  </tr>
			  <tr>
			    <td><div align="left"><strong>password</strong></div></td>
			    <td><div align="left">
					<?php echo form_password('password', set_value('password')); ?>
			    </div></td>
				<td style="color: red;"><?php echo ' ' . form_error('password'); ?></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><div align="center">
			          <input type="submit" name="submit" value="Login">
			    </div></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			  </tr>
			</table>
			<?php form_close(); ?>		
		</div>
	</div>
	
	<div id="">

	</div>
</body>
</html>