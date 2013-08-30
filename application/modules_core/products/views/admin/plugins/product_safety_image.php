			<div class="form-box-content">
				<div class="control-group">
					<label class="control-label" for="product_safety_image">Safety</label>
					<div class="controls">
						<select class="select-chosen" name="product_safety_id" id="product_safety_image">
						<option value="0">-None-</option>
						<?php if($safety_images_list!=false) {
							foreach($safety_images_list->result() as $img) {?>
							<option value="<?php echo $img->id;?>" <?php if($selected_safety_id<>0 && $selected_safety_id==$img->id) echo 'selected';?>><?php echo $img->product_gallery_name;?></option>
						  <?php }
						}?>
						</select>
					</div>
					
				</div>
			</div>