
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>">List</a></li>
<li class="active">Page Tree</li>       
</ul>

<h3 class="page-header">Page tree Management</h3>

<a href="<?php echo site_url($this->uri->segment(1).'/pagetree/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_pagetree');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone text-center">Name</th>
		<th class="hidden-phone text-center">Last Updated</th>
		<th class="hidden-phone text-center">Order</th>
		<th class="hidden-phone text-center">Active</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run = 1; foreach ($pagetrees as $pt) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone text-center"><a href="<?php echo site_url($this->uri->segment(1).'/pagetree/form/pt_id/' . $pt->pt_id); ?>"><?php echo $pt->pt_name;?></a></td>
		<td class="hidden-phone text-center"><?php echo format_date($pt->updated_on);?></td>
		<td class="hidden-phone text-center"><?php echo $pt->display_order;?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($pt->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/pagetree/form/pt_id/' . $pt->pt_id); ?>" data-toggle="tooltip" title="Edit <?php echo $pt->pt_name;?>" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/pagetree/delete/pt_id/' . $pt->pt_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning');?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>
