<?php

// upload configuration
$config['admin_mediastore_real_url'] = base_url().'uploads/assets/media/';
$config['admin_mediastore_url'] = base_url().'uploads/assets/thumbnail/';
$config['image_upload_path'] = APPPATH . '../uploads/assets/media/';
$config['image_upload_path_thumb'] = APPPATH . '../uploads/assets/thumbnail/';
$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|JPG|JPEG|PNG|GIF|PDF';
$config['maxium_size'] = '500000';
$config['max_width'] = '1024';
$config['max_height'] = '768';
$config['adsimage_upload_path'] = FCPATH.'uploads/ads/';
$config['ads_allowed_types'] = 'jpg|png|gif|swf|JPG|PNG|GIF|SWF';
// image size
$config['admin_thumbnail_media_list'] = array('width' => 160, 'height' => 120); // global
$config['admin_global_image_size'] = array('width' => 67, 'height' => 80);

$config['original_image_upload_path'] =  $_SERVER['DOCUMENT_ROOT'].'/demo/uploads/assets/media/';

$config['upload_relative_path'] = './demo/';
// frontend image size
///#home
$config['home_promotion_size_w'] = '101';
$config['home_promotion_size_h'] = '85';
$config['home_catalog_size_w'] = '174';
$config['home_catalog_size_h'] = '133';
$config['home_news_size_w'] = '101';
$config['home_news_size_h'] = '85';
$config['home_part_size_w'] = '135';
$config['home_part_size_h'] = '155';

// products
$config['product_index_size_w'] = '411';
$config['product_index_size_h'] = '316';
$config['product_catalog_size_w'] = '270';
$config['product_catalog_size_h'] = '220';
$config['product_detail_size_w'] = '411';
$config['product_detail_size_h'] = '316';

$config['product_gallery_size_w'] = '268';
$config['product_gallery_size_h'] = '201';

// banner
$config['sidebar_banner_max_w'] = '283';

// part
$config['part_list_size_w'] = '263';
$config['part_list_size_h'] = '202';

// news
$config['news_index_promotion_w'] = '257';
$config['news_index_promotion_h'] = '217';
$config['news_index_top_w'] = '257';
$config['news_index_top_h'] = '217';
$config['news_index_record_w'] = '111';
$config['news_index_record_h'] = '94';

$config['image_ratio'] = 6.35;
?>