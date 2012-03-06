<?php 


$this->load->helper('json');

$requests = array( 'service_requests' => array() );


function dateformat($datetime) {
$datetime = ($datetime == '0000-00-00 00:00:00') ? '' : date('c',strtotime($datetime));
return $datetime;
}

$i = 0;

foreach($query->result() as $row) {

$i++;

$requests['service_requests'][$i] = array( 'request' => array() );

$updated_datetime = ($row->incident_datemodify) ? dateformat($row->incident_datemodify) : '';
$status = ($row->incident_active == 0) ? 'closed' : 'open';

$requests['service_requests'][$i]['request']['service_request_id'] = $row->id;
$requests['service_requests'][$i]['request']['status'] = $status;
$requests['service_requests'][$i]['request']['status_notes'] = '';
$requests['service_requests'][$i]['request']['service_name'] = $row->form_title;
$requests['service_requests'][$i]['request']['service_code'] = $row->form_id;
$requests['service_requests'][$i]['request']['description'] = $row->incident_title . ' - ' . $row->incident_description;
$requests['service_requests'][$i]['request']['agency_responsible'] = '';
$requests['service_requests'][$i]['request']['service_notice'] = '';
$requests['service_requests'][$i]['request']['requested_datetime'] = dateformat($row->incident_date);
$requests['service_requests'][$i]['request']['updated_datetime'] = $updated_datetime;
$requests['service_requests'][$i]['request']['expected_datetime'] = '';
$requests['service_requests'][$i]['request']['address'] = $row->location_name;
$requests['service_requests'][$i]['request']['address_id'] = $row->location_id;
$requests['service_requests'][$i]['request']['zipcode'] = '';
$requests['service_requests'][$i]['request']['lat'] = $row->latitude;
$requests['service_requests'][$i]['request']['long'] = $row->longitude;

$requests['service_requests'][$i]['request']['title'] = $row->incident_title;
$requests['service_requests'][$i]['request']['verified'] = $row->incident_verified;
$requests['service_requests'][$i]['request']['active'] = $row->incident_active;

if( strpos( $row->media_link, '/') == FALSE){
	$requests['service_requests'][$i]['request']['media_url'] = 'http://ushahidi.phpfogapp.com/media/uploads/' . $row->media_link;
}
else{
	$requests['service_requests'][$i]['request']['media_url'] = $row->media_link;
}

}

echo json_encoder($requests);

?>



