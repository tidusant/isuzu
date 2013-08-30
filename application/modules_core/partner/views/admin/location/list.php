
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('partner_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('partner_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('partner_module').' - '.$this->lang->line('partner_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/partners/location/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_partner');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('partner_location'); ?></th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run = 1; foreach ($location as $lc) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td><a href="<?php echo site_url($this->uri->segment(1).'/partners/location/form/l_id/'.$lc->ll_id);?>" data-toggle="tooltip" title="<?php echo $lc->location;?>"><?php echo $lc->location;?></a></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/partners/location/form/l_id/' . $lc->ll_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-info">Edit</a>
		<a id="delete_cmt" href="<?php echo site_url($this->uri->segment(1).'/partners/location/delete/l_id/' . $lc->ll_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger">Delete</a>
		</div>
		</td>
	</tr>
	<?php $run += 1;} ?>
</tbody>
</table>
