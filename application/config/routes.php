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

$route['default_controller'] = "search";
$route['404_override'] = 'search';

$route['seller/(:any)'] = 'user/index/$1';
$route['test/(:num)'] = 'test/index/$1';
$route['deals/(:num)'] = 'deals/index/$1';
$route['admin/deals/(:num)'] = 'admin/deals/index/$1';
$route['how-to-sell'] = 'static_pages/page/about#how-to-sell';
$route['how-to-buy'] = 'static_pages/page/about#how-to-buy';
$route['why-legacy-exchange'] = 'static_pages/page/about#why-legacyxchange';
$route['privacy'] = 'static_pages/page/privacy';
$route['terms-of-service'] = 'static_pages/page/terms';
$route['about'] = 'static_pages/page/about';
$route['rates'] = 'static_pages/page/about#rates';
$route['help'] = 'static_pages/page/help';
$route['how-site-works'] = 'static_pages/page/how_site_works'; 
$route['mark-item'] = 'static_pages/page/mark_item';
$route['faqs'] = 'static_pages/page/faqs';
$route['disclaimers'] = 'static_pages/page/disclaimers';
$route['dealers'] = 'static_pages/page/dealers';
$route['athletes-celebrities-agents'] = 'static_pages/page/athletes_celebrities_agents';
$route['manufacturers'] = 'static_pages/page/manufacturers';
$route['news'] = 'static_pages/page/news';
$route['careers'] = 'static_pages/page/careers';
$route['shopping-cart'] = 'shoppingcart';
$route['listings/product/(:num)'] = 'listings/product/$1';
$route['listings/buynow/(:num)'] = 'listings/buynow/$1';
$route['listings/bid/(:num)'] = 'listings/bid/$1';
$route['listings/^(search)([a-z]+)'] = 'listings/index/$1';
$route['listings/(:any)'] = 'listings/index/$1';
$route['listings/(:any)/(:num)/(:num)'] = 'listings/index/$1/$2/$3';
$route['phpinfo'] = 'phpinfo';


$route['admin/products/(:num)'] = 'admin/products/index/$1';

/* foreach(array_keys($route) as $r){
	echo '"/'.$r,'", ';
} */
/* End of file routes.php */
/* Location: ./application/config/routes.php */