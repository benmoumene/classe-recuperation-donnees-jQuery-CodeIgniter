<?php echo form_open('jaz_auth_front/forgot_password'); ?>
<table>
	<tr>
		<td colspan="3"><center><b>Please enter your email address below.</b></center></td>
	</tr>
	<tr>
		<td><?php echo form_label('Email: ', 'email'); ?></td>
		<td><?php echo form_input('email', set_value('username')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('email'); ?></td>
	</tr>
</table>
<?php echo form_submit('submit', 'Send password info.'); ?>
<?php echo form_close(); ?>