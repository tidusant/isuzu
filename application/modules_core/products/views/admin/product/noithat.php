				<div class="form-box-content">
					
					<!-- slide images -->
					<!-- image -->
					<?php if($product_media!=false) { ?>
					
					<div class="control-group">
					<label class="control-label" for="image_show">Current Images</label>
					<div class="controls">
					<a href="#" rel="lightbox"><img src="<?php echo $product_media->thumb_url.$product_media->media_filename;?>" alt="<?php echo $product_media->media_name;?>" id="image_show" /></a>
					</div>
					</div>
					
					<?php } ?>
					
					<div class="control-group" id="gallery-select-area">
					
					<label class="control-label" for="product_image">Select Image</label>
					<div class="controls">
					<select multiple="multiple" class="image-picker" name="image_media_select_slide[]">
					  <?php foreach($gallery_list->result() as $img) {?>
					  <option data-img-src="<?php echo $img->thumb_url.$img->media_filename;?>" value="<?php echo $img->id;?>">  <?php echo $img->media_name;?>  </option>
					  <?php }?>
					</select>
					
					</div>
					</div>
					
				</div>