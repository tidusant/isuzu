
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('banner_title');?></a></li>
<li class="active"><a href=""><?php echo $this->lang->line('banner_list_title');?></a></li>       
</ul>

<h3 class="page-header"><?php echo $this->lang->line('banner_title').' - '.$this->lang->line('banner_list_title');?></h3>

<a href="<?php echo site_url($this->uri->segment(1).'/banners/form')?>" class="btn btn-primary"><?php echo $this->lang->line('add_banner_btn');?></a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<table class="table table-hover table-striped">
<thead>
	<tr>
		<th class="span1">#</th>
		<th class="hidden-phone">Title</th>
		<th class="hidden-phone">Image</th>
		<th class="hidden-phone">Link</th>
		<th class="hidden-phone">Date Updated</th>
		<th class="hidden-phone">Position</th>
		<th class="hidden-phone">Order</th>
		<th class="hidden-phone">Active</th>
		<th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
	</tr>
</thead>
<tbody>
	<?php foreach ($banners as $banner) { ?>
	<tr>
		<td class="span1"><?php echo $banner->banner_id; ?></td>
		<td class="hidden-phone"><a href="<?php echo site_url($this->uri->segment(1).'/banners/form/banner_id/'.$banner->banner_id);?>"><?php echo $banner->banner_title;?></a></td>
		<td class="hidden-phone"><?php 
			if($banner->banner_link_image!=NULL) {
				echo '<img src="'.$banner->banner_link_image.'" alt="'.$banner->banner_title.'" width="350" height="150" />';
			}
		?></td>
		<td class="hidden-phone"><?php echo auto_link($banner->banner_link);?></td>
		<td class="hidden-phone"><?php echo format_date($banner->updated_on);?></td>
		<td class="hidden-phone"><?php echo $this->admin_model_bannerposition->get_position($banner->position_id);?></td>
		<td class="hidden-phone"><?php echo $banner->display_order;?></td>
		<td class="hidden-phone"><input disabled type="checkbox" <?php if($banner->active=='1') echo 'checked="checked"'; else echo 'checked=""';?> /></td>
		<td class="span3 text-center">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/banners/form/banner_id/' . $banner->banner_id); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/banners/delete/banner_id/' . $banner->banner_id); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger" onclick="javascript:if(!confirm('<?php echo $this->lang->line('banner_delete_warning'); ?>')) return false"><i class="icon-remove"></i></a>
		</div>
		</td>
	</tr>
	<?php } ?>
</tbody>
</table>

<?php if ($this->admin_model_banner->page_links) { ?>
<div class="pagination pagination-centered">
	<ul>
		<?php echo $this->admin_model_banner->page_links; ?>
	</ul>
</div>
<?php }?>