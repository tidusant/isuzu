<?php
function create_sub_folder($path_to_dir, $folder_name, $parent_folder='')
{
	if(!is_dir($path_to_dir.$folder_name))
	{
		mkdir($path_to_dir.$parent_folder.$folder_name, 0777); // to upload files
	//	chmod($path_to_dir.$parent_folder.$folder_name, 0777);
	}
	
	// make thumbnail folder
	$thumb_dir = str_replace('media','thumbnail',$path_to_dir);
	if(!is_dir($thumb_dir.$folder_name))
	{
		mkdir($thumb_dir.$parent_folder.$folder_name, 0777); // to upload files
	//	chmod($path_to_dir.$parent_folder.$folder_name, 0777);
	}
}

function renam_sub_folder($old_path, $new_path)
{
	rename($old_path, $new_path);
}

function del_dir_tree($dir) {
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
	  (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

function process_string_foldername($foldername)
{
	$vietChar 	= 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|ó|ò|ỏ|õ|ọ|ơ|ớ|ờ|ở|ỡ|ợ|ô|ố|ồ|ổ|ỗ|ộ|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|í|ì|ỉ|ĩ|ị|ý|ỳ|ỷ|ỹ|ỵ|đ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|Ó|Ò|Ỏ|Õ|Ọ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|Í|Ì|Ỉ|Ĩ|Ị|Ý|Ỳ|Ỷ|Ỹ|Ỵ|Đ';
	$engChar	= 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|e|e|e|e|e|e|e|e|e|e|e|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|u|u|u|u|u|u|u|u|u|u|u|i|i|i|i|i|y|y|y|y|y|d|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|E|E|E|E|E|E|E|E|E|E|E|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|U|U|U|U|U|U|U|U|U|U|U|I|I|I|I|I|Y|Y|Y|Y|Y|D';
		$arrVietChar 	= explode("|", $vietChar);
		$arrEngChar		= explode("|", $engChar);
		return url_title( strtolower( str_replace($arrVietChar, $arrEngChar, $foldername) ) , 'underscore');
}
?>