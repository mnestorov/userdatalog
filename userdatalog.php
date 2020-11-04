<?php

/**
 *	Plugin Name: User Data Log
 * 	Plugin URI: https://github.com/mnestorov/userdatalog
 *	Description: This is a very simple WordPress plugin for log users access parameters like IP address, referrer, user agent, etc. to database.
 *	Version: 1.0
 *	Author: Martin Nestorov
 *	Author URI: https://github.com/mnestorov
 */

/**
 * Installation
 */
include_once __DIR__ . '/install.php';

// Set the activation hook for a plugin.
register_activation_hook(__FILE__, 'install_db');

/**
 * Run The Logging
 */
require_once(__DIR__ . '/logger.php');
$log = new MnUserDataLog\userdatalog();
$log->userdatalog();

/**
 * Add To Admin Dashboard
 */
function mn_userdatalog_dashboard_info()
{
	/**
	 * Adds a new dashboard widget.
	 * https://developer.wordpress.org/reference/functions/wp_add_dashboard_widget/
	 */
	wp_add_dashboard_widget('userdatalog_info', 'User Data Log - Info', 'mn_userdatalog_display_info');
}

add_action('wp_dashboard_setup','mn_userdatalog_dashboard_info');


function mn_userdatalog_display_info()
{
	$log = new MnUserDataLog\userdatalog();
	echo __('Total number of visits: ', 'userdatalog');
	echo $log->basicInfo();
}
