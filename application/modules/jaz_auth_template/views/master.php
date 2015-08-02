<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">		
	<title><?php echo $title; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">		

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="<?php echo base_url('assets/css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <script src="<?php echo base_url('assets/js/vendor/modernizr-2.8.3.min.js'); ?>"></script>


		
</head>
	
<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->		
	
	<div align="center">
	<table width="50%" border="1">

		<tr>
			<td>
				<div id='header'>
					<?php echo $header; ?>
				</div>					
			</td>
		</tr>
		<tr>
			<td>
				<div id="msg">
		 			<?php
			    		if(isset($message))
			    		{
							echo $message;
						}
						else 
						{
							//just do nothing			
						}
					?>	 					</div>
			</td>
		</tr>
		<tr>
			<td>
				
			</td>
		</tr>
		<tr>
			<td>
				<div id="mid_content">
					<?php 
						if(isset($mid_sec))
						{
							echo '<br>';
							echo '<div align="center">'; 
							echo $mid_sec;
							echo '</div>';
						}
						else
						{
							//do nothing
						}
					?>
					
					<center><h1>Header1</h1></center>
					<center><h2>Header2</h2></center>
					<center><h3>Header3</h3></center>
					<center><h4>Header4</h4></center>
					<center><h5>Header5</h5></center>
					<center><h6>Header6</h6></center>
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
	</div>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url('js/vendor/jquery-1.11.3.min.js'); ?>"><\/script>')</script>
    <script src="<?php echo base_url('js/plugins.js'); ?>"></script>
    <script src="<?php echo base_url('js/main.js'); ?>"></script>		
	
</body>
</html>