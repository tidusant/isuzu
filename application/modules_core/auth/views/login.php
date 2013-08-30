<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?php echo 'Padmin CMS - Login'; ?></title>
<meta name="robots" content="noindex, nofollow" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link rel="shortcut icon" href="<?php echo base_url()?>assets/admin/img/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo base_url()?>assets/admin/img/apple-touch-icon.png" />
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url()?>assets/admin/img/apple-touch-icon-57x57-precomposed.png" />
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url()?>assets/admin/img/apple-touch-icon-72x72-precomposed.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url()?>assets/admin/img/apple-touch-icon-114x114-precomposed.png" />
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>assets/admin/img/apple-touch-icon-precomposed.png" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/admin/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/admin/css/plugins.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/admin/css/main.css" />
<script src="<?php echo base_url()?>assets/admin/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body class="login">
<div id="login-container">
<div id="login-logo">
<a href="#">
<img src="<?php echo base_url()?>assets/admin/img/template/uadmin_logo.png" alt="Admin Logo" />
</a>
</div>
<!--div id="login-buttons">
<h5 class="page-header-sub">Login with..</h5>
<button id="login-btn-facebook" class="btn btn-primary"><i class="icon-facebook"></i> Facebook</button>
<button id="login-btn-twitter" class="btn btn-info"><i class="icon-twitter"></i> Twitter</button>
<button id="login-btn-email" class="btn">or Email <i class="icon-envelope"></i></button>
</div-->

<div><?php $this->load->view('administration/system_messages'); ?></div>
 
<form id="login-form" action="<?php echo site_url($this->uri->uri_string()); ?>" method="post" class="form-inline" />
<!--div class="control-group">
<a href="#" class="login-back"><i class="icon-arrow-left"></i></a>
</div-->
<div class="control-group">
<div class="input-append">
<input type="text" value="" id="login-email" placeholder="Email.." name="useremail" />
<span class="add-on"><i class="icon-envelope-alt"></i></span>
</div>
</div>
<div class="control-group">
<div class="input-append">
<input type="password" id="login-password" placeholder="Password.." value="" name="userpassword" />
<span class="add-on"><i class="icon-asterisk"></i></span>
</div>
</div>

<div class="control-group remove-margin clearfix">
<div class="btn-group pull-right">
<button id="login-button-pass" class="btn btn-small btn-warning" data-toggle="tooltip" title="Forgot pass?"><i class="icon-lock"></i></button>
<button class="btn btn-small btn-success"><i class="icon-arrow-right"></i> Login</button>
</div>
<div class="input-switch switch-small pull-left" data-toggle="tooltip" title="Remember me" data-on="success" data-off="danger" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>">
<input type="checkbox" />
</div>
</div>
</form>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/vendor/jquery-1.8.3.min.js"%3E%3C/script%3E'));</script>
<script src="<?php echo base_url()?>assets/admin/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/js/plugins.js"></script>
<script src="<?php echo base_url()?>assets/admin/js/main.js"></script>
<script>
/*$(function () {var loginButtons = $('#login-buttons');var loginForm = $('#login-form');$('#login-btn-email').click(function(){loginButtons.slideUp(600);loginForm.slideDown(450);});$('.login-back').click(function(){loginForm.slideUp(450);loginButtons.slideDown(600);});$('#login-button-pass').click(function(){return false;});}) */;
</script>
</body>
</html>