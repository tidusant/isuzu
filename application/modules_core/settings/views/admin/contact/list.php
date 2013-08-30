
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/settings/index');?>">Settings</a></li>
<li class="active">Contacts</li>       
</ul>

<h3 class="page-header">Contact List</h3>

<br />
<?php $this->load->view('administration/system_messages'); ?>
<br />

<a href="<?php echo site_url($this->uri->segment(1).'/form_management/contacter/export');?>" class="btn btn-inverse">Export CSV</a>
<br /><br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_fullname'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_email'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_phone'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_subject'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('reg_form_date'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i>Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($contacts as $item) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone text-center"><a data-toggle="tooltip" title="<?php echo $item->address;?>" href="<?php echo site_url($this->uri->segment(1).'/form_management/contacter/view/contact_id/'.$item->contact_id);?>"><?php echo $item->fullname;?></a></td>
		<td class="hidden-phone text-center"><a href="mailto:<?php echo $item->email;?>"><?php echo $item->email;?></a></td>
		<td class="hidden-phone text-center"><?php echo $item->phone;?></td>
		<td class="hidden-phone text-center"><?php echo $item->subject;?></td>
		<td class="hidden-phone text-center"><?php echo format_date($item->date_received);?></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/form_management/contacter/view/contact_id/' . $item->contact_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-info">View</a>
		<a href="<?php echo site_url($this->uri->segment(1).'/form_management/contacter/delete/contact_id/' . $item->contact_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('regdrive_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>