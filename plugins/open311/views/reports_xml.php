<?php 


$this->load->helper('xml');
$dom = xml_dom();
$requests = xml_add_child($dom, 'service_requests');


function dateformat($datetime) {
$datetime = ($datetime == '0000-00-00 00:00:00') ? '' : date('c',strtotime($datetime));
return $datetime;
}



foreach($query->result() as $row) {

$request = xml_add_child($requests, 'request');

$updated_datetime = ($row->incident_datemodify) ? dateformat($row->incident_datemodify) : '';
$status = ($row->incident_active == 0) ? 'closed' : 'open';

xml_add_child($request, 'service_request_id', $row->id);
xml_add_child($request, 'status', $status);
xml_add_child($request, 'status_notes', '');
xml_add_child($request, 'service_name', $row->form_title);
xml_add_child($request, 'service_code', $row->form_id);
xml_add_child($request, 'description', $row->incident_title . ' - ' . $row->incident_description);
xml_add_child($request, 'agency_responsible', '');
xml_add_child($request, 'service_notice', '');
xml_add_child($request, 'requested_datetime', dateformat($row->incident_date));
xml_add_child($request, 'updated_datetime', $updated_datetime);
xml_add_child($request, 'expected_datetime', '');
xml_add_child($request, 'address', $row->location_name);
xml_add_child($request, 'address_id', $row->location_id);
xml_add_child($request, 'zipcode', '');
xml_add_child($request, 'lat', $row->latitude);
xml_add_child($request, 'long', $row->longitude);

xml_add_child($request, 'title', $row->incident_title);
xml_add_child($request, 'verified', $row->incident_verified);
xml_add_child($request, 'active', $row->incident_active);

if( strpos( $row->media_link, '/') == FALSE){
	xml_add_child($request, 'media_url', 'http://ushahidi.phpfogapp.com/media/uploads/' . $row->media_link);
}
else{
	xml_add_child($request, 'media_url', $row->media_link);
}

//xml_add_child($request, 'category_name', $row->category_id);


}

xml_print($dom);

?>



