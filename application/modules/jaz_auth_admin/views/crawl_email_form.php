<br>
	<center>
		<img src="<?php echo base_url('assets/images/spider.jpg'); ?>" alt="Spyder">		
	</center>
<br>
	<center>
		<b>Ver. 1.0</b>
	</center>
<br><br>
<?php echo form_open('jaz_auth_admin/crawl_email_process'); ?>
<table>
	<tr>
		<td colspan="3"><b>Enter the URL.</b></td>
	</tr>
	<tr>
		<td><?php echo form_label('URL: ', 'username'); ?></td>
		<td><?php echo form_input('url', set_value('url')); ?></td>
		<td style="color: red;"><?php echo ' ' . form_error('url'); ?></td>
	</tr>
</table>
<?php echo form_submit('submit', 'Crawl'); ?>
<?php echo form_close(); ?>