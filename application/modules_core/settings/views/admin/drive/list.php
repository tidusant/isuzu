

	
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('setting_list_drive');?></a></li>
<li class="active">Drive Register</li>       
</ul>

<h3 class="page-header">Customer List</h3>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<a href="<?php echo site_url($this->uri->segment(1).'/form_management/test_drive_reg/export');?>" class="btn btn-inverse">Export CSV</a>
<br /><br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_fullname'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_gender'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_email'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_phone'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_modelitem'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_date'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i>Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($regforms as $item) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone text-center"><a data-toggle="tooltip" title="<?php echo $item->address;?>" href="<?php echo site_url($this->uri->segment(1).'/form_management/test_drive_reg/view/reg_id/'.$item->id);?>"><?php echo $item->full_name;?></a></td>
		<td class="hidden-phone text-center"><?php if($item->gender=='0') echo 'Female'; elseif($item->gender=='1') echo 'Male'; else echo 'Unknown';?></td>
		<td class="hidden-phone text-center"><?php echo $item->form_email;?></td>
		<td class="hidden-phone text-center"><?php echo $item->phone;?></td>
		<td class="hidden-phone text-center"><?php echo $item->item_registered;?></td>
		<td class="hidden-phone text-center"><?php echo format_date($item->date_received);?></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/form_management/test_drive_reg/view/reg_id/' . $item->id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-info">View</a>
		<a href="<?php echo site_url($this->uri->segment(1).'/form_management/test_drive_reg/delete/reg_id/' . $item->id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('regdrive_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>