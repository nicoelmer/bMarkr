<?php
include('header.php');
include_once("db_connect.php");
?>
<title>bMarkr - Simple Bookmarking</title>
<script type="text/javascript" src="script/validation.min.js"></script>
<script type="text/javascript" src="script/login.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">

<?php include('container.php');?>
<div class="container">	
	<form class="form-login" method="post" id="login-form" style="margin-top: 40px">
		<h2 class="form-login-heading" style="color: #000000; text-align: center; font-family: 'Libre Baskerville', serif;">bMarkr Login</h2><hr />
		<div style="text-align: center; font-size: 10px; font-style: italic; font-family: 'Libre Baskerville', serif;"><p>&laquo;simplicity is genius&raquo;</p></div>
		<div id="error">
		</div>
		<div class="form-group">
			<input type="user" class="form-control" placeholder="Email Address" name="user_email" id="user_email" style="height: 30px;" />
			<span id="check-e"></span>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Password" name="password" id="password" style="height: 30px;" />
		</div>
		<hr />
		<div class="form-group" style="text-align: center;">
			<button type="submit" class="btn btn-default" name="login_button" id="login_button" style="">
			<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
			</button> 

		</div> 
	</form>		
	<div style="margin:50px 0px 0px 0px;">
		<!-- <a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.phpzag.com/ajax-login-script-with-php-and-jquery" title="">Back to Tutorial</a>	-->		
	</div>		
</div><?php //include('footer.php');?>