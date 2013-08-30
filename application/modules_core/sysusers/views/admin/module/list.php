<?php $this->load->view('administration/header');?>

	<div id="page-content">
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo base_url();?>administration/"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url('sysusers/gotthat/mmodule/');?>"><?php echo $this->lang->line('group_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('member_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo 'Module - '.$this->lang->line('member_list_title');?></h3>

<a href="<?php echo site_url('sysusers/gotthat/mmodule/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_module');?></a>

<br />
<?php $this->load->view('administration/system_messages'); ?>
<br />

<table class="table table-hover">
<thead>
	<tr>
		<th class="span1 text-center">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('module_name');?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_active');?></th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php if($module_list!=false) {
		$run = 1;
		foreach($module_list->result() as $ml) { ?>
	<tr>
		<td class="span1 text-center"><?php echo $run; ?></td>
		<td><a href="<?php echo site_url('sysusers/gotthat/mmodule/form/m_id/'.$ml->module_id);?>"><?php echo $ml->module_name;?></a></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($ml->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url('sysusers/gotthat/mmodule/form/m_id/' . $ml->module_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url('sysusers/gotthat/mmodule/delete/m_id/' . $ml->module_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('member_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1;} 
	}?>
</tbody>
</table>

</div>

<?php $this->load->view('administration/footer');?>