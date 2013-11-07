<?php

	/**
	 * The class that controls the data for the exhibits
	 *
	 * Contains all the form options and settings for the exhibits
	 *
	 * @version 0.1
	 * @since   1.0a-11062013
	 */
	class MF_Applications_Exhibits {

		/**
		 * The settings for the exhibit forms
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    1.0a-11062013
		 */
		public $settings = array(
			'title' => __( 'Maker Faire Exhibit Application', 'make-mini-mf' ),
			'description' => __( '* Indicates a required field.', 'make-mini-mf' ),
			'label_left' => false,	// Define if you want labels to be left or stacked
			'args' => array(
				'class' => 'mf-exhibits',
				'id' => 'mf-exhibits-form'
			),
			'submission' => 'refresh', // Two options. 'ajax' or 'refresh' NOTE: ajax is not ready yet ;)
			'method' => 'post', // The method to use when submitting, POST or GET.
			'security' => array(
				'input_id' => 'ff-submitted', // The value to set when submitting our form.
				'nonce_action' => 'save_form', // Action name. Should give the context to what is taking place.
				'nonce_name' => 'formflow_nonce', // Nonce name. This is the name of the nonce hidden form field to be created.
			),
			'create-post' => array(  // We can setup our form to create a new post on save. YAY!
				'form_title' => 'project_name', // The NAME FIELD of the form field we want to set as our post title
				'post_type' => 'mf_form', // Pass the post type name
				'post_status' => 'proposed', // Pass the post status. If empty or not set, 'publish' is default
			),
		);


		/**
		 * Default Form when no fields exist
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    1.0a-11062013
		 */
		public $form = array(
			array(
				'id'   	   => 1,
				'type' 	   => 'hidden',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'form-type',
					'name'	  	  => 'form_type',
					'value'		  => 'exhibit',
				),
			),
			array(
				'id'   	   => 2,
				'type' 	   => 'hidden',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'faire',
					'name'	  	  => 'maker_faire',
					'value'		  => '2013_newyork',
				),
			),
			array(
				'id'   	   => 3,
				'type' 	   => 'hidden',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'uid',
					'name'	  	  => 'uid',
				),
			),
			array(
				'id'   	   => 3,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'project-name',
					'label' 	  => __( 'Project Name', 'make-mini-mf' ),
					'name'	  	  => 'project_name',
					'description' => __( 'Provide a short, catchy name for your project. Response limited to 50 characters', 'make-mini-mf' ),
					'maxlength'   => 50,
				),
			),
			array(
				'id'   	   => 4,
				'type' 	   => 'textarea',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'private-description',
					'label' 	  => __( 'Tell us about your project', 'make-mini-mf' ),
					'name'	  	  => 'private_description',
					'description' => __( 'For the Maker Faire team, explain what your project is and describe what you will actually be bringing to Maker Faire. This information will not be made public. Be as descriptive as possible.', 'make-mini-mf' ),
				),
			),
			array(
				'id'   	   => 5,
				'type' 	   => 'textarea',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'public-description',
					'label' 	  => __( 'Short Project Description', 'make-mini-mf' ),
					'name'	  	  => 'public_description',
					'description' => __( 'We need a short, concise description. Limited to 225 characters.', 'make-mini-mf' ),
					'maxlength'   => 250,
				),
			),
			array(
				'id'   	   => 6,
				'type' 	   => 'image',
				'required' => true,
				'args' 	   => array(
					'w_id'  	  => 'project-photo',
					'label' 	  => __( 'Project Photo', 'make-mini-mf' ),
					'name'	  	  => 'project_photo',
					'description' => __( 'File must be at least 500px wide or larger. PNG, JPG or GIF formats only.', 'make-mini-mf' ),
				),
			),
			array(
				'id'   	   => 7,
				'type' 	   => 'url',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'project-website',
					'label' 	  => __( 'Project Website', 'make-mini-mf' ),
					'name'	  	  => 'project_website',
					'description' => __( 'Example: http://www.makerfaire.com/', 'make-mini-mf' ),
				),
			),
			array(
				'id'   	   => 8,
				'type' 	   => 'url',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'project-video',
					'label' 	  => __( 'Project Video', 'make-mini-mf' ),
					'name'	  	  => 'project_video',
					'description' => __( 'Example: http://www.youtube.com/watch?v=RD_JpGgUFQQ', 'make-mini-mf' ),
				),
			),
			array(
				'id'   	   => 9,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'food',
					'label' 	  => __( 'Will you be giving away, selling, or sampling food (packaged or unpackaged) at Maker Faire?', 'make-mini-mf' ),
					'name'	  	  => 'food',
					'description' => __( 'Including food in your exhibit may require a Health Permit and fees. Details will be emailed to you after acceptance.', 'make-mini-mf' ),
					'options'	  => array(
						'Yes',
						'No',
					),
				),
			),
			array(
				'id'   	   => 10,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'org-type',
					'label' 	  => __( 'Are you a:', 'make-mini-mf' ),
					'name'	  	  => 'org_type',
					'options'	  => array(
						__( 'Non-Profit', 'make-mini-mf' ),
						__( 'Cause or Mission-Based Organization', 'make-mini-mf' ),
						__( 'Established Company or Commercial Entity', 'make-mini-mf' ),
						__( 'None of the Above', 'make-mini-mf' ),
					),
				),
			),
			array(
				'id'   	   => 11,
				'type' 	   => 'radio',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'sales',
					'label' 	  => __( 'Will you be selling or marketing a product at Maker Faire?', 'make-mini-mf' ),
					'name'	  	  => 'sales',
					'options'	  => array(
						__( 'Yes', 'make-mini-mf' ),
						__( 'No', 'make-mini-mf' ),
					),
				),
			),
			array(
				'id'   	   => 12,
				'type' 	   => 'radio',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'crowdsource_funding',
					'label' 	  => __( 'At Maker Faire, will you soliciting any crowdsource funding (Kickstarter, Indiegogo, PiggyBackr, etc?)', 'make-mini-mf' ),
					'name'	  	  => 'sales',
					'options'	  => array(
						__( 'Yes', 'make-mini-mf' ),
						__( 'No', 'make-mini-mf' ),
					),
				),
			),
		);
	}

	$mf_application_exhibits = new MF_Applications_Exhibits();
