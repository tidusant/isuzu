<?php if (validation_errors()) { ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Error!</strong> <?php echo validation_errors(); ?>
</div>
<?php } ?>

<?php if ($this->session->flashdata('success_save')) { ?>

<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Success!</strong> <?php echo $this->lang->line('this_item_has_been_saved'); ?>
</div>

<?php } ?>

<?php if ($this->session->flashdata('success_delete')) { ?>
<div class="alert">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Warning!</strong> <?php echo $this->lang->line('this_item_has_been_deleted'); ?>.
</div>
<?php } ?>

<?php if ($this->session->flashdata('custom_warning')) { ?>
<div class="alert">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Warning!</strong> <?php echo $this->session->flashdata('custom_warning'); ?>
</div>
<?php } ?>

<?php if ($this->session->flashdata('custom_error')) { ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Error!</strong> <?php echo $this->session->flashdata('custom_error'); ?>
</div>
<?php } ?>

<?php if ($this->session->flashdata('custom_success')) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Success!</strong> <?php echo $this->session->flashdata('custom_success'); ?>
</div>
<?php } ?>

<?php if (isset($static_error) and $static_error) { ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Error!</strong> <?php echo $static_error; ?>
</div>
<?php } ?>