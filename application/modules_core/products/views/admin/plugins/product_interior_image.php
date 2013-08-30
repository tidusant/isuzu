			<div class="form-box-content">
				<div class="control-group">
					<label class="control-label" for="product_interior_image">Product Interior</label>
					<div class="controls">
						<select name="product_interior_id" id="product_interior_image" class="select-chosen">
						<option value="0">-None-</option>
						<?php if($interior_images_list!=false) {
							foreach($interior_images_list->result() as $img) {?>
							<option value="<?php echo $img->id;?>" <?php if($selected_interior_id<>0 && $selected_interior_id==$img->id) echo 'selected';?>><?php echo $img->product_gallery_name;?></option>
						  <?php }
						}?>
						</select>
					</div>
					
				</div>
			</div>