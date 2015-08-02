<?php 
	echo form_open('jaz_auth_front/process_register_form'); 
?>
<table width="600" border="0">
	<tr>
		<td align="left" colspan="3"><h3>Register</h3></td>
	</tr>
	<tr>
		<td align="left">Username</td>
		<td align="left"><?php echo form_input('username', set_value('username')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('username'); ?></td>
	</tr>
	<tr>
		<td align="left">Email address</td>
		<td align="left"><?php echo form_input('email', set_value('email')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('email'); ?></td>
	</tr>
	<tr>
		<td align="left">Password</td>
		<td align="left"><?php echo form_password('password', set_value('password')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('password'); ?></td>
	</tr>
	<tr>
		<td align="left">Confirm Password</td>
		<td align="left"><?php echo form_password('confirm_pass', set_value('confirm_pass')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('confirm_pass'); ?></td>
	</tr>
	
	<tr>
		<td align="left">First name</td>
		<td align="left"><?php echo form_input('first_name', set_value('first_name')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('first_name'); ?></td>
	</tr>
	<tr>
		<td align="left">Last name</td>
		<td align="left"><?php echo form_input('last_name', set_value('last_name')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('last_name'); ?></td>
	</tr>
	<tr>
		<td align="left">Company name</td>
		<td align="left"><?php echo form_input('company', set_value('company')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('company'); ?></td>
	</tr>
	<tr>
		<td align="left">Contact number</td>
		<td align="left"><?php echo form_input('contact_number', set_value('contact_number')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('contact_number'); ?></td>
	</tr>
	<tr>
		<td align="left">Country</td>
		<td align="left"><?php echo form_input('country', set_value('country')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('country'); ?></td>
	</tr>
	<tr>
		<td align="left">Website</td>
		<td align="left"><?php echo form_input('website', set_value('website')); ?></td>
		<td align="left" style="color: red;"><?php echo ' ' . form_error('website'); ?></td>
	</tr>
	<tr>
		<td align="left" colspan="3">
<?php 
	echo form_submit('register', 'Register');
	echo form_close(); 
?>
		</td>
	</tr>
</table>

