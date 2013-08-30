			<div class="form-box-content">
				<div class="control-group">
					<label class="control-label" for="product_slide_image">Product Slide</label>
					<div class="controls">
						<select name="product_slide_id" id="product_slide_image" class="select-chosen">
						<option value="0">-None-</option>
						<?php if($slide_images_list!=false) {
							foreach($slide_images_list->result() as $img) {?>
							<option value="<?php echo $img->id;?>" <?php if($selected_slide_id<>0 && $selected_slide_id==$img->id) echo 'selected';?>><?php echo $img->product_gallery_name;?></option>
						  <?php }
						}?>
						</select>
					</div>
					
				</div>
			</div>