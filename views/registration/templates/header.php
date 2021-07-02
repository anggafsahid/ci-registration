<!DOCTYPE html>
<html>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<link href="//fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
 	<link href="<?php echo base_url();?>public/theme/css/sb-admin-2.min.css" rel="stylesheet">
<head>
	<title>Hinban Registration</title>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<!-- Links -->
		<ul class="navbar-nav">
			<a class="navbar-brand" href="<?php echo base_url();?>">
        <img src="<?php echo base_url();?>public/theme/img/logo.png" width="50" height="30" class="d-inline-block align-top" alt="" style="margin-right: 15px">
        <p1>Meiwa Industry</p1>
      </a>
    </ul>
  	</nav>
</head>
<?php 
	$timestamp=time();
?>
<input type="hidden" name="time" id="timestamp" value="<?php echo $timestamp;?>">
