<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>Content Management System</title>

<meta name="author" content="Phuc tuc" />
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

<?php if(isset($header_extended_css)) echo $header_extended_css;?>
<script src="<?php echo base_url()?>assets/admin/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
</head>
<body>

<div id="page-container">
<header class="navbar navbar-inverse">
<div class="navbar-inner remove-radius remove-box-shadow">
<div class="container-fluid">
<ul class="nav pull-right visible-phone visible-tablet">
<li class="divider-vertical remove-margin"></li>
<li>
<a href="javascript:void(0)" data-toggle="collapse" data-target=".nav-collapse">
<i class="icon-reorder"></i>
</a>
</li>
</ul>
<a href="<?php echo base_url()?>" class="brand"><img src="<?php echo base_url()?>assets/admin/img/template/logo.png" alt="logo" /></a>
<div id="loading" class="hide pull-left"><i class="icon-certificate icon-spin"></i></div>

<?php //echo modules::run('administration/_render_topline');?>

</div>
</div>
</header>

<!--  begin inner container -->
<div id="inner-container">
	
	<!-- left column -->
	<aside id="page-sidebar" class="nav-collapse collapse">
	<!-- form search -->
	<form id="sidebar-search" method="post" onsubmit="return false;" />
	<div class="input-append">
	<input type="text" placeholder="Search.." class="remove-box-shadow remove-transition remove-radius" />
	<button><i class="icon-search"></i></button>
	</div>
	</form>
	<!-- / form search -->
	<nav id="primary-nav">
	<ul>
	<?php echo modules::run('administration/_render_menu');
	if($this->session->userdata('member_id') != ''):?>
	<li>
	<a href="<?php echo site_url($this->uri->segment(1).'/logout');?>"><i class="icon-off"></i><?php echo $this->lang->line('logout_menu');?></a>
	</li>
	<?php else:?>
	<li>
	<a href="<?php echo site_url($this->uri->segment(1).'/login');?>"><i class="icon-off"></i><?php echo $this->lang->line('login_menu');?></a>
	</li>
	<?php endif;?>
	</ul>
	</nav>
	</aside>
	
	<!-- main content -->
	<div id="page-content">
		<?php if($content_render!=NULL) echo $content_render;?>
	</div>
	<!-- / main content -->
<footer>
<script>var d = new Date(); if (d.getFullYear() === 2013) { document.write(d.getFullYear()); } else { document.write(d.getFullYear()+'-' + d.getFullYear()); }</script> &copy; <strong>PAdmin</strong> - by <strong><a href="http://itksolution.com" target="_blank">ITK</a></strong>
</footer>
</div><!-- inner container -->

</div>
<a href="#" id="to-top"><i class="icon-chevron-up"></i></a>

<?php //echo modules::run('sysusers/gotthat/musers/_render_modal_profile');?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/vendor/jquery-1.8.3.min.js"%3E%3C/script%3E'));</script>
<script src="<?php echo base_url();?>assets/admin/js/vendor/bootstrap.min.js"></script>



<script src="<?php echo base_url();?>assets/admin/js/plugins.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/main.js"></script>
<?php
if(isset($extended_js)) echo $extended_js; 
if(isset($tinymce_init)) echo $tinymce_init;
?>

<script type="text/javascript">
$(function(){$("#language-tabs a, #directory-tabs a").click(function(e){e.preventDefault();$(this).tab("show")});

var oListDataTable = $('#list-datatables').dataTable({
	"bJQueryUI" : true,
	"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 2,3,5 ] } ] 
});

});
</script>


</body>
</html>