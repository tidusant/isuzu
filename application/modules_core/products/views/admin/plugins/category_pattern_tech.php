			<div class="form-box-content">
				
				<legend>Group 1</legend>
				
				<fieldset>
					<!-- pattern group -->
					<div class="control-group" id="pattern_group">
					<label class="control-label" for="pattern_group">Pattern Group</label>
						<div class="controls">
							<select name="pattern_group[]" id="pattern_group" class="select-chosen">
								<?php if($pattern_group_list!=false) {
									$option_selected = '';
										foreach($pattern_group_list->result() as $group)
											echo '<option value="'.$group->id.'" '.$option_selected.'>'.$group->group_name.'</option>';
								}?>
							</select>
						</div>
					</div>
			
					<!-- label -->
					<div class="control-group">
					<label class="control-label" for="pattern_name">Pattern Name:</label>
					<div class="controls">
					<input type="text" name="pattern_name[]" id="pattern_name" value="<?php //echo $this->admin_model_category->form_value('pc_name'); ?>" class="input-medium" />
					</div>
					</div>
					
					<!-- dvt -->
					<div class="control-group">
					<label class="control-label" for="pattern_unit">Pattern Unit:</label>
					<div class="controls">
					<input type="text" name="pattern_unit[]" id="pattern_unit" value="<?php //echo $this->admin_model_category->form_value('pc_name'); ?>" class="input-medium" />
					</div>
					</div>
					
					<!-- display order -->
					<div class="control-group">
					<label class="control-label" for="display_order">Position Order:</label>
					<div class="controls">
					<input type="text" name="position_ordering[]" id="display_order" value="<?php ///echo $this->admin_model_category->form_value('pc_name'); ?>" class="input-medium" />
					</div>
					</div>
				</fieldset>
				
			</div>
			
			<p><a href="#addmorepattern" id="insertnewpattern">Insert Blank Row</a></p>
			
			<script type="text/javascript">
			$(document).ready(function(){
				$("#insertnewpattern").click(function () {
					var patterngroup = $(document.createElement('div'))
					 .attr("id", 'pattern_group_1');
					 patterngroup.attr("style",'float: left;');
					 
					 var patternname = $(document.createElement('div'))
					 .attr("id", 'pattern_name_1');
					 patternname.attr("style",'float: left;');
					 
					 var patternunit = $(document.createElement('div'))
					 .attr("id", 'pattern_unit_1');
					 patternunit.attr("style",'float: left;');
					 
					 var patternorder = $(document.createElement('div'))
					 .attr("id", 'pattern_order_1');
					 patternorder.attr("style",'float: left;');
					 
					 newTextBoxDiv1.after().html('<label  class="inputlabel2">Speaker Name : </label>' +
					  '<input type="text" name="speakername" id="speakername" value="" >');
					  newTextBoxDiv2.after().html('<label  class="inputlabel2">Speaker Country : </label>' +
					  '<input type="text" name="speakercountry" id="speakercountry" value="" >');
					  newTextBoxDiv3.after().html('<label  class="inputlabel2">Speaker Company : </label>' +
					  '<input type="text" name="speakercompany" id="textbox" value="" >');
					  newTextBoxDiv4.after().html('<label  class="inputlabel2">Speaker Desc : </label>' +
					  '<textarea name="speakerdesc" id="speakerdesc" rows="10" cols="30" ></textarea>');
					  
					  newTextBoxDiv1.appendTo("#TextBoxesGroup");
					  newTextBoxDiv2.appendTo("#TextBoxesGroup");
					  newTextBoxDiv3.appendTo("#TextBoxesGroup");
					  newTextBoxDiv4.appendTo("#TextBoxesGroup");
					  
					  
				});
			});
			</script>