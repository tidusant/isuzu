			<div class="form-box-content">
				<div class="control-group">
					<label class="control-label" for="product_exterior_image">Exterior</label>
					<div class="controls">
						<select class="select-chosen" name="product_exterior_id" id="product_exterior_image">
						<option value="0">-None-</option>
						<?php if($exterior_images_list!=false) {
							foreach($exterior_images_list->result() as $img) {?>
							<option value="<?php echo $img->id;?>" <?php if($selected_exterior_id<>0 && $selected_exterior_id==$img->id) echo 'selected';?>><?php echo $img->product_gallery_name;?></option>
						  <?php }
						}?>
						</select>
					</div>
					
				</div>
			</div>