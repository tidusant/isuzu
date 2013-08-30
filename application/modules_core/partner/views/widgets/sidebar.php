
			<?php if(isset($menu_product_catalog) && $menu_product_catalog!=false) {?>
			<ul>
				<?php foreach($menu_product_catalog->result() as $cate) {?>
					<li><p><a href="<?php echo site_url('san-pham/loai/'.$cate->slug);?>"><?php echo $cate->cate_name;?></a></p></li>
				<?php }?>
			</ul>
			<?php }?>