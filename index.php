<?php
/**
 *
 * Plugin Index.
 *
 * @link              https://yukyhendiawan.com
 * @since             1.0.0
 * @package           Yuky
 *
 * Plugin Name:       Admin Options
 * Plugin URI:        https://yukyhendiawan.com
 * Description:       Simple WordPress plugin for API settings.
 * Version:           1.0.0
 * Author:            Yuky Hendiawan
 * Author URI:        https://yukyhendiawan.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       text-domain
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register admin menu.
 */
require_once __DIR__ . '/admin/menu.php';

/**
 * Register settings API.
 */
require_once __DIR__ . '/admin/settings.php';
