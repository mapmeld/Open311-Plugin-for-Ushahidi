<?php defined('SYSPATH') or die('No direct script access.');
/**
* Open311 Hook - Load All Events
*
* PHP version 5
* LICENSE: This source file is subject to LGPL license
* that is available through the world-wide-web at the following URI:
* http://www.gnu.org/copyleft/lesser.html
* @author Ushahidi Team <team@ushahidi.com>
* @package Ushahidi - http://source.ushahididev.com
* @module Hello Ushahidi Hook
* @copyright Ushahidi - http://www.ushahidi.com
* @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
*/

class open311 {

// Table Prefix
    protected $table_prefix;

/**
* Registers the main event add method
*/
public function __construct()
{
// Hook into routing
Event::add('system.pre_controller', array($this, 'add'));
// this section is used to test output generated from a report.  The output can then be mapped to Open311 inputs and submitted to Open311 API.

}

/**
* Adds all the events to the main Ushahidi application
*/
public function add()
{
// Event::add('ushahidi_action.report_verify', array($this, '_push_report'));
Event::add('ushahidi_action.report_add', array($this, '_push_report'));


Event::add('ushahidi_action.main_sidebar', array($this, 'embed_poweredby'));
}

/**
* Add a small button saying this Ushahidi instance is powered by Open311
* Or "Open311 Enabled"
*/
public function embed_poweredby()
{
  $view = View::factory('open311_powered');
  $view->render(TRUE);
}

/**
* Push a newly added report to the open311 system
*/
public function _push_report()
{
  // This report variable is an object that has all the data you need.
  $report = Event::$data;
  
  //seeking values from Ushahidi
  $media_url = var_dump($report->media); //$report->media exists;
  $phone = ''; //$report['phone'];
  
  // match Ushahidi category number to a name
  $category_names = array( 'All', 'Fellows', 'Staff', 'Brigade' );
  $service_code = (string) $report->category[0];
  $service_code = (int) $service_code;
  $service_code = $category_names[$service_code];

  // values from Ushahidi
  $lat = $report->location->latitude;
  $long = $report->location->longitude;
  $address_string = $report->location->location_name;
  $email = $report->incident_person->person_email;
  $first_name = $report->incident_person->person_first;
  $last_name = $report->incident_person->person_last;
  $description = $report->incident_description;
  
  //dummy values
  $api_key = '111';
  $jurisdiction_id = '404';
  $whisdorn = 'foo';
  $account_id = 'Ushahidi';
  $device_id = 'xo';
  
	$fields = array(
            'api_key'=>urlencode($api_key),
            'jurisdiction_id'=>urlencode($jurisdiction_id),
            'service_code'=>urlencode($service_code),
            'lat'=>urlencode($lat),
            'long'=>urlencode($long),
            'address_string'=>urlencode($address_string),
            'email'=>urlencode($email),
            'attribute[WHISDORN]'=>urlencode($whisdorn),
            'media_url'=>urlencode($media_url),
            'first_name'=>urlencode($first_name),
            'last_name'=>urlencode($last_name),
            'phone'=>urlencode($phone),
            'description'=>urlencode($description),
            'account_id'=>urlencode($account_id),
            'device_id'=>urlencode($device_id)
	);
	//url-ify the data for the POST
	$fields_string = '';
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');

  	$fields = http_build_query($fields);
  	//$url = 'http://open311.example.com/dev/v2/requests.xml';
  	$url = 'http://mapmeld.appspot.com/311readout';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch,CURLOPT_POST,count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=utf-8')); 
	$head = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
}


}
 



new open311;
