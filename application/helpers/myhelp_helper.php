<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//////chuyen tieng viet co dau thanh tieng anh khong dau va them cac ki tu vao khoang trong
if ( ! function_exists('eng2vn'))
{
	function eng2vn($str, $kitu)
	{
		$str=trim($str);
        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
        "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề",
        "ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ",
        "ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        //"đ",
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă",
        "Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ");
        //"Đ");
        $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a",
        "a","a","a","a","a","a",
        "e","e","e","e","e","e","e","e","e","e","e",
        "i","i","i","i","i",
        "o","o","o","o","o","o","o","o","o","o","o","o",
        "o","o","o","o","o",
        "u","u","u","u","u","u","u","u","u","u","u",
        "y","y","y","y","y",
        //"d",
        "A","A","A","A","A","A","A","A","A","A","A","A",
        "A","A","A","A","A",
        "E","E","E","E","E","E","E","E","E","E","E",
        "I","I","I","I","I",
        "O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
        "U","U","U","U","U","U","U","U","U","U","U",
        "Y","Y","Y","Y","Y");
        //"D");
        $str= str_replace($marTViet,$marKoDau,$str);
		return strtolower(str_replace(" ",$kitu,$str));
	}	
}

//Chuyển tiếng việt sang không dấu
if(!function_exists('vie2eng'))
{
	function vie2eng($st, $sign='dash')
	{
		$vietChar 	= 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|ó|ò|ỏ|õ|ọ|ơ|ớ|ờ|ở|ỡ|ợ|ô|ố|ồ|ổ|ỗ|ộ|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|í|ì|ỉ|ĩ|ị|ý|ỳ|ỷ|ỹ|ỵ|đ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|Ó|Ò|Ỏ|Õ|Ọ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|Í|Ì|Ỉ|Ĩ|Ị|Ý|Ỳ|Ỷ|Ỹ|Ỵ|Đ';
		$engChar	= 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|e|e|e|e|e|e|e|e|e|e|e|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|u|u|u|u|u|u|u|u|u|u|u|i|i|i|i|i|y|y|y|y|y|d|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|E|E|E|E|E|E|E|E|E|E|E|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|U|U|U|U|U|U|U|U|U|U|U|I|I|I|I|I|Y|Y|Y|Y|Y|D';
		$arrVietChar 	= explode("|", $vietChar);
		$arrEngChar		= explode("|", $engChar);
		return url_title( strtolower( str_replace($arrVietChar, $arrEngChar, $st) ) , $sign);
	}
}

function loc_dau($str){
	$unicode = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		'd'=>'đ',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'i'=>'í|ì|ỉ|ĩ|ị',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'D'=>'Đ',
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	);
	
   foreach($unicode as $nonUnicode=>$uni){
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
   }
	return $str;
}

