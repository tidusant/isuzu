
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo base_url();?>administration/"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/system_users/index');?>"><?php echo $this->lang->line('member_title');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('member_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('member_title').' - '.$this->lang->line('member_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/system_users/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_member');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<table class="table table-hover">
<thead>
	<tr>
		<th class="span1 text-center">#</th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_name');?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_email');?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_level');?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_lastlogin');?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_priority');?></th>
		<th class="hidden-phone"><?php echo $this->lang->line('member_active');?></th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php foreach ($members as $member) { ?>
	<tr>
		<td class="span1 text-center"><?php echo $member->id; ?></td>
		<td>
		<?php if($member->group_id==1) {
			echo $member->su_fullname;
		} else {?>
			<a href="<?php echo site_url($this->uri->segment(1).'/system_users/form/member_id/'.$member->id);?>"><?php echo $member->su_fullname;?></a>
		<?php }?>
		</td>
		<td class="hidden-phone"><?php echo $member->su_email;?></td>
		<td class="hidden-phone"><?php echo $this->admin_model_member->get_level_name($member->group_id);?></td>
		<td class="hidden-phone"><?php if($member->lastlogin!='') echo format_date($member->lastlogin); else echo 'None';?></td>
		<td class="hidden-phone"><?php echo $member->display_order;?></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($member->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span3 text-center">
		<div class="btn-group">
		
		<?php if($member->group_id != 1) { ?>
		<a href="<?php echo site_url($this->uri->segment(1).'/system_users/form/member_id/' . $member->id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		
		<a href="<?php echo site_url($this->uri->segment(1).'/system_users/delete/member_id/' . $member->id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('member_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		<?php } else {
			
			if($this->session->userdata('user_level') == 1 && $member->group_id == 1)
			{
				echo '<a href="'.site_url($this->uri->segment(1).'/system_users/form/member_id/' . $member->id).'" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>';
			}
		}?>
		
		</div>
		</td>
	</tr>
	<?php } ?>
</tbody>
</table>

<?php if ($this->admin_model_member->page_links) { ?>
<div class="pagination pagination-centered">
	<ul>
		<?php echo $this->admin_model_member->page_links; ?>
	</ul>
</div>
<?php }?>