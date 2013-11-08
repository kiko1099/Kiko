<?php
	
	/**
	 * Contains Mini Maker Faire application forms
	 *
	 * These forms are built on and customized from Cole Geissinger's custom form builder class, FormFlow. https://github.com/colegeissinger/formflow
	 * You shouldn't need to adjust ANYTHING in here except for the file in classes/class.form.php. Adjusting that file will
	 * allow you to customize the form. Skills in PHP is recommended, but everything is documented so you can at least make adjustments.
	 *
	 * @version  0.2
	 * @since    1.0a-11082013
	 */
	

	// Load our primary class
	if ( ! class_exists( 'MF_Applications' ) )
		require_once( 'classes/class.applications.php' );

	// Load our helper functions if everything is setup.
	if ( class_exists( 'MF_Applications' ) )
		require_once( 'helpers/helpers.applications.php' );

	// Load our Exhibit form options and settings
	require_once( 'classes/class.form.php' );


	/**
	 * Load some styles outside of the class. This is to be completly separate to allow devs to add their own styles
	 * @return void
	 *
	 * @version 0.1
	 * @since   1.0a-11082013
	 */
	function mf_applications_resources() {
		wp_enqueue_style( 'mf-applications-default', get_stylesheet_directory_uri() . '/plugins/applications/assets/css/application-forms.css', null, THEME_VERSION );
	}
	add_action( 'wp_enqueue_scripts', 'mf_applications_resources' );


	function mf_applications_add_form( $atts, $content = null ) {
		global $mf_application_form;
		
		mf_applications_display_form( $mf_application_form->settings, $mf_application_form->form );
	}
	add_shortcode( 'display_form', 'mf_applications_add_form' );

