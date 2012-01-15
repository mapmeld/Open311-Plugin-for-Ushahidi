<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Open311 Model
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Open311 Model  
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Open311_Model extends ORM
{
	
	// Database table name
	protected $_table_name = 'open311m';
	protected $_primary_key = 'id';
	
	protected $_table_columns = array('id', 'api', 'username', 'password', 'loaded');
}