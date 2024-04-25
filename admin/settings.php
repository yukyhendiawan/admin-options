<?php
/**
 * Create a simple API settings.
 *
 * @package     Yukyhendiawan
 * @author      Yuky Hendiawan <yukyhendiawan123@gmail.com>
 * @link        https://developer.wordpress.org/plugins/settings/
 * @since       1.0.0
 */

/**
 * Custom option and settings.
 */
function prefix_settings_init() {
	// Register a new setting for "store" page.
	register_setting(
		'store',                                             // $option_group
		'store_options',                                     // $option_name
		array(                                               // $args
			'type'    => 'array',
			'default' => array(
				'store-status' => 'active',
				'store-type'   => 'online',
			),
		)
	);

	// Register a new section in the "store" page.
	add_settings_section(
		'section_store',                          // $id
		__( 'Store information', 'text-domain' ), // $title
		'prefix_display_callback_section',        // $callback
		'store'                                   // $page ( registered by register_setting() ).
	);

	// Register a new field in the "section_store" section, inside the "store" page.
	add_settings_field(
		'store_status',                                         // $id
		__( 'Store Status', 'text-domain' ),                    // $title
		'prefix_display_callback_field_store_status',           // $callback
		'store',                                                // $page
		'section_store',                                        // $section ( registered by add_settings_section() )
		array(                                                  // $args
			'label_for'                => 'store-status',
			'class'                    => 'class-store-status',
			'store_status_custom_data' => 'custom',
		)
	);

	// Register a new field for radio buttons in the "section_store" section, inside the "store" page.
	add_settings_field(
		'store_type',                                           // $id
		__( 'Store Type', 'text-domain' ),                      // $title
		'prefix_display_callback_field_store_type',             // $callback
		'store',                                                // $page
		'section_store',                                        // $section ( registered by add_settings_section() )
		array(                                                  // $args
			'label_for'              => 'store-type',
			'class'                  => 'class-store-type',
			'store_type_custom_data' => 'custom',
		)
	);
}
add_action( 'admin_init', 'prefix_settings_init' );

/**
 * Sanitization callback for store_options.
 *
 * @param array $input The input data to be sanitized.
 * @return array Sanitized input data.
 */
function prefix_sanitize_store_options( $input ) {
	$sanitized_input = array();

	// Define valid store status options.
	$valid_store_statuses = array( 'active', 'deactive' );

	// Define valid store type options.
	$valid_store_types = array( 'online', 'offline' );

	// Sanitize store status.
	if ( isset( $input['store-status'] ) && in_array( $input['store-status'], $valid_store_statuses, true ) ) {
		$sanitized_input['store-status'] = sanitize_text_field( $input['store-status'] );
	} else {
		$sanitized_input['store-status'] = sanitize_text_field( 'active' );
	}

	// Sanitize store type.
	if ( isset( $input['store-type'] ) && in_array( $input['store-type'], $valid_store_types, true ) ) {
		$sanitized_input['store-type'] = sanitize_text_field( $input['store-type'] );
	} else {
		$sanitized_input['store-type'] = sanitize_text_field( 'online' );
	}

	return $sanitized_input;
}
add_filter( 'sanitize_option_store_options', 'prefix_sanitize_store_options' );

/**
 * Callback function for Section "store".
 *
 * @param array $args An array of arguments passed to the callback function.
 */
function prefix_display_callback_section( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Complete data about the store.', 'text-domain' ); ?></p>
	<?php
}

/**
 * Callback function for field "store_status".
 *
 * @param array $args An array of arguments passed to the callback function.
 */
function prefix_display_callback_field_store_status( $args ) {
	// Get settings value ( registered by register_setting() param 2 ).
	$options = get_option( 'store_options' );
	?>
	<select
		id="<?php echo esc_attr( $args['label_for'] ); ?>"
		data-custom="<?php echo esc_attr( $args['store_status_custom_data'] ); ?>"
		name="store_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
		<option value="active" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'active', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'Active', 'text-domain' ); ?>
		</option>
		<option value="deactive" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'deactive', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'Deactive', 'text-domain' ); ?>
		</option>
	</select>
	<p class="description">
		<?php esc_html_e( 'Is the store information still active or not.', 'text-domain' ); ?>
	</p>
	<?php
}

/**
 * Callback function for field "store_type".
 *
 * @param array $args An array of arguments passed to the callback function.
 */
function prefix_display_callback_field_store_type( $args ) {
	// Get settings value ( registered by register_setting() param 2 ).
	$options = get_option( 'store_options' );
	?>
	<fieldset>
		<legend class="screen-reader-text"><span><?php esc_html_e( 'Store Type', 'text-domain' ); ?></span></legend>
		<label for="<?php echo esc_attr( $args['label_for'] . '_online' ); ?>">
			<input type="radio" name="store_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] . '_online' ); ?>" value="online" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 'online', false ) ) : ( checked( 'online', 'online', false ) ); ?>>
			<?php esc_html_e( 'Online', 'text-domain' ); ?>
		</label><br>
		<label for="<?php echo esc_attr( $args['label_for'] . '_offline' ); ?>">
			<input type="radio" name="store_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] . '_offline' ); ?>" value="offline" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 'offline', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'Offline', 'text-domain' ); ?>
		</label>
	</fieldset>
	<p class="description">
		<?php esc_html_e( 'Select the type of store.', 'text-domain' ); ?>
	</p>
	<?php
}