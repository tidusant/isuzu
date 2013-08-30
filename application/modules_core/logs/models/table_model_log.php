<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Table_model_log extends CI_Model {

	public function get_table_headers() {

		$order_by = uri_assoc('order_by');

		$order = (uri_assoc('order')) == 'asc' ? 'desc' : 'asc';

		$headers = array(
			'log_username'	=>	anchor('logs/gotthat/mlogs/index/order_by/log_username/order/' . $order, $this->lang->line('log_username')),
			'log_module'	=>	anchor('logs/gotthat/mlogs/index/order_by/log_module/order/' . $order, $this->lang->line('log_module')),
			'log_action'			=>	anchor('logs/gotthat/mlogs/index/order_by/log_action/order/' . $order, $this->lang->line('log_action')),
			'date_updated'	=> anchor('logs/gotthat/mlogs/index/order_by/date_updated/order/' . $order, $this->lang->line('date_updated'))
		);

		return $headers;

	}
}
