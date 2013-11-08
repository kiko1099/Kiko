<?php

	/**
	 * The class that controls the data for the exhibits
	 *
	 * Contains all the form options and settings for the exhibits
	 *
	 * @version 0.1
	 * @since   1.0a-11072013
	 */
	class MF_Applications_Form {

		/**
		 * The settings for the exhibit forms
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    1.0a-11072013
		 */
		public $settings = array(
			'title' => 'Submit your project for ____ Mini Maker Faire 2013',
			'description' => '* Indicates a required field.',
			'label_left' => false,	// Define if you want labels to be left or stacked
			'args' => array(
				'class' => 'mmf-application',
				'id' => 'mmf-form'
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
				'post_type' => 'application', // Pass the post type name
				'post_status' => 'pending', // Pass the post status. If empty or not set, 'publish' is default
			),
		);


		/**
		 * Default Form when no fields exist
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    1.0a-11082013
		 */
		public $form = array(
			array(
				'id'   	   => 1,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'form-type',
					'label'		  => 'Type of Proposal',
					'name'	  	  => 'form_type',
					'options'	  => array(	// Add the names of each checkbox. All of these will be saved to one field as an array
						'booth-exhibit' => 'Maker booth or exhibit',
						'commercial-booth' => 'Commercial maker booth (primarily sales booth)',
						'workshop-presentation' => 'Workshop or Presentation',
						'performer' => 'Performer',
						'exhibit-sponsor' => 'Exhibiting sponsor',
					),
				),
			),
			array(
				'id'   	   => 2,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'project-name',
					'label' 	  => 'Project Name',
					'name'	  	  => 'project_name',
					'description' => 'Provide a short, catchy name for your project. Response limited to 50 characters',
					'maxlength'   => 50,
				),
			),
			array(
				'id'   	   => 3,
				'type' 	   => 'textarea',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'description',
					'label' 	  => 'Project Description',
					'name'	  	  => 'description',
					'description' => 'This text will also be used on your Maker sign. Be descriptive!',
				),
			),
			array(
				'id'   	   => 4,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'hands-on',
					'label' 	  => 'Does your exhibit include a hands-on activity? (If so, please include that in your exhibit description)',
					'name'	  	  => 'hands_on',
					'description' => '',
					'options'     => array(
						'yes' => 'Yes',
						'no'  => 'No',
					),
				),
			),
			array(
				'id'   	   => 5,
				'type' 	   => 'url',
				'required' => false,
				'args' 	   => array(
					'id'  	  	  => 'project-website',
					'label' 	  => 'Project Website Address (URL)',
					'name'	  	  => 'project_website',
					'description' => '',
				),
			),
			array(
				'id'   	   => 6,
				'type' 	   => 'url',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'project-photo',
					'label' 	  => 'Project Photo Address (URL)',
					'name'	  	  => 'project_photo',
					'description' => 'Example: http://farm3.static.flickr.com/2734/4092798589_2578ec1ba7_o.jpg. Please select your 
					best photo—this will appear on your sign, and may also be used for promotional reasons. Please do not include a 
					link to an entire online photo album.',
				),
			),
			array(
				'id'   	   => 7,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'first-name',
					'label' 	  => 'First Name',
					'name'	  	  => 'first_name',
					'description' => '',
				),
			),
			array(
				'id'   	   => 8,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'last-name',
					'label' 	  => 'Last Name',
					'name'	  	  => 'last_name',
					'description' => '',
				),
			),
			array(
				'id'   	   => 9,
				'type' 	   => 'text',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'org-company',
					'label' 	  => 'Organization/Company',
					'name'	  	  => 'org_company',
					'description' => '',
				),
			),
			array(
				'id'   	   => 10,
				'type' 	   => 'text',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'twitter',
					'label' 	  => 'Twitter Username (without the @)',
					'name'	  	  => 'twitter',
					'description' => '',
				),
			),
			array(
				'id'   	   => 11,
				'type' 	   => 'email',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'email',
					'label' 	  => 'Email Address',
					'name'	  	  => 'email',
					'description' => '',
				),
			),
			array(
				'id'   	   => 12,
				'type' 	   => 'text',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'address',
					'label' 	  => 'Street Address',
					'name'	  	  => 'address',
					'description' => '',
				),
			),
			array(
				'id'   	   => 13,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'city',
					'label' 	  => 'City',
					'name'	  	  => 'city',
					'description' => '',
				),
			),
			array(
				'id'   	   => 14,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'state',
					'label' 	  => 'State',
					'name'	  	  => 'state',
					'description' => '',
				),
			),
			array(
				'id'   	   => 15,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'zip',
					'label' 	  => 'Zip',
					'name'	  	  => 'zip',
					'description' => '',
				),
			),
			array(
				'id'   	   => 16,
				'type' 	   => 'phone',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'phone',
					'label' 	  => 'Phone Number',
					'name'	  	  => 'phone',
					'description' => '',
				),
			),
			array(
				'id'   	   => 17,
				'type' 	   => 'radio',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'merch-sale',
					'label' 	  => 'Commercial Maker/Crafter Exhibits',
					'name'	  	  => 'merch_sale',
					'description' => 'If you would like to sell your own creations at Maker Faire, you are welcome to do so as a 
					"Commercial Maker". Commercial Makers are responsible for their own business transactions - whether it be via cash, 
					credit card, barter, or some other means. The fee for Commercial Makers is $100, which will be invoiced in advance 
					and payable prior to receiving your Maker credentials. NOTE: FOOD VENDORS ARE NOT INCLUDED IN THIS CATEGORY. 
					Food vendors please contact [EMAIL ADDRESS HERE] for more info.',
					'options' => array(
						'selling' => 'I DO plan to sell merchandise as a "Commercial Maker"',
						'not-selling' => 'I DO NOT plan to sell merchandise.'
					),
				),
			),
			array(
				'id'   	   => 18,
				'type' 	   => 'text',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'sell-details',
					'label' 	  => 'If you ARE a Commercial Maker, what do you plan to sell?',
					'name'	  	  => 'sell_details',
					'description' => '',
				),
			),
			array(
				'id'   	   => 19,
				'type' 	   => 'checkbox',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'exhibit-details',
					'label' 	  => 'Please provide details about your exhibit',
					'name'	  	  => 'exhibit_details',
					'description' => '',
					'options' => array(
						'stnd-booth-w-chairs' => 'Standard booth space (10\'x8\' space), will bring my own table and chairs.',
						'stnd-booth-need-chairs' => 'Standard booth space (10\'x8\' space), but need help with table and chairs (we have a limited supply).',
						'mobile' => 'Mobile (will move through the Faire)',
						'hands-on' => 'Activity area (hands-on activities for attendees)',
						'perform-workshop' => 'Performance or workshop - no booth needed',
						'non-stnd' => 'Non-standard set-up',
					),
				),
			),
			array(
				'id'   	   => 20,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'special-setup-details',
					'label' 	  => 'If your exhibit is a special set-up, please describe it. ***PLEASE FILL THIS SECTION OUT IF YOU ARE A PERFORMER OR WORKSHOP LEADER.',
					'name'	  	  => 'special_setup_details',
					'description' => 'Describe number of performers/speakers, number of inputs to sound board, number of mics, whether or not you need a projector, space requirements, and any other needs.',
				),
			),
			array(
				'id'   	   => 21,
				'type' 	   => 'radio',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'location',
					'label' 	  => 'Location Preference',
					'name'	  	  => 'location',
					'description' => '',
					'options' => array(
						'indoor' => 'Indoor',
						'outdoor' => 'Outdoor',
						'either' => 'Either',
					),
				),
			),
			array(
				'id'   	   => 22,
				'type' 	   => 'radio',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'noise',
					'label' 	  => 'Noise',
					'name'	  	  => 'noise',
					'description' => '',
					'options' => array(
						'normal' => 'Normal - does not interfere with conversation',
						'amplified' => 'Amplified - adjustable level of amplification',
						'repetitve' => 'Repetitve or potentially annoying sound',
						'loud' => 'Loud!',
					),
				),
			),
			array(
				'id'   	   => 23,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'electrical',
					'label' 	  => 'Electrical Requirements',
					'name'	  	  => 'electrical',
					'description' => '',
					'options' => array(
						'none' => 'none',
						'charging' => 'Charging Station',
						'5-amp' => '5 amp circuit (0-500 watts, 120v)',
						'10-amp' => '10 amp circuit (501-1000 watts, 120v)',
						'15-amp' => '15 amp circuit (1001-1500 watts, 120v)',
						'20-amp' => '20 amp circuit (1501-2000 watts, 120v)',
					),
				),
			),
			array(
				'id'   	   => 24,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'internet',
					'label' 	  => 'Internet Requirements',
					'name'	  	  => 'internet',
					'description' => '',
					'options' => array(
						'none' => 'I don\'t need WiFi Internet access.',
						'optional' => 'It would be nice to have WiFi.',
						'required' => 'My exhibit MUST have WiFi internet access to work right.',
					),
				),
			),
			array(
				'id'   	   => 25,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'radio-frequencies',
					'label' 	  => 'Radio Frequencies',
					'name'	  	  => 'radio_frequencies',
					'description' => 'If your exhibit uses radio frequencies, please elaborate here about what frequency your exhibit uses.',
				),
			),
			array(
				'id'   	   => 26,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'safety',
					'label' 	  => 'Safety',
					'name'	  	  => 'safety',
					'description' => 'Does your activity require a safety plan that you will supply to us? This is mandatory for exhibits with open fire of any sort.',
					'options' => array(
						'yes' => 'Yes',
						'no' => 'No',
						'unsure' => 'I\'m not sure, please contact me to discuss',
					),
				),
			),
			array(
				'id'   	   => 27,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'saftey-details',
					'label' 	  => 'Please describe what the safety issues are.',
					'name'	  	  => 'safety_details',
					'description' => '',
				),
			),
			array(
				'id'   	   => 28,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'additional-details',
					'label' 	  => 'Anything else we should know about your project?',
					'name'	  	  => 'additional_details',
					'description' => '',
				),
			),
			array(
				'id'   	   => 29,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'previous-faire',
					'label' 	  => 'Have you exhibited at any Maker Faire previously?',
					'name'	  	  => 'previous_faire',
					'description' => 'Please tell us which ones, what years.',
				),
			),
			array(
				'id'   	   => 30,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'how-did-you-hear',
					'label' 	  => 'How did you hear of this Mini Maker Faire?',
					'name'	  	  => 'how_did_you_hear',
					'description' => '',
				),
			),
			array(
				'id'   	   => 31,
				'type' 	   => 'checkbox',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'parttime-educator-mentor',
					'label' 	  => 'Would you be interested in part-time work as a maker educator, or serving as a Young Maker program mentor?',
					'name'	  	  => 'parttime_educator_mentor',
					'description' => '',
					'options' => array(
						'educator' => 'Yes, I\'d like to know more about a Maker Faire maker educators directory, and find out about maker teaching gigs.',
						'mentor' => 'Yes, I would be interested in learning more about the mentor program with Maker Faire\'s YoungMakers.org.',
						'other' => 'other',
					),
				),
			),
			array(
				'id'   	   => 32,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'parttime-other',
					'label' 	  => 'If your selected other, please provide more details',
					'name'	  	  => 'parttime_other',
					'description' => '',
				),
			),
			array(
				'id'   	   => 33,
				'type' 	   => 'html',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'form-complete',
					'value'       => '<h3>Thanks for your application!',
				),
			),
			array(
				'id'   	   => 34,
				'type' 	   => 'checkbox',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'privacy-notice',
					'label' 	  => 'Please know that MAKE, Maker Faire and Maker Media respect your privacy and will not share or sell your information.',
					'name'	  	  => 'privacy_notice',
					'description' => 'Complete MAKE privacy policy is located at: http://makermedia.com/privacy',
					'options' => array(
						'accepted' => 'I understand that by submitting this application, I consent to sharing my contact and exhibit information with MAKE Magazine for editorial purposes.',
					),
				),
			),
		);
	}

	$mf_application_form = new MF_Applications_Form();
