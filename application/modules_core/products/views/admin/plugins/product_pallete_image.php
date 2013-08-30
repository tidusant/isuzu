			<div class="form-box-content">
				<div class="control-group">
					<label class="control-label" for="product_pallete_image">Pallete</label>
					<div class="controls">
						<select class="select-chosen" name="product_pallete_id" id="product_pallete_image">
						<option value="0">-None-</option>
						<?php if($pallete_images_list!=false) {
							foreach($pallete_images_list->result() as $img) {?>
							<option value="<?php echo $img->id;?>" <?php if($selected_pallete_id<>0 && $selected_pallete_id==$img->id) echo 'selected';?>><?php echo $img->product_gallery_name;?></option>
						  <?php }
						}?>
						</select>
					</div>
					
				</div>
			</div>