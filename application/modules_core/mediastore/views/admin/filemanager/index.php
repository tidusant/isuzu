<style type="text/css">
	a.thumbnail img {
		width: 160px;
		height: 120px;
	}
</style>

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/filemanager/index');?>">Media Store</a></li>
<li class="active"><a href="">File Management</a></li>
</ul>

<h3 class="page-header">Image List</h3>

<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/attachmedia')?>" class="btn btn-primary">Add New Image</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />


<ul class="nav nav-tabs" id="directory-tabs">
	<li class="active"><a href="#directory-tabs-news">News</a></li>
	<li><a href="#directory-tabs-products">Products</a></li>
	<li><a href="#directory-tabs-categories">Categories</a></li>
	<li><a href="#directory-tabs-pages">Pages</a></li>
	<li><a href="#directory-tabs-partners">Dealers</a></li>
	<li><a href="#directory-tabs-banners">Banners</a></li>
	<li><a href="#directory-tabs-accessories">Accessories</a></li>
	<li><a href="#directory-tabs-rearbody">Rearbody</a></li>
	<li><a href="#directory-tabs-parts">Parts</a></li>
</ul>

<div class="tab-content">
		<div class="tab-pane active" id="directory-tabs-news">
			<?php if($mediastores_dir_news!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_news->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;
							$thumb_img = image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>
							
							<a href="<?php echo $original_img;?>" class="thumbnail" data-options="thumbnail: '<?php echo $thumb_img;?>'"><img src="<?php 
							echo $thumb_img;?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
			<?php }?>
			</ul>
			<?php } else {?>
			<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
		</div>
		
		<div class="tab-pane" id="directory-tabs-products">
			<?php if($mediastores_dir_products!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
				<?php foreach($mediastores_dir_products->result() as $ms) {?>
					<li>
						<div class="thumbnails-options">
						<div class="btn-group">
						<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
						</div>
						</div>
						<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							
						<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
						<p style="text-align:center;"><?php echo $ms->media_name;?></p>
					</li>
				<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
		</div>
		
		<div class="tab-pane" id="directory-tabs-categories">
			<?php if($mediastores_dir_categories!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_categories->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
					<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
		</div>
		
		<div class="tab-pane" id="directory-tabs-pages">
			<?php if($mediastores_dir_pages!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_pages->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
					<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
			
		</div>
		
		<div class="tab-pane" id="directory-tabs-partners">
			<?php if($mediastores_dir_partners!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_partners->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
					<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
			
		</div>
		
		<div class="tab-pane" id="directory-tabs-banners">
			<?php if($mediastores_dir_banners!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_banners->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
					<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
		</div>
		
		<!-- accessories -->
		<div class="tab-pane" id="directory-tabs-accessories">
			<?php if($mediastores_dir_accessories!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_accessories->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
					<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
		</div>
		
		<!-- rearbody -->
		<div class="tab-pane" id="directory-tabs-rearbody">
			<?php if($mediastores_dir_rearbody!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_rearbody->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
					<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
		</div>
		
		<!-- parts -->
		<div class="tab-pane" id="directory-tabs-parts">
			<?php if($mediastores_dir_parts!=false) {?>
			<ul class="thumbnails" data-toggle="gallery-options">
					<?php foreach($mediastores_dir_parts->result() as $ms) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/delete_upload_media/file/'.$ms->media_filename);?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false"><button class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<?php $original_img = $this->config->item('admin_mediastore_real_url').$ms->media_directory.$ms->media_filename;?>
							<a href="<?php echo $original_img;?>" class="thumbnail"><img src="<?php 
							echo image_thumb($this->config->item('original_image_upload_path').$ms->media_directory.$ms->media_filename, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;"><?php echo $ms->media_name;?></p>
						</li>
					<?php }?>
			</ul>
			<?php } else {?>
				<div style="font-weight:bold;">None image uploaded !</div>
			<?php }?>
			
		</div>
		
</div>