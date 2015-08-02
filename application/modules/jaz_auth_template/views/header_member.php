<center>
<table width="1000" border="0">
	<tr>
		<td width="150" align="left">
		    	<a href="<?php echo base_url('jaz_auth_front'); ?>">
		    		<img name="icongear" src="<?php echo base_url('assets/icons/jazauth.png'); ?>" width="30" height="30" alt="" border="0">
				</a>
	    	<span class="style1">
				<b>Member Area</b>	   	
	    	</span>				
			
		</td>
		<td width="750" align="left">
	    	<span class="style1">
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
	    	</span>			
   			
		</td>
		<td width="100" align="left"><?php echo anchor('jaz_auth_front/logout', 'Logout', 'title="Logout"'); ?></td>
		
	</tr>
</table>
</center>