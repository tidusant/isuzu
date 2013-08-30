

<ul id="nav-info" class="clearfix">
	<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
	<li><a href="<?php echo site_url($this->uri->segment(1).'/menu/index');?>"><?php echo $this->lang->line('menu_module');?></a></li>
	<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('menu_module');?></h4>
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
	</ul>
	<div class="tab-content">
		
		<div class="tab-pane active" id="language-tabs-langvn">
			<div class="form-box-content">
			<!-- form content -->
			<!-- name -->
			<div class="control-group">
			<label class="control-label" for="menu_name">* <?php echo $this->lang->line('menu_name'); ?>:</label>
			<div class="controls">
			<input type="text" name="name" id="menu_name" value="<?php echo $this->admin_model_menu->form_value('name'); ?>" class="input-medium" />
			</div>
			</div>
			
			<!-- parents level -->
			<div class="control-group">
			<label class="control-label" for="root_menu"><?php echo $this->lang->line('root_menu_name'); ?>:</label>
			<div class="controls">
				<select name="seft_id" id="root_menu" class="select-chosen">
					<option value="0">-N/A-</option>
					<?php if($root_menu_list!=false) {
							foreach($root_menu_list->result() as $rml) {
								if($this->admin_model_menu->form_value('seft_id') == $rml->id) {
									$selected_option = 'selected';
								} else $selected_option = '';
								
								echo '<option value="'.$rml->id.'" '.$selected_option.'>'.$rml->name.'</option>';
							}
					}?>
				</select>
			</div>
			</div>
			
			<!-- title -->
			<div class="control-group">
			<label class="control-label" for="menu_title">* <?php echo $this->lang->line('menu_title'); ?>:</label>
			<div class="controls">
			<input type="text" name="title" id="menu_title" value="<?php echo $this->admin_model_menu->form_value('title'); ?>" class="input-medium" />
			</div>
			</div>
			
			<!-- slug seo -->
			<div class="control-group">
			<label class="control-label" for="slug">* <?php echo $this->lang->line('menu_slug'); ?></label>
			<div class="controls">
			<input type="text" name="menu_slug" id="slug" value="<?php echo $this->admin_model_menu->form_value('menu_slug'); ?>" class="slugify input-medium" />
			</div>
			</div>
			
			<!-- url -->
			<div class="control-group">
			<label class="control-label" for="menu_title"><?php echo $this->lang->line('menu_url'); ?>:</label>
			<div class="controls">
			<input type="text" name="url" id="menu_url" value="<?php echo $this->admin_model_menu->form_value('url'); ?>" class="input-medium" />
			</div>
			</div>
			
			<!-- order -->
			<div class="control-group">
			<label class="control-label" for="order_priority"><?php echo $this->lang->line('menu_priority'); ?></label>
			<div class="controls">
			<input type="text" id="order_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_menu->form_value('display_order')) echo '09'; else echo $this->admin_model_menu->form_value('display_order'); ?>" />
			</div>
			</div>
			
			<!-- active -->
			<div class="control-group">
			<label class="control-label" for="menu_active"><?php echo $this->lang->line('menu_active'); ?></label>
			<div class="controls">
				<input type="checkbox" name="active" id="menu_active" value="1" <?php if ($this->admin_model_menu->form_value('active') or (!$_POST and !uri_assoc('menu_id'))) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			</div>
		</div>
		
		<div class="tab-pane" id="language-tabs-langen">
			<!-- lang en data -->
			<div class="form-box-content">
				
				<!-- name -->
				<div class="control-group">
				<label class="control-label" for="menu_name">Name:</label>
				<div class="controls">
				<input type="text" name="name_en" id="menu_name" value="<?php if($menuobj_en!=false) echo $menuobj_en->name; ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- title -->
				<div class="control-group">
				<label class="control-label" for="menu_title">Title:</label>
				<div class="controls">
				<input type="text" name="title_en" id="menu_title" value="<?php if($menuobj_en!=false) echo $menuobj_en->title; ?>" class="input-medium" />
				</div>
				</div>
				
			</div>
		</div>
		
		
	</div>
	
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('menu_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
	
	</form>
	<!-- / form 1 edit -->