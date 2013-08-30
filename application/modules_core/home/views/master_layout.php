<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $web_title;?></title>

<link href="<?php echo base_url()?>assets/style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/style/nivo-slider.css" type="text/css" media="screen" />

<?php if(isset($lightbox_script['css']) && $lightbox_script['css']!='') echo $lightbox_script['css'];?>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-1.8.2.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/js/detectmobilebrowser.js" type="text/javascript"></script>

<?php if($this->uri->segment(1)=='') {?>
<!-- bx slider -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/style/jquery.bxslider.css" type="text/css" media="screen" />
<script src="<?php echo base_url()?>assets/js/jquery.bxslider.min.js"></script>
<?php }?>

<?php if($this->uri->segment(1)=='dai-ly') {?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/tytabs.jquery.min.js"></script>
<?php }?>

<script type="text/javascript">
$(document).ready(function() {
	var curActive = $("ul#main_nav li a.active");//home
	var templi;
	var nav_timer=false;
	if($.browser.mobile)
	{
		$("ul#main_nav li").each(function(idx, elem)
		{
			if($("span", elem).length > 0)
			{
				$($("a", elem).get(0)).attr("href", "#");
			}
		});		
	}
	$("ul#main_nav li").hover(function(elem) { //Hover over event on list item
		
		curActive.removeClass("active");
		$(this).addClass('active');//product
		
		$(this).css({ 'background' : '#ef0000'}); //Add background color + image on hovered list item
		$(this).find("span").show(); //Show the subnav	
	} , function() { //on hover out...
			templi = $(this);
		
			$("ul#main_nav li a").removeClass("active");
			curActive.addClass('active');

			templi.css({ 'background' : 'none'}); //Ditch the background
			templi.find("span").hide(); //Hide the subnav
		
	});

	$(".submenu").hover(function(elem) { //Hover over event on list item
        $(this).css({ 'background' : '#393939'}); //Change background color
    } , function() { //on hover out...    
        $(this).css({ 'background' : '#F00'});;        
    });
	
	<?php if($this->uri->segment(1)=='dai-ly') {?>
	$("#tabsholder").tytabs({
		tabinit:"1",
		fadespeed:"fast"
	});
	<?php }?>
	
	<?php if($this->uri->segment(1)=='') {?>
	$('.slider4').bxSlider({
		slideWidth: 300,
		pause: 3000,
		minSlides: 3,
		maxSlides: 3,
		moveSlides: 1,
		slideMargin: 10,
		auto: true,
		autoStart: true,
		autoHover:true,
		pager: false
	});
	<?php }?>
	
});

$(window).load(function() {
	$('#slide_banner').nivoSlider({ pauseTime:3000, pauseOnHover:false, effect:'random', controlNav: false });
});
</script>
<?php if($this->uri->segment(1)=='san-pham' && $this->uri->segment(2)=='chi-tiet') {?>
<script type="text/javascript">
$(document).ready(function(){
	$('#tabs div.content_sub_product').hide();
	$('#tabs div.content_sub_product:first').show();
	$('#tabs ul.sub_product_nav li:first a').addClass('active_sub');

	$('#tabs ul.sub_product_nav li a').click(function(){
		if($(this).attr("target") != "_blank")
		{
			$('#tabs ul.sub_product_nav li a.active_sub').removeClass('active_sub'); // remove current
			$(this).addClass('active_sub'); 
			var currentTab = $(this).attr('href'); 
			$('#tabs div.content_sub_product').hide();
			$(currentTab).show();
			return false;
		}
	});
});
</script>
<?php } if(isset($script_addon_extended) && ($script_addon_extended)) {?>
<script type="text/javascript">//<![CDATA[ 
	$(window).load(function(){
		
		function hide_cols() {
			// hide all cols
			$("div.thongso_kythuat table th.compare_product").hide();
			$("div.thongso_kythuat table td.compare_product").hide();
		}
		
		var f = function() {
			 $("select#select_other_product option:selected").each(function () {
				var current_class = $(this).val();
				hide_cols();
				$("div.thongso_kythuat table th."+current_class).show();
				$("div.thongso_kythuat table td."+current_class).show();
			});
		};
		
		hide_cols();
		$("select#select_other_product").change(f);
		
		
	});//]]>  

</script>
<?php }?>

