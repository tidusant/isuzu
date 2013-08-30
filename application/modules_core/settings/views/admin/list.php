
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo base_url();?>administration/"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('setting_title');?></a></li>
<li class="active">Settings</li>       
</ul>

<h3 class="page-header">Setting configuration</h3>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<form class="form-horizontal form-box" method="post" action="<?php echo site_url($this->uri->segment(1).'/settings/save'); ?>" />
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#setting-tabs-webconf">Website Configuration</a></li>
		<li><a href="#setting-tabs-nw">Social Network Setting</a></li>
		<li><a href="#setting-tabs-other">Widgets Modifying</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="setting-tabs-webconf">
			<div class="form-box-content">
			
			<!-- website title -->
			
			<div class="control-group">
			<label class="control-label" for="application_title"><?php echo $this->lang->line('setting_application_title'); ?>:</label>
			<div class="controls">
				
				<input type="text" name="application_title" id="application_title" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('application_title');?>" />
			
			</div>
			</div>
			
			<!-- result per page -->
			<div class="control-group">
			<label class="control-label" for="results_per_page"><?php echo $this->lang->line('setting_result_per_page'); ?>:</label>
			<div class="controls">
				
				<input type="text" name="results_per_page" id="results_per_page" class="input-mini" value="<?php echo $this->isuzu_setting_data->setting('results_per_page');?>" />
			
			</div>
			</div>
			
			<!-- date format -->
			<div class="control-group">
			<label class="control-label" for="results_per_page"><?php echo $this->lang->line('setting_date_format'); ?>:</label>
			<div class="controls">
				
				<input type="text" name="default_date_format" id="default_date_format" class="input-small" value="<?php echo $this->isuzu_setting_data->setting('default_date_format');?>" />
			
			</div>
			</div>
			
			<!-- footer contact information -->
			<div class="control-group">
			<label class="control-label" for="footer_contact_info"><?php echo $this->lang->line('setting_contact_footer'); ?>:</label>
			<div class="controls">
				
				<textarea name="setting_contact_footer" id="footer_contact_info" class="textarea-elastic" rows="3"><?php echo $this->isuzu_setting_data->setting('setting_contact_footer'); ?></textarea>
				
				&nbsp;&nbsp;&nbsp; - English - 
				<textarea name="setting_contact_footer_en" id="footer_contact_info_en" class="textarea-elastic" rows="3"><?php echo $this->isuzu_setting_data->get_lang('setting_contact_footer'); ?></textarea>
				
			</div>
			</div>
			
			<!-- intro information 1 -->
			<div class="control-group">
			<label class="control-label" for="setting_intro_above_drive_1"><?php echo $this->lang->line('setting_intro_above_drive_form_1'); ?>:</label>
			<div class="controls">
				
				<textarea name="setting_intro_above_drive_1" id="setting_intro_above_drive_1" class="textarea-elastic" rows="3"><?php echo $this->isuzu_setting_data->setting('setting_intro_above_drive_1'); ?></textarea>
				
				&nbsp;&nbsp;&nbsp; - English - 
				<textarea name="setting_intro_above_drive_1_en" id="setting_intro_above_drive_1_en" class="textarea-elastic" rows="3"><?php echo $this->isuzu_setting_data->get_lang('setting_intro_above_drive_1'); ?></textarea>
				
			</div>
			</div>
			
			<!-- intro information 2 -->
			<div class="control-group">
			<label class="control-label" for="setting_intro_above_drive_2"><?php echo $this->lang->line('setting_intro_above_drive_form_2'); ?>:</label>
			<div class="controls">
				
				<textarea name="setting_intro_above_drive_2" id="setting_intro_above_drive_2" class="textarea-elastic" rows="3"><?php echo $this->isuzu_setting_data->setting('setting_intro_above_drive_2'); ?></textarea>
				
				&nbsp;&nbsp;&nbsp; - English - 
				<textarea name="setting_intro_above_drive_2_en" id="setting_intro_above_drive_2_en" class="textarea-elastic" rows="3"><?php echo $this->isuzu_setting_data->get_lang('setting_intro_above_drive_2'); ?></textarea>
			
			</div>
			</div>
			
			</div>
		</div>
		
		<div class="tab-pane" id="setting-tabs-nw">
			<div class="form-box-content">
				<!-- facebook script -->
				<div class="control-group">
				<label class="control-label" for="setting_fb_script"><?php echo $this->lang->line('setting_script_facebook'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_fb_script" name="setting_facebook_script" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('setting_facebook_script');?>" />
				
				</div>
				</div>
				
				<!-- twitter script -->
				<div class="control-group">
				<label class="control-label" for="setting_twitter_script"><?php echo $this->lang->line('setting_script_skype'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_twitter_script" name="setting_twitter_script" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('setting_twitter_script');?>" />
				
				</div>
				</div>
				
				<!-- gplus script -->
				<div class="control-group">
				<label class="control-label" for="setting_gplus_script"><?php echo $this->lang->line('setting_script_yahoo'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_gplus_script" name="setting_gplus_script" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('setting_gplus_script');?>" />
				
				</div>
				</div>
			</div>
		</div>
		
		<!-- other setting -->
		<div class="tab-pane" id="setting-tabs-other">
			<div class="form-box-content">
				<!-- News on home -->
				<div class="control-group">
				<label class="control-label" for="setting_news_on_home"><?php echo $this->lang->line('setting_home_show_news'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_news_on_home" name="setting_home_show_news" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('home_show_news');?>" />
				
				</div>
				</div>
				
				<!-- Promotion on home -->
				<div class="control-group">
				<label class="control-label" for="setting_promotion_on_home"><?php echo $this->lang->line('setting_home_show_promotion'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_promotion_on_home" name="setting_home_show_promotion" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('home_show_promotion');?>" />
				
				</div>
				</div>
				
				<!-- Product on home -->
				<div class="control-group">
				<label class="control-label" for="setting_product_on_home"><?php echo $this->lang->line('setting_home_show_product'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_product_on_home" name="setting_home_show_product" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('home_show_product');?>" />
				
				</div>
				</div>
				
				<!-- News on sidebar -->
				<div class="control-group">
				<label class="control-label" for="setting_news_on_sidebar"><?php echo $this->lang->line('setting_sidebar_show_news'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_news_on_sidebar" name="setting_sidebar_show_news" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('sidebar_show_news');?>" />
				
				</div>
				</div>
				
				<!-- Faq on sidebar -->
				<div class="control-group">
				<label class="control-label" for="setting_faq_on_sidebar"><?php echo $this->lang->line('setting_faq_sidebar_show'); ?>:</label>
				<div class="controls">
					
					<input type="text" id="setting_faq_on_sidebar" name="setting_sidebar_show_faq" class="input-xlarge" value="<?php echo $this->isuzu_setting_data->setting('faq_sidebar_show');?>" />
				
				</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<!-- global action -->
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php echo $this->lang->line('edit_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
	</form>