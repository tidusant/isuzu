<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "fuck";
$route['404_override'] = '';

$route[':any'] = "fuck";

/*
$route['gioi-thieu'] = 'page/index';

$route['lien-he'] = 'contact/index';

$route['dai-ly'] = 'partner/index';

$route['faqs'] = 'faq/index';

$route['tin-tuc'] = 'news/index';

$route['tin-tuc/binh-luan'] = 'news/comment';

$route['tin-tuc/:any'] = 'news/detail/$1';

$route['san-pham'] = 'products/index';

$route['san-pham/loai/:any'] = 'products/cate/$1';

$route['san-pham/:any'] = 'products/detail/$1';

$route['phu-tung'] = 'products/parts/index';

$route['phu-tung/loai/:any'] = 'products/parts/cate/$1';

$route['phu-tung/:any'] = 'products/parts/detail/$1';

$route['dang-ki-lai-thu'] = 'pages/testdrive/index';
*/


/* End of file routes.php */
/* Location: ./application/config/routes.php */