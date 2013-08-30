
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/products/index');?>"><?php echo $this->lang->line('story_title');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('product_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('product_module').' - '.$this->lang->line('product_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/products/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_product');?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo site_url($this->uri->segment(1).'/products/gallery');?>" class="btn btn-primary">Product Image Storage</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('product_category'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('product_name'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('product_image'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('product_ishot'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('date_updated'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('product_priority'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('product_active'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($products as $product) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><?php echo $product->category_name;?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/products/form/p_id/'.$product->product_id);?>"><?php echo $product->product_name;?></a></td>
		<td class="hidden-phone"><?php
		if($product->product_image_link!=''){
			echo '<img src="'.$product->product_image_link.'" alt="'.$product->product_name.'" width="160" height="120" />';
		}?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($product->ishot=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="hidden-phone"><?php echo format_date($product->updated_on);?></td>
		<td class="hidden-phone"><?php echo $product->display_order;?></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($product->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/products/form/p_id/' . $product->product_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/products/delete/p_id/' . $product->product_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('client_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1; } ?>
</tbody>
</table>