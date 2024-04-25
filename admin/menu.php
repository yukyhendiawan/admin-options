<?php
/**
 * Create a simple menu.
 *
 * @package     Yukyhendiawan
 * @author      Yuky Hendiawan <yukyhendiawan123@gmail.com>
 * @link        https://developer.wordpress.org/plugins/administration-menus/
 * @since       1.0.0
 */

/**
 * Add a menu page.
 */
function prefix_add_my_menu_page() {
	add_menu_page(
		__( 'My Menu Page', 'text-domain' ), // $page_title
		__( 'My Menu', 'text-domain' ),      // $menu_title
		'manage_options',                    // $capability
		'my-menu',                           // $menu_slug
		'prefix_display_my_menu_page',       // $callback
		'dashicons-admin-generic',           // $icon_url
		30                                   // $position
	);
}
add_action( 'admin_menu', 'prefix_add_my_menu_page' );

/**
 * Callback function for My Menu Page.
 */
function prefix_display_my_menu_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'My Menu Page', 'text-domain' ); ?></h1>
	</div>
	<?php
}

/**
 * Add submenus.
 */
function prefix_add_my_submenu_pages() {
	// Submenu 1.
	add_submenu_page(
		'my-menu',                             // $parent_slug
		__( 'Submenu Page 1', 'text-domain' ), // $page_title
		__( 'Submenu 1', 'text-domain' ),      // $menu_title
		'manage_options',                      // $capability
		'my-menu',                             // $menu_slug
		'prefix_display_submenu_1'             // $callback
	);

	// Submenu 2.
	add_submenu_page(
		'my-menu',                             // $parent_slug
		__( 'Submenu Page 2', 'text-domain' ), // $page_title
		__( 'Submenu 2', 'text-domain' ),      // $menu_title
		'manage_options',                      // $capability
		'submenu-2',                           // $menu_slug
		'prefix_display_submenu_2'             // $callback
	);
}
add_action( 'admin_menu', 'prefix_add_my_submenu_pages' );

/**
 * Callback function for Submenu Page 1.
 */
function prefix_display_submenu_1() {
	// Check user capabilities.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	/*
	|--------------------------------------------------------------------------
	| Settings API.
	| The code below is the structure of the settings API.
	|--------------------------------------------------------------------------
	*/

	// Show error or update messages ( registered by add_settings_error() ).
	settings_errors( 'store_messages' );

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php

			// Output security fields for the registered setting "store". ( This should match the group name used in register_setting() ).
			settings_fields( 'store' );

			// Output setting sections and their fields ( registered by add_settings_section() and add_settings_field() ).
			do_settings_sections( 'store' );

			// Output Save Changes button.
			submit_button( 'Save Changes' );
			?>
		</form>
	</div>    
	<?php
}

/**
 * Callback function for Submenu Page 2.
 */
function prefix_display_submenu_2() {
	?>
	<div class="wrap">
		<h2><?php esc_html_e( 'Submenu Page 2', 'text-domain' ); ?></h2>
	</div>
	<?php
}
