

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('faq_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" enctype="multipart/form-data" />

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('faq_module');?></h4>
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="language-tabs-langvn">
			<div class="form-box-content">
	
			<!-- form content -->
			
			<!-- question title -->
			<div class="control-group">
			<label class="control-label" for="question_title">* <?php echo $this->lang->line('faq_question'); ?>:</label>
			<div class="controls">
			
			<textarea id="question_title" name="faq_question" class="textarea-elastic" rows="3"><?php echo $this->admin_model_faq->form_value('faq_question'); ?></textarea>
			
			</div>
			</div>
			
			<!-- answer -->
			<div class="control-group">
			<label class="control-label" for="answer_content">* <?php echo $this->lang->line('faq_answer'); ?></label>
			<div class="controls">
			<textarea id="answer_content" name="faq_answer" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_faq->form_value('faq_answer'); ?></textarea>
			</div>
			</div>
			
			<!-- feature -->
			<div class="control-group">
			<label class="control-label" for="faq_feature"><?php echo $this->lang->line('faq_feature'); ?></label>
			<div class="controls">
				<input type="checkbox" name="is_feature" id="faq_feature" value="1" <?php if ($this->admin_model_faq->form_value('is_feature')) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			<!-- order -->
			
			<div class="control-group">
			<label class="control-label" for="faq_priority"><?php echo $this->lang->line('faq_priority'); ?></label>
			<div class="controls">
			<input type="text" id="faq_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_faq->form_value('display_order')) echo '09'; else echo $this->admin_model_faq->form_value('display_order');?>" />
			</div>
			</div>
			
			<!-- active -->
			
			<div class="control-group">
			<label class="control-label" for="faq_active"><?php echo $this->lang->line('faq_active'); ?></label>
			<div class="controls">
				<input type="checkbox" name="enable" id="faq_active" value="1" <?php if ($this->admin_model_faq->form_value('enable') or (!$_POST and !uri_assoc('f_id'))) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
			</div>
		</div>
		
		<div class="tab-pane" id="language-tabs-langen">
			<!-- lang en data -->
			<div class="form-box-content">
				
				<div class="control-group">
				<label class="control-label" for="faq_question_en"><?php echo $this->lang->line('faq_question'); ?>:</label>
				<div class="controls">
				<textarea id="faq_question_en" name="question_title_en" class="textarea-elastic" rows="3"><?php if(isset($faqobj_en) && $faqobj_en!=false) echo $faqobj_en->faq_question; ?></textarea>
				</div>
				</div>
				
				<!-- content -->
				<div class="control-group">
				<label class="control-label" for="faq_answer_en"><?php echo $this->lang->line('faq_answer'); ?>:</label>
				<div class="controls">
				<textarea id="faq_answer_en" name="answer_content_en" class="tinymce textarea-large" rows="20"><?php if(isset($faqobj_en) && $faqobj_en!=false) echo $faqobj_en->faq_answer; ?></textarea>
				</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- global action -->
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('f_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->
	