
<ul id="nav-info" class="clearfix">
	<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
	<li><a href="<?php echo site_url($this->uri->segment(1).'/pages/index');?>"><?php echo $this->lang->line('page_title');?></a></li>
	<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="">

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('page_title');?></h4>
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="language-tabs-langvn">
			<!-- lang vn data -->
			<div class="form-box-content">
			<!-- form content -->
			<!-- page tree -->
			<div class="control-group">
			<label class="control-label" for="page_tree_select"><?php echo $this->lang->line('pagetree_module'); ?></label>
			<div class="controls">
				<select name="page_tree_pt_id" id="page_tree_select" class="select-chosen">
					<option value="0">-None-</option>
					<?php if($pagetree_list!=false) {
							$selected_option = '';
							foreach($pagetree_list->result() as $pt) {
								if($this->admin_model_page->form_value('page_tree_pt_id') == $pt->pt_id) {
									$selected_option = 'selected';
								}
								else $selected_option = '';
								
								echo '<option value="'.$pt->pt_id.'" '.$selected_option.'>'.$pt->pt_name.'</option>';
							}
					}?>
				</select>
			</div>
			</div>
			
			<!-- page menu -->
			<div class="control-group">
			<label class="control-label" for="page_menu"><?php echo $this->lang->line('menu_module'); ?></label>
			<div class="controls">
				<select name="isuzu_menu_id" id="page_menu" class="select-chosen">
					<option value="0">-None-</option>
					<?php if($pagemenu_list!=false) {
							$selected_option = '';
							foreach($pagemenu_list->result() as $mn) {
								
								echo '<option value="'.$mn->id.'" style="font-weight:bold;">'.$mn->name.'</option>';
								
								$child_menu_list = $this->admin_model_menu->get_child_list_menu($mn->id);
								
								if($child_menu_list!=false) {
									foreach($child_menu_list->result() as $submenu) {
										if($this->admin_model_page->form_value('isuzu_menu_id') == $submenu->id) {
											$selected_option = 'selected';
										}
										else $selected_option = '';
										
										echo '<option value="'.$submenu->id.'" '.$selected_option.'>-'.$submenu->name.'</option>';
									}
								}
							}
					}?>
				</select>
			</div>
			</div>
			
			<!-- name -->
			<div class="control-group">
			<label class="control-label" for="page_name">* <?php echo $this->lang->line('page_name'); ?>:</label>
			<div class="controls">
			<input type="text" name="page_title" id="page_name" value="<?php echo $this->admin_model_page->form_value('page_title'); ?>" class="input-medium" />
			</div>
			</div>
			
			<!-- slug seo -->
			<div class="control-group">
			<label class="control-label" for="slug">* <?php echo $this->lang->line('page_slug'); ?></label>
			<div class="controls">
			<input type="text" name="page_slug" id="slug" value="<?php echo $this->admin_model_page->form_value('page_slug'); ?>" class="slugify input-medium" />
			</div>
			</div>
			
			<!-- content -->
			<div class="control-group">
			<label class="control-label" for="page_description"><?php echo $this->lang->line('page_description'); ?></label>
			<div class="controls">
			<textarea id="page_description" name="page_content" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_page->form_value('page_content'); ?></textarea>
			</div>
			</div>
			
			<!-- layout -->
			<div class="control-group">
			<label class="control-label" for="page_layout">Page Layout</label>
			<div class="controls">
				<select name="layout" id="page_layout" class="select-chosen">
					<option value="0" <?php if($this->admin_model_page->form_value('layout')=='0') echo 'selected';?>>Full Page</option>
					<option value="1" <?php if($this->admin_model_page->form_value('layout')=='1') echo 'selected';?>>Sidebar Page</option>
				</select>
			</div>
			</div>
			
			<!-- order -->
			<div class="control-group">
			<label class="control-label" for="order_priority"><?php echo $this->lang->line('page_priority'); ?></label>
			<div class="controls">
			<input type="text" id="order_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_page->form_value('display_order')) echo '09'; else echo $this->admin_model_page->form_value('display_order'); ?>" />
			</div>
			</div>
			
			<!-- active -->
			<div class="control-group">
			<label class="control-label" for="page_active"><?php echo $this->lang->line('page_active'); ?></label>
			<div class="controls">
				<input type="checkbox" name="active" id="page_active" value="1" <?php if ($this->admin_model_page->form_value('active') or (!$_POST and !uri_assoc('page_id'))) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			</div>
			
			
		</div>
		<div class="tab-pane" id="language-tabs-langen">
			<!-- lang en data -->
			<div class="form-box-content">
				
				<!-- name -->
				<div class="control-group">
				<label class="control-label" for="page_name_en">Title:</label>
				<div class="controls">
				<input type="text" name="page_title_en" id="page_name_en" value="<?php if($page_lang_obj!=false) echo $page_lang_obj->page_title; ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- content -->
				<div class="control-group">
				<label class="control-label" for="page_description_en">Content:</label>
				<div class="controls">
				<textarea id="page_description_en" name="page_content_en" class="tinymce textarea-large" rows="10"><?php if($page_lang_obj!=false) echo $page_lang_obj->page_content; ?></textarea>
				</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- action button -->
	<div class="form-box-content">
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('page_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	</form>
	<!-- / form 1 edit -->