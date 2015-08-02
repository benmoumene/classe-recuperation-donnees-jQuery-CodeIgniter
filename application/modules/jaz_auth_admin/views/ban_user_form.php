<h2>Ban User:</h2>
<br>
<br>
<?php echo form_open('jaz_auth_admin/ban_user_process'); ?>
<table>
	<tr>
		<td colspan="3"><b>Please enter the username.</b></td>
	</tr>
	<tr>
		<td><?php echo form_label('Username: ', 'username'); ?></td>
		<td><?php echo form_input('username', set_value('username')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('username'); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Reason: ', 'reason'); ?></td>
		<td>
			<?php
				$data = array(
				              'name'        => 'reason',
				              'id'          => 'reason',
				              'value'       => set_value('reason'),
				              'rows'   		=> '10',
				              'cols'        => '40',
				            );
			 
				echo form_textarea($data); 
			?>
		</td>
		<td style="color: red;"><?php echo ' ' . form_error('reason'); ?></td>
	</tr>
</table>
<?php echo form_submit('ban', 'Ban'); ?>
<?php echo form_submit('unban', 'UnBan'); ?>
<?php echo form_close(); ?>

<br><br>
<h2>List of Banned members:</h2>