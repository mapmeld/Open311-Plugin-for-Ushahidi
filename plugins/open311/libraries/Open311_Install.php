<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the Open311 Plugin
 *
 * @package    Ushahidi
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class Open311_Install {
	
	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db =  new Database();
	}

	/**
	 * Creates the required columns for the Open311 Plugin
	 */
	public function run_install()
	{
		
		// ****************************************
		// DATABASE STUFF
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."open311m`
			(
				id char(11) NOT NULL,
				api char(30) DEFAULT NULL,
				username char(30) DEFAULT NULL,
				password char(30) DEFAULT NULL,	
				loaded char(30) DEFAULT NULL,
				PRIMARY KEY (`id`)
			);
		");
		// ****************************************
	}

	/**
	 * Drops the Open311 Tables
	 */
	public function uninstall()
	{
		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix')."open311m;
			");
	}
}