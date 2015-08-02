<?php echo form_open('jaz_auth_front/login'); ?>
<center>
<table width="1000" border="1">
	  <tr>
	    <td width="130" rowspan="3" align="left"><div align="center">
	    	<a href="<?php echo base_url('jaz_auth_front'); ?>">
	    		<img name="icongear" src="<?php echo base_url('assets/icons/jazauth.png'); ?>" width="128" height="128" alt="" border="0">
			</a>
	    </div></td>
	    <td width="533" align="left"><span class="style1">
	    	<?php
	    		if(isset($username))
	    		{
					echo $username;
				}
				else 
				{
					//just do nothing			
				}
			?>	    	
	    </span></td>
	    <td width="150" align="left"><input name='username' id='username' value='username' type="text"></td>
	    <td width="150" align="left"><input name='password' id='password' value='password' type="password"></td>
	    <td width="115"  align="left"><div align="left">
	      <?php echo form_submit('login', 'Login'); ?>
	    </div></td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td  align="left"><?php echo anchor('jaz_auth_front/register_form', 'Register', 'title="Register"'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	    <td  align="left"><?php echo anchor('jaz_auth_front/forgot_password_form', 'Forgot?', 'title="Forgot password?"'); ?> </td>
	    <td  align="left"><?php echo form_checkbox('remember', 'accept', FALSE); ?><span class="style1">remember</span></td>
	  </tr>
	  <tr>
	    <td align="left">
	    	<span class="style1">
	   	
	    	</span>
	    </td>
	  </tr>
</table>
</center>
<?php echo form_close(); ?>
<br><br>