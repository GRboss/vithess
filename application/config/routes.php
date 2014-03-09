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

$route['reported/(:any)/(:any)'] = "reported/$1/$2";
$route['reported'] = "reported";
$route['api/get_messages/(:num)/(:num)/(:num)/(:num)'] = "api/get_messages/$1/$2/$3/$4";
$route['api/rate_the_message/(:num)/(:num)/(:num)'] = "api/rate_the_message/$1/$2/$3";
$route['api/create_new_message'] = "api/create_new_message";
$route['api/save_my_settings'] = "api/save_my_settings";
$route['api/get_me_my_settings/(:num)'] = "api/get_me_my_settings/$1";
$route['company/(:any)/(:any)'] = "company/$1/$2";
$route['areas/(:any)/(:any)'] = "areas/$1/$2";
$route['areas/(:any)'] = "areas/$1";
$route['homepage/(:any)/(:any)'] = "homepage/$1/$2";
$route['homepage/(:any)'] = "homepage/$1";
$route['homepage'] = "homepage";
$route['enterprises/(:any)'] = "enterprises/$1";
$route['enterprises'] = "enterprises";
$route['default_controller'] = "landing";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */