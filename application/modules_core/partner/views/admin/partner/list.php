
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php $this->uri->uri_string();?>"><?php echo $this->lang->line('partner_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('partner_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('partner_module').' - '.$this->lang->line('partner_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/partners/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_partner');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('partner_name'); ?></th>
		<th class="hidden-phone text-center">Image</th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('partner_location'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('partner_url'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('date_updated'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('partner_priority'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('partner_active'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($partners as $pn) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone text-center"><a href="<?php echo site_url($this->uri->segment(1).'/partners/form/pa_id/'.$pn->partner_id);?>"><?php echo $pn->partner_name;?></a></td>
		<td class="hidden-phone text-center">
			<?php if($pn->partner_link_image!=''){
				echo '<img src="'.$pn->partner_link_image.'" alt="'.$pn->partner_name.'" width="160" height="120" />';
			}?>
		</td>
		<td class="hidden-phone text-center"><?php echo $this->admin_model_location->get_location_name($pn->partner_location);?></td>
		<td class="hidden-phone text-center"><?php echo $pn->partner_url;?></td>
		<td class="hidden-phone text-center"><?php echo format_date($pn->updated_on);?></td>
		<td class="hidden-phone text-center"><?php echo $pn->display_order;?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($pn->active=='1') echo 'checked="checked"'; else echo '';?> /></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'partners/form/pa_id/' . $pn->partner_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/partners/delete/pa_id/' . $pn->partner_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('partner_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php $run+=1; } ?>
</tbody>
</table>

<?php /* if ($this->admin_model_meme->page_links) { ?>
<div class="pagination pagination-centered">
	<ul>
		<?php echo $this->admin_model_meme->page_links; ?>
	</ul>
</div>
<?php } */ ?>