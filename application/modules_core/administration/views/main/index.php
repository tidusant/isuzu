<?php echo modules::run('administration/_render_breadcum');
echo modules::run('administration/_render_dashboardnav');?>

	<div class="dash-tiles row-fluid">

		<div class="span3">
		<div class="dash-tile dash-tile-ocean clearfix">
		<div class="dash-tile-header">
		<div class="dash-tile-options">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/system_users/index');?>" class="btn" data-toggle="tooltip" title="Manage members"><i class="icon-cog"></i></a>
		</div>
		</div>
		<?php echo $this->lang->line('dashboard_totalmember');?>
		</div>
		<div class="dash-tile-icon"><i class="icon-group"></i></div>
		<div class="dash-tile-text"><?php echo $total_count_member;?></div>
		</div>

		</div>

		<div class="span3">
		<div class="dash-tile dash-tile-flower clearfix">
		<div class="dash-tile-header">
		<div class="dash-tile-options">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/news/index');?>" class="btn" data-toggle="tooltip" title="News Statistics"><i class="icon-bar-chart"></i></a>
		</div>
		</div>
		<?php echo $this->lang->line('dashboard_totalnews');?>
		</div>
		<div class="dash-tile-icon"><i class="icon-tags"></i></div>
		<div class="dash-tile-text"><?php echo $total_count_news;?></div>
		</div>

		</div>

		<div class="span3">
		<div class="dash-tile dash-tile-oil clearfix">
		<div class="dash-tile-header">
		<div class="dash-tile-options">
		<div class="btn-group">
		<a href="<?php echo site_url($this->uri->segment(1).'/comment');?>" class="btn" data-toggle="tooltip" title="Manage Comment"><i class="icon-share"></i></a>
		</div>
		</div>
		<?php echo $this->lang->line('dashboard_totalcomment');?>
		</div>
		<div class="dash-tile-icon"><i class="icon-globe"></i></div>
		<div class="dash-tile-text"><?php echo $total_count_comment;?></div>
		</div>
		</div>

		<div class="span3">
		<div class="dash-tile dash-tile-balloon clearfix">
		<div class="dash-tile-header">
		<div class="dash-tile-options">
		<a href="<?php echo site_url($this->uri->segment(1).'/products/index');?>" class="btn" data-toggle="tooltip" title="Manage products"><i class="icon-cog"></i></a>
		</div>
		<?php echo $this->lang->line('dashboard_totalproduct');?>
		</div>
		<div class="dash-tile-icon"><i class="icon-rss"></i></div>
		<div class="dash-tile-text"><?php echo $total_count_products;?></div>
		</div>
		</div>

	</div>