</head>

<body>

	<div class="header"><!--Begin: header-->
		
    	<div class="wrapper"><!--Begin: wrapper header-->
			
        	<div class="logo"><a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>assets/images/logo.png" alt="Isuzu Logo" /></a></div>
            
            <div class="lang">
            	<a href="<?php echo base_url();?>language/to/english"><img src="<?php echo base_url()?>assets/images/en_flag.png" alt="English" /></a>
                <a href="<?php echo base_url()?>language/to/vietnamese"><img src="<?php echo base_url()?>assets/images/vn_flag.png" alt="Vietnamese" /></a>
            </div>
            
			<?php echo modules::run('home/_render_top_menu');?>
            
			<!-- main menu -->
			<div class="main_menu"><!--Begin: main menu-->
				<?php echo $render_main_menu;?>
			</div>
			
        </div><!--End: wrapper header-->
    </div><!--End: header-->
    
	<!-- slide banner part -->
	<?php if($main_slide_banner!='') echo $main_slide_banner;?>
	
	<!-- content -->
	<div class="main_content"><!--Begin: main content-->
    	<div class="wrapper"><!--Begin: wrapper main content-->
			<?php echo $content_render;?>
		</div><!--End: wrapper main content-->
    </div><!--End: main content-->
	<!-- / content -->
	
	<div class="footer"><!--Begin: footer-->
    	<div class="wrapper">
        	<div class="left_footer">
                <div class="footer_nav">
                    <a href="<?php echo base_url();?>"><?php echo $this->lang->line('footer_menu_home');?></a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                    <a href="<?php echo site_url('san-pham');?>"><?php echo $this->lang->line('footer_menu_product');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;  
                    <a href="<?php echo site_url('dich-vu');?>"><?php echo $this->lang->line('footer_menu_service');?></a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                    <a href="<?php echo site_url('phu-tung');?>"><?php echo $this->lang->line('footer_menu_part');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="<?php echo site_url('dai-ly');?>"><?php echo $this->lang->line('footer_menu_dealer');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="<?php echo site_url('tin-tuc');?>"><?php echo $this->lang->line('footer_menu_news');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="<?php echo site_url('dang-ki-lai-thu');?>"><?php echo $this->lang->line('footer_menu_testdrivereg');?></a>
                </div>
				<!-- footer contact -->
				<div class="foot_contact">
					<?php echo $footer_contact_info;?>
				</div>
            </div>
            
            <div class="right_footer">            
                <div class="copyright">
                    <p><?php echo $this->lang->line('footer_copyright');?></p>
                </div>
                
                <div class="social_foot">
                	<a href="https://plus.google.com/<?php echo $isuzu_gplus_id;?>"><img src="<?php echo base_url()?>assets/images/gplus.png" alt="" /></a>
                    <a href="https://www.facebook.com/<?php echo $isuzu_fb_page;?>"><img src="<?php echo base_url()?>assets/images/fb.png" alt="" /></a>
                    <a href="https://twitter.com/<?php echo $isuzu_twitter_page;?>"><img src="<?php echo base_url()?>assets/images/twitter.png" alt="" /></a>
                </div>
                
				<?php echo modules::run('home/_render_footer_weblinks');?>
				
            </div>
        </div>    
    </div><!--End: footer-->
	
	<div id="gotop" style="z-index:9999;bottom:0;"><img src="<?php echo base_url()?>assets/images/gotop.png" alt="Go top" /></div>
	
	<?php if(isset($lightbox_script['js']) && $lightbox_script['js']!='') echo $lightbox_script['js'];
	if(isset($load_lightbox_code)) echo $load_lightbox_code;?>
	
	<?php if(isset($news_sticky_js) && $news_sticky_js!='') echo $news_sticky_js;?>
	
	<script type="text/javascript">
		$(function() {
			$(window).scroll(function() {
				if($(this).scrollTop() != 0) {
					$('#gotop').fadeIn(300);	
				} else {
					$('#gotop').fadeOut(200);
				}
			});
		 
			$('#gotop').click(function() {
				$('body,html').animate({scrollTop:0},800);
			});	
		});
	</script>
	
	<script type="text/javascript"> Cufon.now(); 
		var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-43643201-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
</body>
</html>