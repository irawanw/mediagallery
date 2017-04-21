<? 
	include("includes/connections.php"); 	
	include("includes/classes/customer.class.php"); 
	include("includes/classes/transaction.class.php"); 
	include("includes/classes/admin.class.php"); 
	include("includes/classes/payment.class.php");
	include("includes/classes/phpmailer.class.php");
	include("includes/classes/smtp.class.php");
	include("includes/classes/mobile_detect.class.php");
	include("includes/functions.php"); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Skydive Chicago</title>
    
	<!-- Bootstrap -->
    <link href="<?=WEBROOT;?>/assets/css/bootstrap.css" rel="stylesheet">
	<link href="<?=WEBROOT;?>/assets/css/bootstrap-theme.css" rel="stylesheet">
	<link href="<?=WEBROOT;?>/assets/css/style.css" rel="stylesheet">
	
    <!-- Bootstrap core CSS -->
    <!--<link href="<?=WEBROOT;?>/css/bootstrap.min.css" rel="stylesheet">	
	<link href="<?=WEBROOT;?>/css/style.css" rel="stylesheet">-->
	<link href="<?=WEBROOT;?>/css/jquery-ui.css" rel="stylesheet">
	<link href="<?=WEBROOT;?>/css/jquery.validate.css" rel="stylesheet">
	<link href="<?=WEBROOT;?>/css/jquery.dataTables.css" rel="stylesheet">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- Custom styles for this template -->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?=WEBROOT;?>/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

	<?
		//if front page use different classes
		if(	preg_match('/index.php/', $_SERVER['REQUEST_URI']) || 
			!preg_match('/.php/', $_SERVER['REQUEST_URI']) )
			$class = '-index';
		else
			$class = '';
	?>
  <body>
  <div id="wrapper">
  	<div id="header<?=$class;?>">
		<div class="container">
			<div class="row">				