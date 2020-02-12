<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

$route['default_controller'] = 'welcome';
/**
 * Authenticator routing
 */
$route['login'] = 'authenticator/login';
$route['logout'] = 'authenticator/logout';
$route['register'] = 'authenticator/register';
$route['start'] = 'start_campaign/start';

/**
 * Petition processing
 * Facebook
 * Normal
 */

$route['(:num)/(:any)'] = 'petition/detail/$1/$2';
$route['petition-edit-content/(:num)'] = "petition/petition_edit_content/$1";
$route['change-target-count/(:num)'] = "petition/change_target_count/$1";
$route['close/(:num)'] = "petition/close/$1";
$route['publish/(:num)'] = "petition/publish/$1";
$route['delete/(:num)'] = "petition/delete/$1";
$route['success/(:num)'] = "petition/success/$1";
$route['insert-institutions/(:num)'] = "petition/insert_institution/$1";
$route['delete-institutions/(:num)/(:num)'] = "petition/delete_institution/$1/$2";
$route["share/(:num)"] = "petition/share/$1";
$route["edit-petition/(:num)"] = "petition/edit_petition/$1";

$route['sign/(:num)'] = "sign/index/$1";
$route["load-campaign-image"] = "petition/load_campaign_image";
/**
 * Profile 
 * edit,change password,edit profile image, social media updating
 */
$route['profile/(:num)'] = "profile/index/$1";
$route['profile/change-password'] = "profile/change_password";
$route['profile/edit-profile'] = "profile/edit_profile";
$route['profile/edit-profile-image'] = "profile/edit_profile_image";
$route['profile/update-social-media-accounts'] = "profile/update_social_media_accounts";

/**
 * Ajax
 */





/**Pages 
 * about,faq,
*/
$route["about"] = "pages/about";
$route["contact"] = "pages/contact";
$route["frequently-asked-questions"] = "pages/faq";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



