<br>
<b>Please enter your desire new password below,</b>
<?php echo form_open('front/process_reset_password'); ?>
<table>
	<tr>
		<td align="left"><?php echo form_label('Username: ', ''); echo $username; ?></td>
		<td><?php echo form_hidden('username', $username); ?></td>
		<td style="color: red;"></td>
	</tr>
	<tr>
		<td align="left"><?php echo form_label('New Password: ', 'newpass'); ?></td>
		<td><?php  echo form_input('newpass', set_value('newpass')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('newpass'); ?></td>
	</tr>
</table>
	

<?php 
	echo form_submit('change', 'Change Password');
	echo form_close(); 
?>