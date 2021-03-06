
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/accessories/index');?>">Accessories</a></li>
<li class="active"><a href=""><?php echo $this->lang->line('product_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('accessory_module').' - '.$this->lang->line('product_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/accessories/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_accessory');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('accessory_name'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('date_updated'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('accessory_feature'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('accessory_priority'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('accessory_active'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($accessories as $acc) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/accessories/form/a_id/'.$acc->acc_id);?>"><?php echo $acc->acc_name;?></a></td>
		<td class="hidden-phone"><?php echo format_date($acc->updated_on);?></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($acc->feature=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="hidden-phone"><?php echo $acc->display_order;?></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($acc->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/accessories/form/a_id/' . $acc->acc_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/accessories/delete/a_id/' . $acc->acc_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('product_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1; } ?>
</tbody>
</table>

<?php /* if ($this->admin_model_story->page_links) { ?>
<div class="pagination pagination-centered">
	<ul>
		<?php echo $this->admin_model_story->page_links; ?>
	</ul>
</div>
<?php } */ ?>