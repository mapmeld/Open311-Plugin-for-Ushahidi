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
}

/**
* Adds all the events to the main Ushahidi application
*/
public function add()
{
Event::add('ushahidi_action.report_add', array($this, '_push_report'));
}

/**
* Push a newly added report to the open311 system
*/
public function _push_report()
{
// This report variable is an object that has all the data you need.
$report = Event::$data;
}
}

new open311;
