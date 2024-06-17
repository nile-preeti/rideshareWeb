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







|	$route['default_controller']      = 'welcome';







|







| This route indicates which controller class should be loaded if the







| URI contains no data. In the above example, the "welcome" class







| would be loaded.







|







|	$route['404_override']      = 'errors/page_missing';







|







| This route will tell the Router which controller/method to use if those







| provided in the URL cannot be matched to a valid route.







|







|	$route['translate_uri_dashes']      = FALSE;







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







$route['default_controller'] 			     = 'admin';

$route['404_override'] 					     = '';

$route['translate_uri_dashes'] 			     = FALSE;

/* web route */

$route['riders'] ='web/riders';

$route['drivers'] ='web/drivers';

$route['about-us'] ='web/about_us';

$route['faq'] ='web/faq';

$route['contact-us'] ='web/contact_us';
$route['app-contact-us'] ='web/app_contact_us';

$route['privacy-policy'] ='web/privacy_policy';
$route['app-privacy-policy'] ='web/app_privacy_policy';
$route['app-about-us'] ='web/app_about_us';
$route['app-insurence'] ='web/app_insurence';
$route['pre-authorized-policy'] ='web/pre_authorized_policy';


$route['term-condition'] ='web/term_condition';
$route['app-terms-condition'] ='web/app_term_condition';
$route['app-booking-charges'] ='web/app_booking_charges';
$route['our-support'] ='web/our_support';
//$route['app-our-support'] ='web/app_our_support';
$route['insurence'] ='web/insurence';












/* Api Route */















$route['login']['post']						= "api/auth/login";



$route['register']['post']					= "api/auth/register";



$route['resend']['post']					= "api/auth/resend";



$route['verification-success']['post']		= "api/auth/verification_success";



$route['forgot-password']['post']			= "api/auth/forgot_password";



$route['getSubcategory']['post']					= "api/auth/getSubcategory";
$route['get-vehicle-year']['post']					= "api/auth/get_vehicle_year";



$route['getCategory']['get']					= "api/auth/getCategory";
/*Ios API  for all category and subcategory*/
$route['getAllCategory']['get']					= "api/auth/getAllCategory";
/*Ios API  for all category and subcategory end*/

$route['getIntro_video']['get']					= "api/auth/get_introvideo";

$route['get_vehicle_type_sheet']['get']	       = "api/auth/get_vehicle_type_sheet";



$route['getVehicleType']['post']			= "api/auth/getVehicleType";



$route['nearby']['get']						= "api/user/nearby";
$route['logout']['post']						= "api/user/logout";



$route['addRide']['post']					= "api/user/addRide";



$route['give_feedback']['post']				= "api/user/give_feedback";

$route['rider_feedback']['post']			= "api/driver/give_feedbackForRider";

$route['driver_location']['post']			= "api/driver/driver_location";



$route['getDistance']['post']				= "api/user/getDistance";



$route['postRideToDriver']['post']			= "api/user/postRideToDriver";
$route['nearestuser']['post']			= "api/user/nearest_user";


$route['uploadDocument']['post']			= "api/user/uploadDocument";



$route['rides']['get']						= "api/user/rides";
$route['get_ride_summary']['get']			= "api/driver/get_ride_summary";

$route['getBankDetails']['get']						= "api/driver/getBankDetails";

$route['earn']['get']						= "api/user/earn";

$route['earnios']['get']						= "api/user/earnios";

$route['app-version-check']['post']			= "api/auth/check_app_version";
$route['app-version-update']['post']		= "api/auth/update_app_version";

$route['profile']['post']					= "api/user/profile";



$route['change_password']['post']			= "api/user/change_password";



$route['update_profile_of_user']['post']	= "api/user/update_profile_of_user";



$route['update_vehicle_detail']['post']		= "api/driver/update_vehicle_detail";



$route['add_vehicle_detail']['post']		= "api/driver/add_vehicle_detail";



$route['update_vehicle_status']['post']		= "api/driver/update_vehicle_status";



$route['get_vehicle_detail']['get']			= "api/driver/get_vehicle_detail";



$route['upload_profile_pic']['post']		= "api/user/upload_profile_pic";


$route['driverCurrentLocation']['post']		= "api/driver/driverCurrentLocation";



$route['get_profile']['get']				= "api/user/get_profile";



$route['get_count_cancelled_ride']['get']	= "api/user/get_count_cancelled_ride";



$route['get_ride_status']['post']			= "api/user/get_ride_status";

$route['upload_document']['post']			= "api/user/upload_document";
$route['rideTime']['post']			= "api/user/rideTime";



$route['accept_ride']['post']				= "api/driver/acceptRide";



$route['update_driver_status']['post']		= "api/driver/update_driver_status";

$route['delete_vehicle_category']['post']		= "api/auth/delete_vehicle_category";



