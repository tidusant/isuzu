<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function load_extended_js($id_element, $append_js='') {

			$js_addon = '
			<script type="text/javascript" src="'.base_url().'assets/admin/js/customscripts.js"></script>
			
			<script type="text/javascript" src="'.base_url().'assets/admin/js/jquery.slugify.js"></script>';
			
			$js_addon .= '
			<script type="text/javascript" charset="utf-8">
				jQuery().ready(function () {
					jQuery(\'.slugify\').slugify(\'#'.$id_element.'\');';
				
			if($append_js!='')
				$js_addon .= $append_js;
			
			$js_addon .= '});
			</script>';
			
			return $js_addon;

	}
	
	function load_tinymce_plugin() {
		$addon_js = '
			<link rel="stylesheet" type="text/css" href="'.base_url().'assets/admin/css/jquery.fancybox-1.3.4.css" media="screen" />
			
			<script type="text/javascript" src="'.base_url().'assets/admin/js/tinymce/tinymce.min.js"></script>
			<script type="text/javascript" src="'.base_url().'assets/admin/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
			<script type="text/javascript" src="'.base_url().'assets/admin/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
			
			<!-- init tinymce -->
			<script type="text/javascript">
			
			tinymce.init({
				selector: "textarea.tinymce",
				theme: "modern",
				width: 680,
				height: 300,
				subfolder:"",
				link_list: [
					{title: \'New page 1\', value: \'http://www.isuzu-vietnam.com\'},
					{title: \'New page 2\', value: \'http://www.isuzu-vietnam.com\'}
				],
				plugins: [
					 "advlist autolink link image lists charmap hr anchor pagebreak",
					 "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
					 "table contextmenu directionality emoticons paste textcolor filemanager"
			   ],
			   image_advtab: true,
			   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
			   toolbar2: "forecolor backcolor | link unlink anchor | image media | print preview code",
			   
				doctype : "<!DOCTYPE html>",
				convert_urls : false,
				valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang],"
				+ "a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
				+ "name|href|target|title|class],strong/b,em/i,strike,u,"
				+ "#p[style],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
				+ "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
				+ "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
				+ "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
				+ "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
				+ "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
				+ "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
				+ "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
				+ "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
				+ "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
				+ "|height|src|*],map[name],area[shape|coords|href|alt|target],bdo,"
				+ "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
				+ "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
				+ "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
				+ "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
				+ "q[cite],samp,select[disabled|multiple|name|size],small,"
				+ "textarea[cols|rows|disabled|name|readonly],tt,var,big",
				
				inline_styles : true,
				verify_html : false
			});

			jQuery(function(){
				jQuery(\'.iframe-btn\').fancybox({
				\'width\'		: 900,
				\'height\'	: 600,
				\'type\'		: \'iframe\',
				\'autoScale\'    	: false
				});
			});
			</script>
		';
		return $addon_js;
	}

?>
