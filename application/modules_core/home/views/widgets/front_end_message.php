	<?php if ($this->session->flashdata('success_comment')) { ?>
		<div class="alert alert-success">
		<?php echo $this->session->flashdata('success_comment'); ?>
		</div>
	<?php } elseif($this->session->flashdata('failure_comment')) {?>
		<div class="alert alert-error">
		<?php echo $this->session->flashdata('failure_comment'); ?>
		</div>
	<?php }
	if (validation_errors()) { ?>
	<div class="alert alert-error">
	<?php echo validation_errors('<div>','</div>'); ?>
	</div>
	<?php } ?>