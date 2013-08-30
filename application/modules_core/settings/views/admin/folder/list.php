
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>">List</a></li>
<li class="active">Folder</li>       
</ul>

<h3 class="page-header">Folder Management</h3>

<a href="<?php echo site_url($this->uri->segment(1).'/settings/folder/form')?>" class="btn btn-primary">Create New Folder</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone">Parent</th>
		<th class="hidden-phone">Folder Name</th>
		<th class="hidden-phone text-center">Date Created</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run = 1; foreach ($folders as $folder) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><?php echo $folder->folder_parent;?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/settings/folder/form/folder_id/' . $folder->folder_id); ?>"><?php echo $folder->folder_name;?></a></td>
		<td class="hidden-phone text-center"><?php echo format_date($folder->created_on);?></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/settings/folder/form/folder_id/' . $folder->folder_id); ?>" data-toggle="tooltip" title="Edit <?php echo $folder->folder_name;?>" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/settings/folder/delete/folder_id/' . $folder->folder_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning');?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>