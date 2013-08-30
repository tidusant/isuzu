
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php $this->uri->uri_string();?>"><?php echo $this->lang->line('weblink_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('news_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('weblink_module').' - '.$this->lang->line('news_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/web-links/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_new');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_title'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('web_links'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_priority'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_active'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($weblinks as $nw) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone text-center"><a href="<?php echo site_url($this->uri->segment(1).'/web-links/form/weblink_id/'.$nw->id);?>"><?php echo $nw->title;?></a></td>
		<td class="hidden-phone text-center"><?php echo auto_link($nw->weblink);?></td>
		<td class="hidden-phone text-center"><?php echo $nw->display_order;?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($nw->active=='1') echo 'checked="checked"'; else echo '';?> /></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/web-links/form/weblink_id/' . $nw->id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/web-links/delete/weblink_id/' . $nw->id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('news_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>

