
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo base_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php $this->uri->uri_string();?>"><?php echo $this->lang->line('faq_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('faq_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('faq_module').' - '.$this->lang->line('faq_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/faqs/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_faq');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('faq_question'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('date_updated'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('faq_feature'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('faq_priority'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('faq_active'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i>Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($faqs as $f) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone text-center"><a data-toggle="tooltip" title="<?php echo strip_tags($f->faq_answer);?>" href="<?php echo site_url($this->uri->segment(1).'/faqs/form/f_id/'.$f->faq_id);?>"><?php echo $f->faq_question;?></a></td>
		<td class="hidden-phone text-center"><?php echo format_date($f->updated_on);?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($f->is_feature=='1') echo 'checked="checked"'; else echo '';?> /></td>
		<td class="hidden-phone text-center"><?php echo $f->display_order;?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($f->enable=='1') echo 'checked="checked"'; else echo '';?> /></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/faqs/form/f_id/' . $f->faq_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/faqs/delete/f_id/' . $f->faq_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('faq_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
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