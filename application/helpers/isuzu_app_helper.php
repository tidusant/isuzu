<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function application_title() {

    $CI =& get_instance();

    return ($CI->admin_setting_data->setting('application_title')) ? $CI->admin_setting_data->setting('application_title') : $CI->lang->line('educookie');

}

?>
