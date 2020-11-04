<?php

require_once(ABSPATH . '/wp-admin/includes/upgrade.php');

function install_db()
{
	create_log();
	create_pages();
	create_ua();
}

/**
 * Create __userdatalog_log table
 */
function create_log()
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'userdatalog_log';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		page_id int(6) UNSIGNED NOT NULL,
		date int(10) NOT NULL,
		ua int(6) NOT NULL,
		ref varchar(1000) NOT NULL,
		ip varchar(60) NOT NULL,
		comment varchar(500) NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

	dbDelta($sql);
}

/**
 *	Create __userdatalog_pages table
 */
function create_pages()
{
	/**
	 * Declaring $wpdb as global and using it
	 * for SQL query statement
	 */
	global $wpdb;

	$table_name = $wpdb->prefix . 'userdatalog_pages';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
		site_id int(5) UNSIGNED NULL,
		name varchar(50) NULL,
		location varchar(500) NOT NULL,
		version varchar(50) NULL,
		comment varchar(500) NULL,
		PRIMARY KEY (id)
	) $charset_collate;";
	
	/**
	 * Modifies the database based on specified SQL statements.
	 * https://developer.wordpress.org/reference/functions/dbdelta/
	 */
	dbDelta($sql);
}

/**
 *	Create __userdatalog_ua table (this is for storing user agent info)
 */
function create_ua()
{
	/**
	 * Declaring $wpdb as global and using it
	 * for SQL query statement
	 */
	global $wpdb;

	$table_name = $wpdb->prefix . 'userdatalog_ua';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
		ua varchar(500) NOT NULL,
		comment varchar(200) NULL,
		PRIMARY KEY (id)
	) $charset_collate;";
	
	/**
	 * Modifies the database based on specified SQL statements.
	 * https://developer.wordpress.org/reference/functions/dbdelta/
	 */
	dbDelta($sql);
}