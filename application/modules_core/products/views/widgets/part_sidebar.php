			
                    <div class="content_right_product_list">
						<?php if($catalog_product!=false) {?>
                    	<ul>
							<?php foreach($catalog_product->result() as $cate) {?>
                        	<li><p><a href="<?php echo site_url('san-pham/loai/'.$cate->slug);?>"><?php echo $cate->cate_name;?></a></p></li>
							<?php }?>
                        </ul>
						<?php }?>
                    </div>