function filter_strip_tags_content($text, $tags = '', $invert = FALSE) {
	
	preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
	$tags = array_unique($tags[1]);
   
	if(is_array($tags) AND count($tags) > 0) {
		if($invert == FALSE) {
		  return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		else {
		  return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
		}
	}
	elseif($invert == FALSE) {
		return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
	}
	return $text;
	
}

function selectbox_tinhthanh()
{
	echo '<option value="An Giang">An Giang</option>
<option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
<option value="Bắc Giang">Bắc Giang</option>
<option value="Bắc Kạn">Bắc Kạn</option>
<option value="Bạc Liêu">Bạc Liêu</option>
<option value="Bắc Ninh">Bắc Ninh</option>
<option value="Bến Tre">Bến Tre</option>
<option value="Bình Định">Bình Định</option>
<option value="Bình Dương">Bình Dương</option>
<option value="Bình Phước">Bình Phước</option>
<option value="Bình Thuận">Bình Thuận</option>
<option value="Cà Mau">Cà Mau</option>
<option value="Cao Bằng">Cao Bằng</option>
<option value="Đắk Lắk">Đắk Lắk</option>
<option value="Đắk Nông">Đắk Nông</option>
<option value="Điện Biên">Điện Biên</option>
<option value="Đồng Nai">Đồng Nai</option>
<option value="Đồng Tháp">Đồng Tháp</option>
<option value="Gia Lai">Gia Lai</option>
<option value="Hà Giang">Hà Giang</option>
<option value="Hà Nam">Hà Nam</option>
<option value="Hà Tĩnh">Hà Tĩnh</option>
<option value="Hải Dương">Hải Dương</option>
<option value="Hậu Giang">Hậu Giang</option>
<option value="Hòa Bình">Hòa Bình</option>
<option value="Hưng Yên">Hưng Yên</option>
<option value="Khánh Hòa">Khánh Hòa</option>
<option value="Kiên Giang">Kiên Giang</option>
<option value="Kon Tum">Kon Tum</option>
<option value="Lai Châu">Lai Châu</option>
<option value="Lâm Đồng">Lâm Đồng</option>
<option value="Lạng Sơn">Lạng Sơn</option>
<option value="Lào Cai">Lào Cai</option>
<option value="Long An">Long An</option>
<option value="Nam Định">Nam Định</option>
<option value="Nghệ An">Nghệ An</option>
<option value="Ninh Bình">Ninh Bình</option>
<option value="Ninh Thuận">Ninh Thuận</option>
<option value="Phú Thọ">Phú Thọ</option>
<option value="Quảng Bình">Quảng Bình</option>
<option value="Quảng Nam">Quảng Nam</option>
<option value="Quảng Ngãi">Quảng Ngãi</option>
<option value="Quảng Ninh">Quảng Ninh</option>
<option value="Quảng Trị">Quảng Trị</option>
<option value="Sóc Trăng">Sóc Trăng</option>
<option value="Sơn La">Sơn La</option>
<option value="Tây Ninh">Tây Ninh</option>
<option value="Thái Bình">Thái Bình</option>
<option value="Thái Nguyên">Thái Nguyên</option>
<option value="Thanh Hóa">Thanh Hóa</option>
<option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
<option value="Tiền Giang">Tiền Giang</option>
<option value="Trà Vinh">Trà Vinh</option>
<option value="Tuyên Quang">Tuyên Quang</option>
<option value="Vĩnh Long">Vĩnh Long</option>
<option value="Vĩnh Phúc">Vĩnh Phúc</option>
<option value="Yên Bái">Yên Bái</option>
<option value="Phú Yên">Phú Yên</option>
<option value="Cần Thơ">Cần Thơ</option>
<option value="Đà Nẵng">Đà Nẵng</option>
<option value="Hải Phòng">Hải Phòng</option>
<option value="Hà Nội">Hà Nội</option>
<option value="TP HCM" selected>TP HCM</option>';
}

function link_to_gmap($address) {
	
	$add_return = '';
	$address = explode(" ", $address);
	$add_return = implode("+", $address);
	
	$map_code = 'https://www.google.com/maps?f=q&source=s_q&hl=en&authuser=0&q='.$add_return.'&aq=&vps=6&jsv=460f&sll=10.749773,106.653643&sspn=0.009845,0.013797&vpsrc=0&g='.$add_return.'&ie=UTF8&oi=georefine&ct=clnk&cd=2&geocode=Fe8lpAAdcMxbBg&split=0';
	
	return $map_code;
	
}

/// get and integrate images to lightbox
function create_img_lightbox_code($img_array, $caption_array)
{
	if($img_array!='' && is_array($img_array))
	{
		$js_img = '[';
		$original_img_array = explode('|', $img_array['original']);
		$thumb_img_array = explode('|', $img_array['thumb']);
		$caption_array = explode('|', $caption_array);
		foreach($original_img_array as $index=>$eachimg) {
			$js_img .= '{ URL: "'.$eachimg.'", type: "image", caption: "'.$caption_array[$index].'", options: { thumbnail: "'.$thumb_img_array[$index].'", skin: "dark"} },';
		}
		if($js_img!='') return substr($js_img, 0, -1) .']'; // remove last comma		
		
	} else return '';
}

function load_lightbox_custom_code($img_array, $caption_array, $class_name='') {
	// intializing code
	$place_class = ($class_name!='')? $class_name:'inline_gallery';
	$js_script = '
	<script type="text/javascript">
        $(document).ready(function () {
        	
			$(".'.$place_class.'").click(function () {
				var dataObj = '.create_img_lightbox_code($img_array, $caption_array).';
        	var lightboxStartIndex = 0;
        	for(var i = 0 ; i < dataObj.length; i++)
				{
					
					if(dataObj[i].caption.toLowerCase().indexOf($("img",this).attr("alt").toLowerCase()) >= 0)
					{

						lightboxStartIndex = i;
						break;
					}
				}
				$.iLightBox(dataObj, 
				{ startFrom: lightboxStartIndex, skin: "light", path: "horizontal", maxScale: 1.3, overlay: { opacity: 0.4 }, styles: { nextOffsetX: 75, nextOpacity: 0.55, prevOffsetX: 75, prevOpacity: 0.55 }, thumbnails: { normalOpacity: 0.6, activeOpacity: 1} }); return !1 
			});
		});
    </script>
	';
	return $js_script;
}

function load_lightbox_script() {
	$intialize_script = array();
	$intialize_script['css'] = '<link href="'.base_url().'assets/style/lightbox/ilightbox.css" rel="stylesheet" />';
	$intialize_script['js'] = '
		<script src="'.base_url().'assets/js/jquery.mousewheel.js"></script>
		<script src="'.base_url().'assets/js/ilightbox.js"></script>
	';
	return $intialize_script;
}

function process_input($input)
{
	return trim(htmlspecialchars($input));
}

function process_output($input)
{
	$output = "";
	$content = str_replace("[P]","[p]",$input);// get pure value - to lower case
	$content = str_replace("[/P]","[/p]",$content);// get pure value - to lower case
	
	/// regex
	preg_match_all("|\[p\](.*)\[/p\]|U", $content, $output);
	
	foreach($output[1] as $index=>$ct) {
		$content = str_replace($output[0][$index], "", $content);
		
	}
	
	return $content;
}

function news_short_desc_output($content, $char_open="[", $char_close="]")
{
	$content = strip_tags($content); // get pure value
	$start = strpos($content, $char_open);
	$end = strpos($content, $char_close);
	$content_length = ($end-1) - $start;
	return substr($content, $start+1, (($end-1) - $start));
}

function product_short_desc_output($content, $char_open="[p]", $char_close="[/p]")
{
	$output = "";
	$content = str_replace("[P]",$char_open,strip_tags($content));// get pure value - to lower case
	$content = str_replace("[/P]",$char_close,$content);// get pure value - to lower case
	/// regex
	preg_match_all("|\[p\](.*)\[/p\]|U", $content, $output);
	$content_return = "";
	
	$limiter = 0;
	foreach($output[1] as $ct) {
		$content_return[$limiter] = $output[1][$limiter];
		$limiter += 1;
		if($limiter==2) break;
	}
	
	return $content_return;
}

function sharethis_loading_script()
{
	return '
		<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5204b61d3af04003"></script>
	';
}

function sharethis_widget($page_title='', $page_url='') {
	
	$the_url = ''; $the_title = '';
	if($page_url!='') $the_url = 'addthis:url="'.$page_url.'"';
	if($page_title!='') $the_title = 'addthis:title="'.$page_title.'"';
	
	return '
		<div class="addthis_toolbox addthis_default_style" '.$the_url.' '.$the_title.'>
		<a class="addthis_button_compact"><img src="'.base_url().'assets/images/more_like.png" alt="" /></a>
		<a class="addthis_counter addthis_bubble_style"></a>
		</div>
	';
}

function sharethis_widget_toolbar_detail() {
	return '
		<div class="addthis_toolbox addthis_default_style addthis_20x20_style">
		<a class="addthis_button_facebook">
			<img src="'. base_url().'assets/images/icon_fb.png" alt="Facebook" />
		</a>
		<a class="addthis_button_compact">
			<img src="'.base_url().'assets/images/icon_share.png" alt="Share" />
		</a>
		<a class="addthis_button_print">
			<img src="'.base_url().'assets/images/icon_print.png" alt="Print" />
		</a>
		</div>
	';
}

function sharethis_widget_detail() {
	return '
		<div class="addthis_toolbox addthis_default_style addthis_20x20_style">
		<a class="addthis_button_compact"><img src="'.base_url().'assets/images/more_like.png" alt="" /></a>
		<a class="addthis_counter addthis_bubble_style"></a>
		</div>
	';
}

function facebook_ref_page($page_url='')
{
	if($page_url!='')
		return '
		<div class="fb-like" data-href="'.$page_url.'" data-width="69" data-layout="button_count" data-show-faces="false" data-send="false"></div>
	';
	else return '
		<div class="fb-like" data-href="http://developers.facebook.com/docs/reference/plugins/like" data-width="69" data-layout="button_count" data-show-faces="false" data-send="false"></div>
	';
}

function facebook_loading_script()
{
	return '
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, \'script\', \'facebook-jssdk\'));</script>
	';
}

function do_delete_folder_n_file($full_folder_relative_path="") {
	// delete folder & all files
	$CI = & get_instance();
	if($full_folder_relative_path!="") {
		$CI->load->helper('file');
		$thumbnail_folder = str_replace("/media/", "/thumbnail/", $full_folder_relative_path);
		delete_files($full_folder_relative_path."/", TRUE, 1); // delete root folder
		delete_files($thumbnail_folder."/", TRUE, 2); // delete thumbnail folder
	}
}

function embed_video_player($youtube_link='', $width=268, $height=201)
{
	if($youtube_link!='')
		return '<iframe title="YouTube video player" class="youtube-player" type="text/html" 
width="'.$width.'" height="'.$height.'" src="'.$youtube_link.'"
frameborder="0" allowFullScreen></iframe>';

}

?>