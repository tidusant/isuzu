<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mproduct extends MX_Controller {
	
	private $_push = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model(array('admin_model_product', 'admin_model_category'));
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('product');
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_product();// add or edit
				break;
			case 'delete':
				$content_render = $this->_delete_product();// delete
				break;
			case 'browse':
				$content_render = $this->_browse_product();
				break;
			case 'load_tech_info':
				print($this->_load_pattern_tech_elements());die();
				break;
			case 'gallery':
				switch($this->uri->segment(4)) {
					case 'form':
						$content_render = $this->_manage_product_gallery();
						break;
					case 'delete':
						$content_render = $this->_delete_product_gallery();
						break;
					default: $content_render = $this->_list_product_gallery();
				}
				break;
			default:
				$content_render = $this->_list_product(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_product() {
		$this->redir->set_last_index();
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		

		$this->_push['products'] = $this->admin_model_product->get($params);

		return $this->load->view('admin/product/list', $this->_push);
	}
	
	private function _manage_product() {
		
		$this->load->helper('isuzu_js');
		$this->load->model('admin_model_productgallery');
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$product_gallery_type = '';$product_slide_id=0; $product_interior_id=0; $product_exterior_id=0; $product_safety_id=0; $product_pallete_id=0;
		
		if(uri_assoc('p_id')) {
			$product_gallery_type = $this->admin_model_product->get_product_gallery_type(intval(uri_assoc('p_id')));
			if($product_gallery_type!='') {
				if(strstr($product_gallery_type, '|')) {
					$product_gallery_type = explode('|', $product_gallery_type);
					foreach($product_gallery_type as $pgt) {
						$temparr = explode(':',$pgt);
						if($temparr[0]=='1') $product_slide_id = $temparr[1];
						elseif($temparr[0]=='2') $product_interior_id = $temparr[1];
						elseif($temparr[0]=='3') $product_exterior_id = $temparr[1];
						elseif($temparr[0]=='4') $product_safety_id = $temparr[1];
						elseif($temparr[0]=='5') $product_pallete_id = $temparr[1];
					}
				} else {
					$temparr = explode(':', $product_gallery_type);
					if($temparr[0]=='1') $product_slide_id = $temparr[1];
					elseif($temparr[0]=='2') $product_interior_id = $temparr[1];
					elseif($temparr[0]=='3') $product_exterior_id = $temparr[1];
					elseif($temparr[0]=='4') $product_safety_id = $temparr[1];
					elseif($temparr[0]=='5') $product_pallete_id = $temparr[1];
				}
				$product_gallery_type = '';
				unset($temparr);
			}
		}
		
		// load techinfo list
		$append_js = $this->_load_customize_js();
		$this->_push['extended_js'] = load_extended_js('pro_name', $append_js); // generate slug
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		$this->_push['category_list'] = $this->admin_model_category->get_list_categories();
		// other tabs 1: slide, 2: noithat, 3: ngoaithat, 4: an toan, 5: bang mau
		$product_slide_list = $this->admin_model_productgallery->get_list_gallery_type(1);
		$product_interior_list = $this->admin_model_productgallery->get_list_gallery_type(2);
		$product_exterior_list = $this->admin_model_productgallery->get_list_gallery_type(3);
		$product_safety_list = $this->admin_model_productgallery->get_list_gallery_type(4);
		$product_pallete_list = $this->admin_model_productgallery->get_list_gallery_type(5);
		// slide banner 1
		$this->_push['slide_image_product'] = $this->_render_select_slide_images($product_slide_list, $product_slide_id);
		// noithat 2
		$this->_push['interior_image_product'] = $this->_render_select_interior_images($product_interior_list, $product_interior_id);
		// ngoaithat 3
		$this->_push['exterior_image_product'] = $this->_render_select_exterior_images($product_exterior_list, $product_exterior_id);
		// antoan 4
		$this->_push['safety_image_product'] = $this->_render_select_safety_images($product_safety_list, $product_safety_id);
		// bangmau 5
		$this->_push['pallete_image_product'] = $this->_render_select_pallete_images($product_pallete_list, $product_pallete_id);
		
		$p_id = uri_assoc('p_id');

		if ($this->admin_model_product->validate()) {

			$this->admin_model_product->save();

			$p_id = ($p_id) ? $p_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('p_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('product_module'), $log_action_type, $this->lang->line('product_name').': '.$this->admin_model_product->form_value('product_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/products/index');

		}

		else {
		
			if (!$_POST AND $p_id) $this->admin_model_product->prep_validation($p_id);
			else $this->_push['action_type'] = $this->lang->line('adding_action');
			
			// get lang
			$this->_push['productobj_en'] = $this->admin_model_product->get_product_lang($p_id);
			
			return $this->load->view('admin/product/form', $this->_push);

		}

	}

	private function _delete_product() {

		$p_id = uri_assoc('p_id');

		if ($p_id) {

			$this->admin_model_product->delete($p_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('product_module'), 'Deleted', $this->lang->line('product_name').': '.$this->admin_model_product->get_product_name($p_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/products/index');
	}
	
	private function _load_pattern_tech_elements() {
		
		// get cate id
		$catalog_id = trim(addslashes(htmlspecialchars($this->input->post('catalog_id', TRUE))));
		$html = '';
		$query = $this->admin_model_category->get_pattern_tech_by_cate($catalog_id);
		$product_id = intval(uri_assoc('p_id'));
		$query_pattern_value = $this->admin_model_category->get_pattern_tech_value($product_id);
		$pattern_value = ''; $pattern_value_en = '';
		
		if($query!=false) {
			foreach($query->result() as $pattern) {
				if($query_pattern_value!=false) {
					foreach($query_pattern_value->result() as $pv) {
						if($pv->pattern_tech_id==$pattern->id){
							$pattern_value = $pv->tech_value;
							$pattern_value_en = $this->admin_model_product->get_pattern_tech_value_lang($pv->id);
						}
					}
				}
				$html .= '<div class="control-group">
				<label class="control-label" for="pattern_'.$pattern->id.'">'.$pattern->pattern_name.':</label>';
				$html .= '<div class="controls">
				<input type="hidden" name="pattern_tech_id[]" value="'.$pattern->id.'" />';
				$html .= '<input type="text" name="pattern_tech_value_'.$pattern->id.'" id="pattern_'.$pattern->id.'" value="'.$pattern_value.'" class="input-large" />';
				$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EN: ';
				// english
				$html .= '<input type="text" name="pattern_tech_value_en_'.$pattern->id.'" id="pattern_en_'.$pattern->id.'" value="'.$pattern_value_en.'" class="input-large" />';
				
				$html .= '</div>
				</div>';
				
			}
		}
		
		if($html!='') echo $html;
		else echo '<p style="text-align:center;color:red;">Please define pattern structure at Catalog module first!</p>';
		
	}
	
	private function _load_customize_js()
	{
		$addon_js = '';
		if(uri_assoc('p_id')) { // edit
			$catalog_id = $this->admin_model_product->return_catalog_id(intval(uri_assoc('p_id')));
			$addon_js = '
			var dataString = \'catalog_id='.$catalog_id.'\';
			$.ajax({
				type: "POST",
				url: "'.site_url($this->uri->segment(1)).'/products/load_tech_info/p_id/'.uri_assoc('p_id').'",
				data: dataString,
				cache: false,
				success: function(html) {
					$("#pattern_techinfo").html(html);
					$(".select-chosen").chosen();
				}
			});
			';
		} else {
			$addon_js .= 'jQuery("#product_category").change(function() {
				var id=$(this).val();
				var dataString = \'catalog_id=\'+ id;
				jQuery.ajax({
					type: "POST",
					url: "'.site_url($this->uri->segment(1)).'/products/load_tech_info",
					data: dataString,
					cache: false,
					success: function(html) {
						jQuery("#pattern_techinfo").html(html);
						jQuery(".select-chosen").chosen();
					}
				});
			});';
		}
		
		return $addon_js;
	}
	
	private function _browse_product()
	{
		// browse to belong which categories
		$browsetype = $this->uri->segment(5);
		$cate_id = $this->uri->segment(6);
		
		$this->load->helper('text');
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		
		if($browsetype=='cate' && $cate_id!==NULL) {
			$params['joins']['product_cate'] = array('product_cate.pc_id = products.product_cate_pc_id', 'left');
			$params['where']['product_cate.pc_id'] = $cate_id;
		}
		
		
		$params['order_by'] = 'products.updated_on DESC'; // newest
		
		if ($show == 'active') {
			
			$params['where']['products.active'] = 1;
			
		}
		
		elseif ($show == 'inactive') {
			
			$params['where']['products.active'] = 0;
			
		}

		$this->_push['products'] = $this->admin_model_product->get($params);

		return $this->load->view('admin/product/list', $this->_push);
		
	}
	
	/*######################### PRODUCT IMAGES ##############################*/
	private function _render_select_slide_images($product_gallery_list, $slide_id=0)
	{
		$this->_push['slide_images_list'] = $product_gallery_list;
		$this->_push['selected_slide_id'] = $slide_id;
		return $this->load->view('admin/plugins/product_slide_image', $this->_push);
	}
	
	// noi that
	private function _render_select_interior_images($product_gallery_list, $interior_id=0)
	{
		$this->_push['interior_images_list'] = $product_gallery_list;
		$this->_push['selected_interior_id'] = $interior_id;
		return $this->load->view('admin/plugins/product_interior_image', $this->_push);
	}
	
	// ngoai that
	private function _render_select_exterior_images($product_gallery_list, $exterior_id=0)
	{
		$this->_push['exterior_images_list'] = $product_gallery_list;
		$this->_push['selected_exterior_id'] = $exterior_id;
		return $this->load->view('admin/plugins/product_exterior_image', $this->_push);
	}
	
	// an toan
	private function _render_select_safety_images($product_gallery_list, $safety_id=0)
	{
		$this->_push['safety_images_list'] = $product_gallery_list;
		$this->_push['selected_safety_id'] = $safety_id;
		return $this->load->view('admin/plugins/product_safety_image', $this->_push);
	}
	
	// bang mau
	private function _render_select_pallete_images($product_gallery_list, $pallete_id=0)
	{
		$this->_push['pallete_images_list'] = $product_gallery_list;
		$this->_push['selected_pallete_id'] = $pallete_id;
		return $this->load->view('admin/plugins/product_pallete_image', $this->_push);
	}
	
	/*######################### PRODUCT GALLERY #############################*/
	
	private function _list_product_gallery() {
		
		$this->load->model('admin_model_productgallery');
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['galleries'] = $this->admin_model_productgallery->get($params);

		return $this->load->view('admin/product/gallery/list', $this->_push);
	}
	
	private function _manage_product_gallery()
	{
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->load->model('admin_model_productgallery');
		
		$this->_push['product_gallery_type_list'] = $this->admin_model_productgallery->get_list_product_gallery_type();
		
		$pgal_id = uri_assoc('pgal_id');

		if ($this->admin_model_productgallery->validate()) {

			$this->admin_model_productgallery->save();
			
			redirect($this->uri->segment(1).'/products/gallery/index');

		}

		else {

			if (!$_POST AND $pgal_id) {

				$this->admin_model_productgallery->prep_validation($pgal_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
				
			}
			
			return $this->load->view('admin/product/gallery/form', $this->_push);

		}
	}
	
	private function _delete_product_gallery() {
		
		$pgal_id = uri_assoc('pgal_id');
		
		if($pgal_id) {
			$this->load->model('admin_model_productgallery');
			
			$folder_relative_path = str_replace(base_url(), $this->config->item('upload_relative_path'), $this->admin_model_productgallery->get_productgallery_foldername($pgal_id));
			do_delete_folder_n_file($folder_relative_path);
			
			$this->admin_model_productgallery->delete($pgal_id);
		}
		
		$this->redir->redirect($this->uri->segment(1).'/products/gallery/index');
	}
	
	/* post handler */
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {
			redirect($this->session->userdata('last_index'));

		}

	}
}