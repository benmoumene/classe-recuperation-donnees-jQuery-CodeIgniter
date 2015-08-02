<h2>Email user:</h2>
<br><br>
<?php echo form_open('jaz_auth_admin/email_user_process'); ?>
<table width="100%" border="0">
	<tr>
		<td colspan="3"><b>Please enter the username.</b></td>
	</tr>
	<tr>
		<td><?php echo form_label('Username: ', 'username'); ?></td>
		<td><?php echo form_input('username', set_value('username')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('username'); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('All Users: ', 'chkbox'); ?></td>
		<td>
			<?php
				$data = array(
				    'name'        => 'chkbox',
				    'id'          => 'chkbox',
				    'value'       => 'chkd',
				    'checked'     => FALSE,
				    );
				
				echo form_checkbox($data);
			?>
			<?php echo ' ' . form_error('chkbox'); echo ' Check box will send message to all members'; ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td><?php echo form_label('Message: ', 'msg'); ?></td>
		<td>
			<?php
				$data = array(
				              'name'        => 'msg',
				              'id'          => 'msg',
				              'value'       => set_value('msg'),
				              'rows'   		=> '10',
				              'cols'        => '40',
				            );
			 
				echo form_textarea($data); 
			?>
		</td>
		<td style="color: red;"><?php echo ' ' . form_error('msg'); ?></td>
	</tr>
</table>
<?php echo form_submit('submit', 'Send Message'); ?>
<?php echo form_close(); ?>

