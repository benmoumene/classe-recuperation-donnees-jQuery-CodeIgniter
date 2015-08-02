<h2>Delete user account:</h2>
<br>
<table>
	<tr>
		<td colspan="3" style="color: red;"><h2>Warning: Deleting a user account is irreversible.</h2></td>
	</tr>
</table>
<br>
<?php echo form_open('jaz_auth_admin/delete_user_process'); ?>
<table>
	<tr>
		<td colspan="3"><b>Please enter the username.</b></td>
	</tr>
	<tr>
		<td><?php echo form_label('Username: ', 'username'); ?></td>
		<td><?php echo form_input('username', set_value('username')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('username'); ?></td>
	</tr>
</table>
<?php echo form_submit('submit', 'Delete account.'); ?>
<?php echo form_close(); ?>