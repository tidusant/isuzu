
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="javascript:void(0)">Logs</a></li>
<li class="active"><a href="">List</a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('log_title');?></h3>

<table id="example-datatables" class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="span1 hidden-phone">#</th>
<th class="span1"><?php echo $this->lang->line('date_updated'); ?></th>
<th><i class="icon-user"></i> <?php echo $this->lang->line('log_username'); ?></th>
<th class="hidden-phone hidden-tablet"><?php echo $this->lang->line('log_module'); ?></th>
<th class="hidden-phone hidden-tablet"><?php echo $this->lang->line('log_description');?></th>
<th><i class="icon-bolt"></i> <?php echo $this->lang->line('log_action'); ?></th>
</tr>
</thead>
<tbody>

<?php foreach ($logs as $log) { ?>
<tr>
	<td class="span1 hidden-phone"><?php echo $log->Id;?></td>
	<td class="span1"><?php echo format_date($log->DateUpdated);?></td>
	<td><?php echo $this->admin_model_member->get_username($log->User);?></td>
	<td class="hidden-phone hidden-tablet"><?php echo $log->Controller;?></td>
	<td class="hidden-phone hidden-tablet"><?php echo strip_tags($log->Description);?></td>
	<td><span class="label label-info"><?php echo $log->Action;?></span></td>
</tr>
<?php } ?>
</tbody>
</table>

<?php if ($this->admin_model_log->page_links) { ?>
<div class="pagination pagination-centered">
	<ul>
		<?php echo $this->admin_model_log->page_links; ?>
	</ul>
</div>
<?php }?>