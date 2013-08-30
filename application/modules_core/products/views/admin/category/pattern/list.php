
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/index');?>">Catalog List</a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern/browse/'.$this->uri->segment(5));?>">Catalog Pattern</a></li>
<li class="active"><a href="">LIST</a></li>       
</ul>

<h3 class="page-header"><?php echo 'Catalog Pattern - LIST';?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern/form/cate_id/'.$this->uri->segment(5));?>" class="btn btn-primary">Add New Pattern</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone">Group</th>
		<th class="hidden-phone">Catalog</th>
		<th class="hidden-phone">Pattern Name</th>
		<th class="hidden-phone text-center">Unit</th>
		<th class="hidden-phone text-center">Order</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($pattern as $pat) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><?php echo $this->admin_model_pattern->get_group_name($pat->pattern_group_id);?></td>
		<td class="hidden-phone"><?php echo $this->admin_model_pattern->get_category_name($pat->product_cate_pc_id);?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern/form/pat_id/'.$pat->id);?>"><?php echo $pat->pattern_name;?></a></td>
		<td class="hidden-phone text-center"><?php echo $pat->pattern_unit;?></td>
		<td class="hidden-phone text-center"><?php echo $pat->display_order;?></td>
		
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern/form/pat_id/' . $pat->id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern/delete/pat_id/' . $pat->id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('client_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1; } ?>
</tbody>
</table>