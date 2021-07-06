<?php

/**
 * Overriding Beaver Builder's Button Module's Form Field
 *
 * @return null
 */
add_filter( 'fl_builder_register_settings_form', function( $form, $id )
{
	
	$presets = fs_define_bb_button_presets();
	$preset_field_options = array('default'   => 'No Preset');

	if(!empty($presets)){
		foreach($presets as $key => $preset){
			$preset_field_options[$key] = $preset['name'];
		}
	}

	$preset_field = array(
		'button_preset' => array(
			'type'    => 'select',
			'label'   => 'Button Preset',
			'default' => 'default',
			'options' => $preset_field_options			
    	)
    );

	if ( 'button' == $id ) {
		
		$form['style']['sections']['style']['fields'] = $preset_field + $form['style']['sections']['style']['fields'];

	}

	if ( 'buttons_form' == $id ) {

		$form['tabs']['style']['sections']['style']['fields'] = $preset_field + $form['tabs']['style']['sections']['style']['fields'];

	}

	return $form;

}, 10, 2 );

/**
 * Overriding Beaver Builder's Button Module's default settings
 *
 * @return null
 */
add_filter('fl_builder_node_settings', function( $settings, $node ){

	// echo "<pre>";
	// print_r($settings);
	// echo "</pre>";

	
    $presets = fs_define_bb_button_presets();

	if(empty($presets)){
		return $settings;
	}


	if('button' == $settings->type){

		if('default' == $settings->button_preset){
	    	return $settings;
	    }

		$custom_settings = $presets[$settings->button_preset]['settings'];
		$custom_class = isset($presets[$settings->button_preset]['class']) ? $presets[$settings->button_preset]['class'] : '';

		foreach($custom_settings as $key => $setting){
			$settings->$key = $setting;
		}

		if($custom_class != ''){
			$settings->class = $settings->class . ' ' . $custom_class;
		}	
    }
	elseif('button-group' == $settings->type){
		foreach($settings->items as $i => $button_settings){

			if('default' == $button_settings->button_preset){
		    	continue;
		    }

			$custom_settings = $presets[$button_settings->button_preset]['settings'];
			$custom_class = isset($presets[$settings->items[$key]->button_preset]['class']) ? $presets[$settings->items[$key]->button_preset]['class'] : '';

			foreach($custom_settings as $key => $setting){
				$settings->items[$i]->$key = $setting;
			}

			

			if($custom_class != ''){
				$settings->items[$i]->class = $settings->items[$i]->class . ' ' . $custom_class;
			}
		}
		
    }
    
	return $settings;

}, 10, 2);