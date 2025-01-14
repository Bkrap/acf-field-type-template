<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('NAMESPACE_acf_field_FIELD_NAME') ) :


class NAMESPACE_acf_field_FIELD_NAME extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct( $settings ) {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'FIELD_NAME';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('FIELD_LABEL', 'TEXTDOMAIN');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'basic';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'predefined_action_buttons'	=> 0,
		);
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'TEXTDOMAIN'),
		);
		
		
		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		
		
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/


		acf_render_field_setting( $field, array(
			'label'			=> __('Predefined action buttons','TEXTDOMAIN'),
			'instructions'	=> __('Use predefined action (play/pause) button?','TEXTDOMAIN'),
			'type'			=> 'true_false',
			'ui'			=> 1,
			'name'			=> 'predefined_action_buttons',
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Play button','TEXTDOMAIN'),
			'instructions'	=> __('Upload your play button','TEXTDOMAIN'),
			'type'			=> 'image',
			'name'			=> 'play_button',
			'conditions'   => [
				'field'    => 'predefined_action_buttons',
				'operator' => '==',
				'value'    => 1
			]
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Pause button','TEXTDOMAIN'),
			'instructions'	=> __('Upload your pause button','TEXTDOMAIN'),
			'type'			=> 'image',
			'name'			=> 'pause_button',
			'conditions'   => [
				'field'    => 'predefined_action_buttons',
				'operator' => '==',
				'value'    => 1
			]
		));



	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		
		
		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		
		// echo '<pre>';
		// 	print_r( $field );
		// echo '</pre>';
		
		
		/*
		*  Create a simple text input using the 'font_size' setting.
		*/
		
		?>
		<input type="text" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" style="font-size:<?php echo $field['font_size'] ?>px;" />
		<?php
	}
	
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	
	
	function input_admin_enqueue_scripts() {
		
		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];
		
		
		// register & include JS
		wp_register_script('TEXTDOMAIN', "{$url}assets/js/input.js", array('acf-input'), $version);
		wp_enqueue_script('TEXTDOMAIN');
		
		
		// register & include CSS
		wp_register_style('TEXTDOMAIN', "{$url}assets/css/input.css", array('acf-input'), $version);
		wp_enqueue_style('TEXTDOMAIN');


	}
	
	
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_head() {
	
		
		
	}
	
	*/
	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_enqueue_scripts() {
		
	}
	
	*/

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	
	
	// function load_value( $value, $post_id, $field ) {
		
	// 	// echo '<pre>';
	// 	// 	print_r( $field  );
	// 	// echo '</pre>';

		
	// 	$url = $value;
	// 	$r = array();
	
	// 	preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match1);
	// 	preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $match2);

	// 	if (count($match1) > 0) {
	// 		$r['video'] = 'youtube';
	// 		$r['id'] = $match1[1];
	// 	} elseif (count($match2) > 0) {
	// 		$r['video'] = 'vimeo';
	// 		$r['id'] = $match2[5];
	// 	}

		
	// 	$video = $r;
	// 	$video_info = $r;

	// 	$video_check = ($video_info['video'] == 'youtube' ? 'https://www.youtube.com/embed/' : ($video_info['video'] == 'vimeo' ? 'https://player.vimeo.com/video/' : ''));
	// 	$api = ($video_info['video'] == 'youtube' ? '?enablejsapi=1' : ($video_info['video'] == 'vimeo' ? '?api=1' : ''));

	// 	$play_btn_img = wp_get_attachment_image_src($field['play_button'], 'full', false)[0];
	// 	$pause_btn_img = wp_get_attachment_image_src($field['pause_button'], 'full', false)[0];

	// 	// echo '<pre>';
	// 	// 	print_r( $field );
	// 	// echo '</pre>';

	// 	return $value;
		
	// }

	/*
	*  load_value_front()
	*
	*  This filter is applied to the $value after it is loaded from the db, and it is called on front page
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$url (string) the value of the url; youtube/vimeo
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$action_buttons_aray (array) the field array holding action buttons ID's
	*  @example 

			$field = array(

				'play_button' => $params['play_button']['id'],
				'pause_button' => $params['pause_button']['id'],
				
			 )

	* @front acf template example
		<?php

		$fields = new NAMESPACE_acf_field_FIELD_NAME('');

		$field = get_field('general', 'option')['video_buttons'];
		// $field = 0 ; AKO ZELIMO BEZ CUSTOM BUTTONA
		?>

		<?php myErr($field); ?>

		<?php $fields->load_value_front($params['custom_video'], $post_id, $field ); ?>

		<?php //myErr($params); ?>
	* end here

	*  @return	$value
	*/

	function load_value_front( string $url, $post_id, string $container_type, int $height_value, string $height_measure_unit, string $preview_image_url, array $action_buttons_array ) {
		
		
		$url = $url;
		$r = array();
	
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match1);
		preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $match2);

		if (count($match1) > 0) {
			$r['video'] = 'youtube';
			$r['id'] = $match1[1];
		} elseif (count($match2) > 0) {
			$r['video'] = 'vimeo';
			$r['id'] = $match2[5];
		}

		
		$video = $r;
		$video_info = $r;

		$video_check = ($video_info['video'] == 'youtube' ? 'https://www.youtube.com/embed/' : ($video_info['video'] == 'vimeo' ? 'https://player.vimeo.com/video/' : ''));
		$api = ($video_info['video'] == 'youtube' ? '?enablejsapi=1' : ($video_info['video'] == 'vimeo' ? '?api=1' : ''));

		// aj provjeri ovo mislim da ne treba ovo sve. wp_get_att ...
		$play_btn_img = wp_get_attachment_image_src($action_buttons_array['play']['id'], 'full', false)[0];
		$pause_btn_img = wp_get_attachment_image_src($action_buttons_array['pause']['id'], 'full', false)[0];

		// echo '<pre>';
		// 	print_r( $field );
		// echo '</pre>';
		?>

		<section class="video">
			<div uk-lightbox>
				<a href="<?php // echo $params['video']['image']; ?>" data-caption="Caption"></a>
			</div>
			<div class="container<?php echo $container_type; ?> px-0" id="main-video-container">
			<div class="embed-responsive embed-responsive-16by9 z-depth-1-half" style="height: <?php echo $height_value . $height_measure_unit; ?>">
				<iframe id="video-iframe" class="embed-responsive-item" allow="autoplay; encrypted-media" src="<?php echo $video_check . $video_info['id'] . $api; ?>" allowfullscreen></iframe>

				<?php if(!empty($action_buttons_array) || $action_buttons_aray > 0) { ?>
					<button id="play-btn-wrap" type="button" style="width:189px;" class="btn-video p-0">
						<div id="play-btn" class="play-btn">
							<img id="play" src="<?php echo $play_btn_img; ?>" alt="play button">
						</div> 
						<div id="pause-btn" class="pause-btn d-none">
							<img id="pause" src="<?php echo $pause_btn_img; ?>" alt="play button">
						</div> 
					</button>
				<?php } ?>
				
			</div>
			<?php if(isset($preview_image_url)) { ?>
				<div id="video-cover" style="background-image: url('<?php echo $preview_image_url; ?>');"></div>
			<?php  } ?>
			</div>
		</section>
		
		
		<?php
		return $value;
		
	}
	
	
	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function update_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
		
	
	
	// function format_value( $value, $post_id, $field ) {
		
	// 	// bail early if no value
	// 	if( empty($value) ) {
		
	// 		return $value;
			
	// 	}
		
		
	// 	// apply setting
	// 	if( $field['font_size'] > 12 ) { 
			
	// 		// format the value
	// 		// $value = 'something';
		
	// 	}
		
		
	// 	// return
	// 	return $value;
	// }
	
	
	
	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	
	/*
	
	function validate_value( $valid, $value, $field, $input ){
		
		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}
		
		
		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','TEXTDOMAIN'),
		}
		
		
		// return
		return $valid;
		
	}
	
	*/
	
	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	
	// function load_field( $field ) {
		
	// 	return $field;

		
	// }	
	

	
	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function update_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	/*
	
	function delete_field( $field ) {
		
		
		
	}	
	
	*/
	
	
}


// initialize
new NAMESPACE_acf_field_FIELD_NAME( $this->settings );


// class_exists check
endif;

?>