			<div class="right_sub_box" id="sidebar_ads">
				<?php if($banner_sidebar!=false) {
					foreach($banner_sidebar->result() as $item)
					{
						echo '<a href="'.$item->banner_link.'">';
						echo '<img src="'.$item->banner_link_image.'" alt="'.$item->banner_title.'" style="max-width:'.$this->config->item('sidebar_banner_max_w').'px;" />';
						echo '</a>';
					}
				}?>
			</div>