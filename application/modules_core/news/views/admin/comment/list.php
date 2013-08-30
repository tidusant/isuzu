
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('comment_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('memetype_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('comment_module').' - '.$this->lang->line('news_list_title');?></h3>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('comment_author'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('comment_email'); ?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('date_updated'); ?></th>
		<th class="hidden-phone">From IP</th>
		<th class="hidden-phone">Status</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run = 1; foreach ($comments as $cmt) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td><a href="<?php echo site_url($this->uri->segment(1).'/comment/form/cmt_id/'.$cmt->cmt_id);?>" data-toggle="tooltip" title="<?php echo $cmt->cmt_content;?>"><?php echo $cmt->cmt_author;?></a></td>
		<td class="hidden-phone"><?php echo $cmt->cmt_email;?></td>
		<td class="hidden-phone"><?php echo format_date($cmt->cmt_date);?></td>
		<td class="hidden-phone"><?php echo $cmt->cmt_ipaddress;?></td>
		<td class="hidden-phone">
		<?php if($cmt->enable=='1') { ?><a href="<?php echo site_url($this->uri->segment(1).'/comment/unapprove/cmt_id/' . $cmt->cmt_id); ?>" data-toggle="tooltip" title="Unapprove this"><span class="label label-success">Approved!</span></a><?php } else { ?><a href="<?php echo site_url($this->uri->segment(1).'/comment/approve/cmt_id/' . $cmt->cmt_id); ?>" data-toggle="tooltip" title="Approve It Now"><span class="label label-important">Unapproved</span></a><?php } ?>
		</td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/comment/form/cmt_id/' . $cmt->cmt_id); ?>" data-toggle="tooltip" title="View" class="btn btn-mini btn-info">View</a>
		<a id="delete_cmt" href="<?php echo site_url($this->uri->segment(1).'/comment/delete/cmt_id/' . $cmt->cmt_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger">Delete</a>
		</div>
		</td>
	</tr>
	<?php $run += 1;} ?>
</tbody>
</table>