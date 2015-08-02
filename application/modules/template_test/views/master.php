<html>
	<head>
		
	</head>
	
	<body>
		
		<table width="50%" border="1">

			<tr>
				<td>
					<div id='header'>
						<?php $this->load->view($module. '/' . 'header'); ?>
					</div>					
				</td>
			</tr>
			<tr>
				<td>
					
				</td>
			</tr>
			<tr>
				<td>
					<div id="mid_content">
						<?php echo $mid_content; ?>
					</div>					
				</td>
			</tr>
			<tr>
				<td>
					
				</td>
			</tr>
			<tr>
				<td>
					<div id="footer">
						<?php $this->load->view($module. '/' . 'footer'); ?>
					</div>					
				</td>
			</tr>												
		</table>

	</body>
</html>