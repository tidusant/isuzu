<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('news_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="">

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('news_module');?></h4>
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
		<li><a href="#language-tabs-image">Image</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="language-tabs-langvn">
			<div class="form-box-content">
	
			<!-- form content -->
			
			<!-- title -->
			<div class="control-group">
			<label class="control-label" for="news_name">* <?php echo $this->lang->line('news_title'); ?>:</label>
			<div class="controls">
			<input type="text" name="event_title" id="news_name" value="<?php echo $this->admin_model_news->form_value('event_title'); ?>" class="input-medium" />
			</div>
			</div>
			
			<!-- slug seo -->
			<div class="control-group">
			<label class="control-label" for="news_slug">* <?php echo $this->lang->line('news_slug'); ?></label>
			<div class="controls">
			<input type="text" name="event_slug" id="news_slug" value="<?php echo $this->admin_model_news->form_value('event_slug'); ?>" class="slugify input-medium" />
			</div>
			</div>
			
			<!-- content -->
			<div class="control-group">
			<label class="control-label" for="event_description">* <?php echo $this->lang->line('news_content'); ?></label>
			<div class="controls">
			<textarea id="event_description" name="event_content" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_news->form_value('event_content'); ?></textarea>
			</div>
			</div>
			
			<!-- event on top -->
			<div class="control-group">
			<label class="control-label" for="is_ontop"><?php echo $this->lang->line('news_ontop'); ?></label>
			<div class="controls">
				<input type="checkbox" name="event_ontop" id="is_ontop" value="1" <?php if ($this->admin_model_news->form_value('event_ontop')) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			<!-- is promotion -->
			<div class="control-group">
			<label class="control-label" for="is_promotion"><?php echo $this->lang->line('news_promotion'); ?></label>
			<div class="controls">
				<input type="checkbox" name="event_promotion" id="is_promotion" value="1" <?php if ($this->admin_model_news->form_value('event_promotion')) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			<!-- registration form -->
			<div class="control-group">
			<label class="control-label" for="reg_form"><?php echo $this->lang->line('news_reg_form'); ?></label>
			<div class="controls">
				<input type="checkbox" name="event_reg_form" id="reg_form" value="1" <?php if ($this->admin_model_news->form_value('event_reg_form')) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			<!-- is comment ? -->
			<div class="control-group">
			<label class="control-label" for="is_comment"><?php echo $this->lang->line('news_comment'); ?></label>
			<div class="controls">
				<input type="checkbox" name="comment_allow" id="is_comment" value="1" <?php if ($this->admin_model_news->form_value('comment_allow')) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			<!-- order -->
			
			<div class="control-group">
			<label class="control-label" for="news_priority"><?php echo $this->lang->line('news_priority'); ?></label>
			<div class="controls">
			<input type="text" id="news_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_news->form_value('display_order')) echo '09'; else echo $this->admin_model_news->form_value('display_order');?>" />
			</div>
			</div>
			
			<!-- active -->
			
			<div class="control-group">
			<label class="control-label" for="news_active"><?php echo $this->lang->line('news_active'); ?></label>
			<div class="controls">
				<input type="checkbox" name="active" id="news_active" value="1" <?php if ($this->admin_model_news->form_value('active') or (!$_POST and !uri_assoc('news_id'))) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			</div>
		</div>
		
		<div class="tab-pane" id="language-tabs-langen">
			<!-- lang en data -->
			<div class="form-box-content">
				
				<div class="control-group">
				<label class="control-label" for="news_name_en">Title:</label>
				<div class="controls">
				<input type="text" name="news_title_en" id="news_name_en" value="<?php if($newsobj_en!=false) echo $newsobj_en->event_title; ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- content -->
				<div class="control-group">
				<label class="control-label" for="event_description_en">Content:</label>
				<div class="controls">
				<textarea id="event_description_en" name="news_content_en" class="tinymce textarea-large" rows="20"><?php if($newsobj_en!=false) echo $newsobj_en->event_content; ?></textarea>
				</div>
				</div>
				
			</div>
		</div>
		
		<!-- image tab -->
		<div class="tab-pane" id="language-tabs-image">
			<!-- lang en data -->
			<div class="form-box-content">
				<?php if(uri_assoc('news_id')) { ?>
				<!-- image select -->
				<div class="control-group">
				<div class="controls">
				<a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_news->form_value('event_link_image');?>" alt="" id="image_show" width="160" height="120" /></a>
				</div>
				</div>
				<?php }?>
				<div class="control-group">
					<label class="control-label" for="image_select_id">Avatar Image</label>
					<div class="controls">
						<input class="input-large" id="image_select_id" name="event_link_image" type="text" value="<?php echo $this->admin_model_news->form_value('event_link_image');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/news/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
	
	<!-- global action -->
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('news_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
</form>
	<!-- / form 1 edit -->
	