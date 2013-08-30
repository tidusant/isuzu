
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php $this->uri->uri_string();?>"><?php echo $this->lang->line('news_module');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('news_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('news_module').' - '.$this->lang->line('news_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/news/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_btn_new');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-striped table-hover" id="list-datatables">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_title'); ?></th>
		<th class="hidden-phone text-center">Pic</td>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_promotion'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_reg_form'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('date_updated'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_comment'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_priority'); ?></th>
		<th class="hidden-phone text-center"><?php echo $this->lang->line('news_active'); ?></th>
		<th class="span2 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php $run=1; foreach ($news as $nw) { ?>
	<tr>
		<td class="span1"><?php echo $run; ?></td>
		<td class="hidden-phone text-center"><a href="<?php echo site_url($this->uri->segment(1).'/news/form/news_id/'.$nw->event_id);?>"><?php echo $nw->event_title;?></a></td>
		<td class="hidden-phone text-center"><?php
		if($nw->event_link_image!=NULL){
			echo '<img src="'.$nw->event_link_image.'" alt="'.$nw->event_title.'" width="160" height="120" />';
		}?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($nw->event_promotion=='1') echo 'checked="checked"'; else echo '';?> /></td>
		<td class="hidden-phone text-center"><?php if($nw->event_reg_form=='1') echo 'Yes'; else echo 'No';?></td>
		<td class="hidden-phone text-center"><?php echo format_date($nw->updated_on);?></td>
		<td class="hidden-phone text-center"><?php if($nw->comment_allow=='1') echo 'Yes'; else echo 'No';?></td>
		<td class="hidden-phone text-center"><?php echo $nw->display_order;?></td>
		<td class="hidden-phone text-center"><input disabled type="checkbox" <?php if($nw->active=='1') echo 'checked="checked"'; else echo '';?> /></td>
		<td class="span2 text-center">
		<div class="btn-group">
		<?php if($nw->comment_allow=='1') {?>
		<a href="<?php echo site_url($this->uri->segment(1).'/comment/browse/news_id/'.$nw->event_id);?>" data-toggle="tooltip" title="View Comment" class="btn btn-mini btn-info">Comments</a>
		<?php }?>
		<a href="<?php echo site_url($this->uri->segment(1).'/news/form/news_id/' . $nw->event_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/news/delete/news_id/' . $nw->event_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('news_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
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

