<?php
	echo form_open('jaz/process_login');
?>
	<table colspan="3" border="0" width="450">
		<tr>
			<td colspan="3"><h3>Login</h3></td>
		</tr>
		<tr>
			<td align="left">Username:</td>
			<td align="left"><?php echo form_input('username', set_value('username')); ?></td>
			<td align="left" style="color: red;"><?php echo ' ' . form_error('username'); ?></td>
		</tr>
		<tr>
			<td align="left">Password:</td>
			<td align="left"><?php echo form_password('password', set_value('password')); ?></td>
			<td align="left" style="color: red;"><?php echo ' ' . form_error('password'); ?></td>
		</tr>
		<tr>
			<td colspan="3">
<?php
	echo form_submit('submit', 'Login');
	echo form_close();				
?>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="left">
				<?php
					echo anchor('jaz/register_form', 'Register', 'title="register"');
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo form_checkbox('remember', 'selected', FALSE);
					echo '&nbsp;';
					echo 'remember me';
				?>
			</td>
		</tr>
	</table>

