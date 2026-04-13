<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['my-tickets/(:any)'] = 'tickets/detail/view/$1';
$route['rr-frm/(:any)'] = 'tickets/review_rating_form/view/$1'; // Review and Rating Form

$route['customer-complaints/(:any)'] = 'complaints/detail/view_customer/$1';
$route['customer-complaints-dev/(:any)'] = 'complaints/detail/view_customer_dev/$1';
$route['my-complaints/(:any)'] = 'complaints/detail/view/$1';
$route['bahan_mom/(:any)'] = 'mom_plan_bahan/view/$1';

// Fitur Temuan Audit
$route['fdbk-audit/(:any)'] = 'audit/feedback_temuan/view/$1';

// Fitur QnA di Trusmiverse
$route['frm-qna/(:any)'] = 'qna/qna_form/view/$1';
$route['frm-close/(:any)'] = 'qna/qna_form/view_closing/$1';


$route['upload-speech'] = 'SpeechController/upload';
$route['agentic/(:any)'] = 'agentic/main/index/$1';
