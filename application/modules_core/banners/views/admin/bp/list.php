
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="">Banner Position</a></li>
<li class="active"><a href="">List</a></li>       
</ul>

<h3 class="page-header">Banners Position</h3>

<a href="<?php echo site_url($this->uri->segment(1).'/banners/position/form')?>" class="btn btn-primary">Add New Position</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-hover">
<thead>
	<tr>
		<th class="span1 text-center">#</th>
		<th class="hidden-phone">Position</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php foreach ($bannerposition as $bp) { ?>
	<tr>
		<td class="span1 text-center"><?php echo $bp->position_id; ?></td>
		<td class="hidden-phone"><?php echo $bp->pos_name;?></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'banners/position/form/bp_id/' . $bp->position_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'banners/position/delete/bp_id/' . $bp->position_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('banner_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php } ?>
</tbody>
</table>