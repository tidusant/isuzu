<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/index');?>">Catalog List</a></li>
<?php $breadcum = 1;
if(uri_assoc('cate_id')) $breadcum = uri_assoc('cate_id');
elseif(uri_assoc('pat_id')) $breadcum = $this->admin_model_pattern->form_value('product_cate_pc_id');?>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern/index/'.$breadcum);?>">Catalog Pattern</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="<?php echo site_url($this->uri->uri_string());?>">

	<h4 class="form-box-header"><?php echo $action_type.' Catalog Pattern';?></h4>
		
	<div class="form-box-content">
		
		<!-- catalog -->
		<div class="control-group" id="catalog">
		<label class="control-label" for="product_cate_pc_id">Catalog</label>
			<div class="controls">
				<select name="product_cate_pc_id" id="product_cate_pc_id" class="select-chosen">
					<?php if($catalog_list!=false) {
						$option_selected = '';
							foreach($catalog_list->result() as $cate) {
								if(uri_assoc('cate_id')) {
									if(uri_assoc('cate_id') == $cate->pc_id) $option_selected = ' selected';
									else $option_selected = '';
								} elseif($this->admin_model_pattern->form_value('product_cate_pc_id') == $cate->pc_id) {
									$option_selected = ' selected';
								} else $option_selected = '';
								
								echo '<option value="'.$cate->pc_id.'"'.$option_selected.'>'.$cate->pc_name.'</option>';
							}
					}?>
				</select>
			</div>
		</div>
		
		<!-- pattern group -->
		<div class="control-group" id="pattern_group">
		<label class="control-label" for="pattern_group">Pattern Group</label>
			<div class="controls">
				<select name="pattern_group_id" id="pattern_group" class="select-chosen">
					<?php if($pattern_group_list!=false) {
						$option_selected = '';
							foreach($pattern_group_list->result() as $group) {
								if($this->admin_model_pattern->form_value('pattern_group_id') == $group->id) $option_selected = ' selected';
								else $option_selected = '';
								
								echo '<option value="'.$group->id.'"'.$option_selected.'>'.$group->group_name.'</option>';
							}
					}?>
				</select>
			</div>
		</div>
		
		<!-- label -->
		<div class="control-group">
		<label class="control-label" for="pattern_name">* Pattern Name:</label>
		<div class="controls">
		<input type="text" name="pattern_name" id="pattern_name" value="<?php echo $this->admin_model_pattern->form_value('pattern_name'); ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- name english -->
		<div class="control-group">
		<label class="control-label" for="pattern_name_en">Pattern Name (EN):</label>
		<div class="controls">
		<input type="text" name="pattern_name_en" id="pattern_name_en" value="<?php if($patterntech_obj_en!=false) echo $patterntech_obj_en->pattern_name; ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- dvt -->
		<div class="control-group">
		<label class="control-label" for="pattern_unit">Pattern Unit:</label>
		<div class="controls">
		<input type="text" name="pattern_unit" id="pattern_unit" value="<?php echo $this->admin_model_pattern->form_value('pattern_unit'); ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- dvt english -->
		<div class="control-group">
		<label class="control-label" for="pattern_unit">Pattern Unit(EN):</label>
		<div class="controls">
		<input type="text" name="pattern_unit_en" id="pattern_unit_en" value="<?php if($patterntech_obj_en!=false) echo $patterntech_obj_en->pattern_unit; ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- display order -->
		<div class="control-group">
		<label class="control-label" for="display_order">Position Order:</label>
		<div class="controls">
		<input type="text" name="display_order" id="display_order" value="<?php if($this->admin_model_pattern->form_value('display_order')!='') echo $this->admin_model_pattern->form_value('display_order'); else echo '09'; ?>" class="input-medium" />
		</div>
		</div>
		
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('pat_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
		
	</div>
	
</form>
<!-- / form 1 edit -->