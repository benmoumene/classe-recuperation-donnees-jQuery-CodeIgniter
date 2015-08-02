<h2>View or Edit user:</h2>
<br>
<br>
<?php echo form_open('jaz_auth_admin/viewedit_user_process'); ?>
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
<?php echo form_submit('ban', 'View'); ?>
<?php echo form_submit('unban', 'Edit'); ?>
<?php echo form_close(); ?>
