
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>">List</a></li>
<li class="active">Pages</li>       
</ul>

<h3 class="page-header">Pages Management</h3>

<a href="<?php echo site_url($this->uri->segment(1).'/pages/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_page');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone">Page Name</th>
		<th class="hidden-phone text-center">Last Updated</th>
		<th class="hidden-phone text-center">Layout</th>
		<th class="hidden-phone text-center">Order</th>
		<th class="hidden-phone text-center">Active</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run = 1; foreach ($pages->result() as $page) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/pages/form/page_id/' . $page->page_id); ?>"><?php echo $page->page_title;?></a></td>
		<td class="hidden-phone text-center"><?php echo format_date($page->updated_on);?></td>
		<td class="hidden-phone text-center"><?php if($page->layout=='1') echo 'Sidebar'; else echo 'Full';?></td>
		<td class="hidden-phone text-center"><?php echo $page->display_order;?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($page->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/pages/form/page_id/' . $page->page_id); ?>" data-toggle="tooltip" title="Edit <?php echo $page->page_title;?>" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/pages/delete/page_id/' . $page->page_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning');?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>