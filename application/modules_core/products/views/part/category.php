			<div class="left_subpage"><!--Begin: left subpage-->
            
            	<div class="product_list_page"><!--Begin: product list-->
                	<div class="titel_w_line">
                    	<p><a href="<?php echo site_url('phu-tung');?>"><?php echo $this->lang->line('title_part_page');?></a> <span><?php echo $category_name;?></span> </p>
                    </div>
					
                    
                    <div class="content_part_list">
						<?php echo $part_content;?>
                    </div>
	    			<?php echo $this->lang->line('VAT_note_Parts');?>
                </div><!--End: product list-->
                
            </div><!--End: left subpage-->
			
			<!-- right column -->
			<div class="right_subpage" id="sidebar_product"><!--Begin: right subpage-->
				<div class="right_product_list">
                	<div class="title_right_product_list"><?php echo $this->lang->line('sidebar_product_catalog');?></div>
					<!-- sidebar -->
					<?php echo modules::run('products/_render_other_page_sidebar', $cur_lang);?>
				</div>
				<!-- right banner -->
				<?php echo modules::run('products/_render_right_banner');?>
			</div>