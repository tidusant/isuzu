				<ul id="main_nav">
					
					<?php if($menu_page_tree!=false) {
							foreach($menu_page_tree->result() as $pm) { ?>
                    <li>
                        <a href="<?php echo ($pm->url != '' ? site_url($pm->url) : '#');?>" <?php $current_page = $this->uri->segment(1);
						if(isset($active_current_menu[$current_page]) && $pm->menu_slug==$current_page) echo $active_current_menu[$current_page]; elseif($current_page=='' && $pm->menu_slug=='home') echo ' class="active"';?>><?php echo $pm->name;?></a>
						<?php if($pm->menu_slug=='san-pham' && $pm->id==10) { ?>
							<span  style="height:28px">
								<ul style="list-style-type: none;">
								<?php $product_catalog = $menu_product_catalog;
								if($product_catalog!=false) {
									foreach($product_catalog->result() as $cate) { ?>
										<li style="background-position: initial initial; background-repeat: initial initial;line-height: 27px;height: 28px;border-top-left-radius: 0px;border-top-right-radius: 0px;color:#393939" class="submenu">
											<a href="<?php echo site_url('san-pham/loai/'.$cate->pc_slug);?>" style="text-decoration: none;">
										<?php 
										if($cate->pc_image_link_sub!=NULL) {
											echo '<img src="'.$cate->pc_image_link_sub.'" />';
										} else echo $cate->pc_name;
										?>
										</li></a>
								<?php }
								unset($product_catalog);
								} 
								$sub_menu = $this->model_page->get_child_menu($pm->id, $cur_lang);
								if($sub_menu!=false) {
									$subpage_url = '';
									foreach($sub_menu->result() as $sm) {
										if($sm->url!='') {
											if($sm->url=='#')
											$subpage_url = $sm->url;
											else $subpage_url = site_url($sm->url);
										} 
										else $subpage_url = site_url($sm->menu_slug);?>
										<li style="background-position: initial initial; background-repeat: initial initial;line-height: 27px;height: 28px;border-top-left-radius: 0px;border-top-right-radius: 0px;" class="submenu">
											<a href="<?php echo $subpage_url;?>"><?php echo $sm->name;?></a>
										</li>
								<?php }
								}?>
								</ul>
							</span>
						<?php } elseif($pm->menu_slug=='phu-tung' && $pm->id==6) { ?>
							<span  style="height:28px">
								<ul style="list-style-type: none;">
								<?php $part_catalog = $menu_product_catalog;
								if($part_catalog!=false) {
									foreach($part_catalog->result() as $cate) { ?>
										<li style="background-position: initial initial; background-repeat: initial initial;line-height: 27px;height: 28px;border-top-left-radius: 0px;border-top-right-radius: 0px;" class="submenu">
											<a href="<?php echo site_url('phu-tung/loai/'.$cate->pc_slug);?>" style="text-decoration: none;">
										<?php 
										if($cate->pc_image_link_sub!=NULL) { 
											echo '<img src="'.$cate->pc_image_link_sub.'" />';
										} else echo $cate->pc_name;
										?>
										</a>
										</li>
								<?php }
								unset($part_catalog);
								} 
								$sub_menu = $this->model_page->get_child_menu($pm->id, $cur_lang);
								if($sub_menu!=false) {
									$subpage_url = '';
									foreach($sub_menu->result() as $sm) {
										if($sm->url!='') {
											if($sm->url=='#')
											$subpage_url = $sm->url;
											else
											$subpage_url = site_url($sm->url);
										}
										else $subpage_url = site_url($sm->menu_slug);?>
										<li style="background-position: initial initial; background-repeat: initial initial;line-height: 27px;height: 28px;border-top-left-radius: 0px;border-top-right-radius: 0px;" class="submenu">
											<a href="<?php echo $subpage_url;?>"><?php echo $sm->name;?></a>
										</li>
								<?php }
								}?>
								</ul>
							</span>
						<?php } else { // other items
						$sub_menu = $this->model_page->get_child_menu($pm->id, $cur_lang);
						if($sub_menu!=false) {
						$subpage_url = '';?>
                        <span  style="height:28px">
							<ul style="list-style-type: none;">
								<?php foreach($sub_menu->result() as $sm) {
								if($sm->url!='') {
									if($sm->url=='#')
									$subpage_url = $sm->url;
									else
									$subpage_url = site_url($sm->url);
								}
								else $subpage_url = site_url($sm->menu_slug);?>
								<li style="background-position: initial initial; background-repeat: initial initial;line-height: 27px;height: 28px; border-top-left-radius: 0px;border-top-right-radius: 0px;" class="submenu">
									<a href="<?php echo $subpage_url;?>"><?php echo $sm->name;?></a>
								</li>
								<?php }?>
                        	</ul>
						</span>
						<?php }
						}?>
                    </li>
					<?php }
					}?>
                </ul>
                
				<?php echo modules::run('home/_render_search_form');?>