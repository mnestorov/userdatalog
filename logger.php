<?php
namespace MnUserDataLog;

class UserDataLog {
	
	/**
	 *	Returns Basic Info for Display in the Dashboard
	 *
	 * @return
	 */
	public function basicInfo()
	{
		/**
		 * Declaring $wpdb as global and using it
		 * for SQL query statement
		 */
		global $wpdb;
		
		$table = $wpdb->prefix . 'userdatalog_log';
		$count = $wpdb->get_var("SELECT COUNT(id) FROM $table");
		
		return $count;
	}
	
	/**
	 *	Performs logging
	 */
	public function userdatalog()
	{
		$date = time();
		
		$ua         = $_SERVER['HTTP_USER_AGENT'];
		$ip         = $_SERVER['REMOTE_ADDR'];
		$referer    = $_SERVER['HTTP_REFERER'];
		$uri        = $_SERVER['REQUEST_URI'];
		
		/**
		 * Declaring $wpdb as global and using it to
		 * execute an SQL query statement
		 */
		global $wpdb;

		$table  = $wpdb->prefix . 'userdatalog_pages';
		$sql    = $wpdb->prepare("SELECT id FROM $table WHERE location=%s", $uri);
		$id     = $wpdb->get_var($sql);
		
		// see if URI already in the db, if not insert it;
		// get id in any case
		if (!$id) {
			$id = $this->insertUri($uri);
		}

		// get UA ID
		$table  = $wpdb->prefix . 'userdatalog_ua';
		$sql    = $wpdb->prepare("SELECT id FROM $table WHERE ua=%s",$ua);
		$ua_id  = $wpdb->get_var($sql);
		
		// see if UA already in the db, if not insert it;
		// get id in any case
		if (!$ua_id) {
			$ua_id = $this->insertUA($ua);
		}

		/**
		 * Log Access Params
		 */
		$acc_params = array(
			'page_id'   => $id,
			'date'      => $date,
			'ua'        => $ua_id,
			'ref'       => $referer,
			'ip'        => $ip
		);
		$wpdb->insert($wpdb->prefix . 'userdatalog_log', $acc_params);

		//var_dump($id);
	}
	
	/**
	 * Insert new URI entry
	 *
	 * @param $uri
	 *
	 * @return
	 */
	protected function insertUri($uri){
		/**
		 * Declaring $wpdb as global and using it to
		 * execute an SQL query statement
		 */
		global $wpdb;
		
		$wpdb->insert($wpdb->prefix.'userdatalog_pages',array('location' => $uri));

		return $wpdb->insert_id;
	}
	
	/**
	 * Insert User Agent string if not present in the table
	 *
	 * @param $ua
	 *
	 * @return
	 */
	protected function insertUA($ua){
		/**
		 * Declaring $wpdb as global and using it to
		 * execute an SQL query statement
		 */
		global $wpdb;
			
		$wpdb->insert($wpdb->prefix.'userdatalog_ua',array('ua' => $ua));

		return $wpdb->insert_id;
	}
}