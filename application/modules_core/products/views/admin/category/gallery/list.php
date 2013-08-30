
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/index');?>">Catalog List</a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/gallery/index');?>">Catalog Gallery</a></li>
<li class="active"><a href="">LIST</a></li>       
</ul>

<h3 class="page-header"><?php echo 'Catalog Gallery - LIST';?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/catalog/gallery/form');?>" class="btn btn-primary">Add New Gallery</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone">Name</th>
		<th class="hidden-phone text-center">Type</th>
		<th class="hidden-phone text-center">Created On</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($galleries as $gl) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/filemanager/categal/addimg/'.$gl->id)?>" data-toggle="tooltip" title="Browse <?php echo $gl->cate_gallery_name;?>"><?php echo $gl->cate_gallery_name;?></a></td>
		<td class="hidden-phone text-center"><?php echo $gl->cate_type;?></td>
		<td class="hidden-phone text-center"><?php echo format_date($gl->created_on);?></td>
		
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/categal/addimg/'.$gl->id)?>" data-toggle="tooltip" title="Browse <?php echo $gl->cate_gallery_name;?>" class="btn btn-mini btn-warning">Add More Images</a>
		<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/categal/index/'.$gl->id)?>" data-toggle="tooltip" title="Browse <?php echo $gl->cate_gallery_name;?>" class="btn btn-mini btn-warning">View List</a>
		<a href="<?php echo site_url($this->uri->segment(1).'/catalog/gallery/form/cgal_id/' . $gl->id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/catalog/gallery/delete/cgal_id/' . $gl->id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('gallery_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1; } ?>
</tbody>
</table>