$route['change_ride_status']['post']		= "api/driver/change_ride_status";



$route['audio_capture']['post']				= "api/driver/audio_capture";



$route['update_lat_long']['post']			= "api/driver/update_lat_long";



$route['add_service']['post']				= "api/driver/add_service";

$route['vehicle-category']['post']				= "api/auth/get_vehicle_category";
$route['map-box']['post']				= "api/auth/MapBOxDistanceMatrix";



$route['get_last_ride']['get']				= "api/driver/get_last_ride";




$route['set_destination_location']['post']	= "api/driver/set_destination_location";

$route['add_payment']['post']	= "api/StripePayment/add_payment";

$route['payment_as_recieved']['post']	= "api/driver/payment_as_recieved";



/* payment api*/



$route['add_customer']['post']	= "api/StripePayment/add_customer";



$route['get_added_vehicle_services']['get']	= "api/driver/added_vehicle_services";



$route['payment']['post']	= "api/StripePayment/payment";




$route['card_list']['get']	= "api/StripePayment/card_list";

$route['paymentgatwaykey']['get']	= "api/Auth/getstripekey";

$route['getDistanceValue']['get']	= "api/Auth/get_distance_value";

$route['delete_card']['post']	= "api/StripePayment/delete_card";



$route['make_default']['post']	= "api/StripePayment/make_default";



$route['add_account']['post']	= "api/StripePayment/add_account";

$route['pay_tip_amount']['post']	= "api/StripePayment/pay_tip_amoount";



$route['payment_history']['get']	= "api/user/payment";



$route['get_driver_status']['get']	= "api/user/get_driver_status";
$route['get_check_document_expiry']['get']	= "api/user/check_document_expiry";
$route['updateloginlogout']['post']	= "api/user/updateloginlogout";
$route['checkdevicetoken']['post']	= "api/user/checkdevicetoken";

$route['get_address_detail']['get']	= "api/auth/getAddressDetail";

$route['get_documentidentity_get']['get'] = "api/auth/get_documentidentity";
$route['get_driver_login_time']['get']	= "api/auth/get_driver_login_time";
$route['get_question_category']['get']	= "api/Driver/get_question_category";
$route['get_question_answer']['get']     ="api/Driver/get_question_answer";
$route['save_answer']['post']     ="api/Driver/save_answer";
$route['get_approval_document_status']['get']     ="api/Driver/approval_document_status";
$route['delete_account_old']['get']     ="api/Driver/deleteAccount"; //Permanent_delete 
$route['delete_account']['get']     ="api/Driver/inactive_account"; //permanent Inactive account

/* Crone job url */



$route['get_expiry_card']['get']	= "api/auth/get_card_expiry_date";

$route['send_notification_to_user']['get']	= "api/auth/send_notification_to_user";

$route['send_notification_to_driver']['get']	= "api/auth/send_notification_to_driver";

$route['cron_job_for_changing_ride_status']['get']	= "api/auth/cron_job_for_changing_ride_status";

/* Per day */

$route['send_notification_to_driver_car_expiry']['get']	= "api/auth/send_notification_to_driver_car_expiry";

$route['get_driver_license_expiry']['get']	= "api/auth/get_driver_license_expiry";

$route['get_driver_car_expiry']['get']	= "api/auth/get_driver_car_expiry";

$route['get_driver_insurance_expiry']['get']	= "api/auth/get_driver_insurance_expiry";
$route['get_document_expiry_driver']['get']	= "api/auth/getDucumentExpiredDriver";

$route['version']['post']	= "api/auth/version";







/* 3:35 subah 07-12-2020 */




$route['driver/login'] ='driver/login';
$route['driver_login'] ='driver/login/checkuser';
$route['driver/rides'] ='driver/login/getrides';
$route['driver/payout'] ='driver/login/payout';
$route['driver/profile'] ='driver/login/profile';
$route['driver/update-profile/(:any)'] ='driver/login/update_driver/$1';
$route['driver/update_driver_profile/(:any)']= 'driver/login/update_driver/$1';
$route['driver/settings'] ='driver/login/settings';

$route['driver/logout'] ='driver/login/logout';

$route['rider/login'] ='rider/login';
$route['rider_login'] ='rider/login/checkuser';
$route['rider/rides'] ='rider/login/getrides';
$route['rider/profile'] ='rider/login/profile';
$route['rider/update-profile/(:any)'] ='rider/login/edit_profile/$1';
$route['login/update_user'] ='rider/login/update_user';

$route['rider/settings'] ='rider/login/settings';
$route['rider/logout'] ='rider/login/logout';




/* Admin */



$route['testmail'] ='admin/mailtest/send_email';
$route['testmailadmin'] ='admin/admin/send_mails';
$route['email'] ='admin/admin/test_mail';


























