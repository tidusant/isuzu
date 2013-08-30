
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/parts/index');?>"><?php echo $this->lang->line('part_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('product_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('part_module').' - '.$this->lang->line('product_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/parts/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_part');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('product_category'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('part_name'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('part_image'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('date_updated'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('part_priority'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('part_active'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($parts as $part) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><?php echo $part->category_name;?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/parts/form/pa_id/'.$part->part_id);?>" data-toggle="tooltip" title="<?php echo strip_tags($part->part_desc);?>"><?php echo $part->part_name;?></a></td>
		<td class="hidden-phone"><?php
		if($part->part_link_image!=''){
			echo '<img src="'.$part->part_link_image.'" alt="'.$part->part_name.'" width="160" height="120" />';
		}?></td>
		<td class="hidden-phone"><?php echo format_date($part->updated_on);?></td>
		<td class="hidden-phone"><?php echo $part->display_order;?></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($part->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/parts/form/pa_id/' . $part->part_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/parts/delete/pa_id/' . $part->part_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('product_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1; } ?>
</tbody>
</table>