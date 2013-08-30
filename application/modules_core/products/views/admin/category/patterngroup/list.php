
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/index');?>">Catalog List</a></li>
<li class="active"><a href="">LIST</a></li>       
</ul>

<h3 class="page-header"><?php echo 'Pattern Group - LIST';?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern-group/form');?>" class="btn btn-primary">Add New Group</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone">Group</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($pattern_group->result() as $group) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern-group/form/group_id/' . $group->id); ?>" data-toggle="tooltip" title="Edit"><?php echo $group->group_name;?></a></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern-group/form/group_id/' . $group->id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern-group/delete/group_id/' . $group->id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('client_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1; } ?>
</tbody>
</table>