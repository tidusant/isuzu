
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>">List</a></li>
<li class="active">Menu</li>
</ul>

<h3 class="page-header">Menu Management</h3>

<a href="<?php echo site_url($this->uri->segment(1).'/menu/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_menu');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone">Root Menu</th>
		<th class="hidden-phone">Menu Name</th>
		<th class="hidden-phone">Title</th>
		<th class="hidden-phone text-center">Last Updated</th>
		<th class="hidden-phone text-center">Order</th>
		<th class="hidden-phone text-center">Active</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run = 1; foreach ($menus as $mn) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><?php if($mn->seft_id <> 0) echo $this->admin_model_menu->get_parents_name($mn->seft_id); else echo 'N/A';?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/menu/form/menu_id/' . $mn->id); ?>"><?php echo $mn->name;?></a></td>
		<td class="hidden-phone"><?php echo $mn->title;?></td>
		<td class="hidden-phone text-center"><?php echo format_date($mn->updated_on);?></td>
		<td class="hidden-phone text-center"><?php echo $mn->display_order;?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($mn->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/menu/form/menu_id/' . $mn->id); ?>" data-toggle="tooltip" title="Edit <?php echo $mn->name;?>" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/menu/delete/menu_id/' . $mn->id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning');?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>
