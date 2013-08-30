				<div class="link_foot">
					<?php if($footer_weblinks!=false) {?>
                	<span><?php echo $this->lang->line('footer_weblinks');?></span>
                    <select name="links" id="links" onchange="if(this.options[this.selectedIndex].value != ''){window.open(this.options[this.selectedIndex].value, '_blank'); window.focus();}">
						<option value="/">-</option>
						<?php foreach($footer_weblinks->result() as $link) {?>
                        <option value="<?php echo $link->weblink;?>"><?php echo $link->title;?></option>
						<?php }?>
                    </select>
					<?php }?>
                </div>