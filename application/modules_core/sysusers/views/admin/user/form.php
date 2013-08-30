

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/system_users/index');?>">Member</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />
	
<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header"><?php echo $action_type;?> Member</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	<!-- name -->
	<div class="control-group">
	<label class="control-label" for="member_username">* <?php echo $this->lang->line('member_name'); ?>:</label>
	<div class="controls">
	<input type="text" name="su_fullname" id="member_username" value="<?php echo $this->admin_model_member->form_value('su_fullname'); ?>" class="input-large" />
	</div>
	</div>
	
	<!-- email --->
	<div class="control-group">
	<label class="control-label" for="member_email">* <?php echo $this->lang->line('member_email'); ?></label>
	<div class="controls">
	<input type="text" id="member_email" name="su_email" class="input-large" value="<?php echo $this->admin_model_member->form_value('su_email'); ?>" />
	</div>
	</div>
	
	<!-- password -->
	<div class="control-group">
	<label class="control-label" for="password">* <?php echo $this->lang->line('member_password'); ?>:</label>
	<div class="controls">
	<?php if (uri_assoc('member_id')) { ?>
	
	<?php echo anchor(($this->uri->segment(2) == 'profile') ? $this->uri->segment(1).'/system_users/profile/change_password' : $this->uri->segment(1).'/system_users/change_password/member_id/' . uri_assoc('member_id'), $this->lang->line('change_password')); ?>
	
	<?php } else { $ifcac = 1; ?>
	
	<input type="password" id="password_field" name="su_password" class="input-large" data-indicator="pwindicator" />
	
	<div id="pwindicator">
		<div class="bar"></div>
		<div class="label"></div>
	</div>
		
	<?php } ?>
	
	</div>
	</div>
	
	<?php if(isset($ifcac) && $ifcac == 1) { ?>
	<div class="control-group">
	<label class="control-label" for="passwordv">* <?php echo $this->lang->line('member_password_verify'); ?>:</label>
	<div class="controls">
		<input type="password" name="passwordv" id="passwordv" />
	</div>
	</div>
	<?php } ?>
	
	<!-- Level -->
	
	<?php if(uri_assoc('member_id') <> 1) {?>
	<div class="control-group">
	<label class="control-label" for="member_level">* <?php echo $this->lang->line('member_level'); ?></label>
	
		<div class="controls">
			<select name="group_id" id="member_level" class="select-chosen">
				<?php if($members_level!=false) {
					$option_selected = '';
						foreach($members_level->result() as $level) {
							
							if($this->admin_model_member->form_value('group_id') == $level->group_id) { $option_selected = 'selected="selected"'; }
							else $option_selected = '';
							
							echo '<option value="'.$level->group_id.'" '.$option_selected.'>'.$level->group_name.'</option>';
						}
				}?>
			</select>
		</div>
	
	</div>
	<?php }?>
	
	<!-- order -->
	
	<div class="control-group">
	<label class="control-label" for="member_priority"><?php echo $this->lang->line('member_priority'); ?></label>
	<div class="controls">
	<input type="text" id="member_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_member->form_value('display_order')) echo '09'; else echo $this->admin_model_member->form_value('display_order'); ?>" />
	</div>
	</div>
	
	<!-- active -->
	<div class="control-group">
	<label class="control-label" for="member_active"><?php echo $this->lang->line('member_active'); ?></label>
	<div class="controls">
		<input type="checkbox" name="active" id="member_active" value="1" <?php if($this->admin_model_member->form_value('active') or (!$_POST and !uri_assoc('member_id'))) { ?>checked="checked"<?php } ?> />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('member_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->