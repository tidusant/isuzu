
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/banners/position');?>">Banner Position</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" enctype="multipart/form-data" />

	<h4 class="form-box-header"><?php echo $action_type;?> Position</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	
	<!-- banner position -->
	<div class="control-group">
	<label class="control-label" for="banner_position">* Position:</label>
	<div class="controls">
	<input type="text" name="pos_name" id="banner_position" value="<?php echo $this->admin_model_bannerposition->form_value('pos_name'); ?>" class="input-medium" />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('bp_id')) echo 'Save changes'; else echo 'Add';?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="Cancel" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->