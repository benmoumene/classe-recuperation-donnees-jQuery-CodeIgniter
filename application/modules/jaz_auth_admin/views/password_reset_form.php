<h2>Password reset:</h2>
<br><br>
<?php echo form_open('jaz_auth_admin/password_reset_process'); ?>
<table>
	<tr>
		<td colspan="3"><b>Please enter the username and the new password below.</b></td>
	</tr>
	<tr>
		<td><?php echo form_label('Username: ', 'username'); ?></td>
		<td><?php echo form_input('username', set_value('username')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('username'); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('New Password: ', 'password'); ?></td>
		<td><?php echo form_input('password', set_value('password')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('password'); ?></td>
	</tr>
</table>
<?php echo form_submit('submit', 'Reset password.'); ?>
<?php echo form_close(); ?>