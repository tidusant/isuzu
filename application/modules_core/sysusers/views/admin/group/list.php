
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/system_users/groups');?>"><?php echo $this->lang->line('group_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('member_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('member_title').' - '.$this->lang->line('member_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/system_users/groups/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_membergroup');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<table class="table table-hover">
<thead>
	<tr>
		<th class="span1 text-center">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('group_name');?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_active');?></th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php if($admingroups!=false) {
		$run = 1;
		foreach($admingroups as $ag) { ?>
	<tr>
		<td class="span1 text-center"><?php echo $run; ?></td>
		<td><a href="<?php echo site_url($this->uri->segment(1).'/system_users/groups/form/group_id/'.$ag->group_id);?>"><?php echo $ag->group_name;?></a></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($ag->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/system_users/groups/form/group_id/' . $ag->group_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/system_users/groups/delete/group_id/' . $ag->group_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('member_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run += 1;} 
	}?>
</tbody>
</table>