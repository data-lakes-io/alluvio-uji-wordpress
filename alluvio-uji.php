<?php
/**
 * Alluvio UJI Plugin
 *
 * @package           alluvio-uji
 * @author            data-lakes.io Community
 * @copyright         2022 data-lakes.io
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Alluvio UJI WordPress Plugin
 * Plugin URI:        https://github.com/data-lakes-io/alluvio-uji-wordpress
 * Description:       This plugin adds your Riverbed Alluvio UJI (User Journey Intelligence) tag into your Wordpress site
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            data-lakes.io Community
 * Author URI:        https://github.com/data-lakes-io/alluvio-uji-wordpress
 * Text Domain:       alluvio-uji
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/data-lakes-io/alluvio-uji-wordpress
 */


function alluvio_wphelper_append_btt_scripts_js()
{
	// Read Setting
	$settingBTT = get_option('alluvio_wphelper_setting_btt');

	// Add empty script, when setting is empty
	if ( strlen( $settingBTT ) === 0 ) {
	  echo "";
	}
	else {
  	  $addScript = '<script type="text/javascript" async="true" src="//'.$settingBTT.'.btttag.com/btt.js"></script>';
          echo $addScript;
	}
}

function alluvio_wphelper_append_apm_scripts_js()
{
	// Read Setting 
        $settingAPM = get_option('alluvio_wphelper_setting_apm');
        
	// Add empty script, when setting is empty
	if ( strlen( $settingAPM ) === 0 ) {
          echo "";
        }
        else {
	  // Validate if stetting includes the RVBD_EUE tag, otherwise return empty result
	  if (str_contains($settingAPM, 'RVBD_EUE')) {
	    echo $settingAPM;
	  }
	  else {
            echo "";
	  }
       }
}

// Function to apply settings in the Settings > General area
function alluvio_wphelper_settings_init() {

	register_setting('general', 'alluvio_wphelper_setting_btt');
	register_setting('general', 'alluvio_wphelper_setting_apm');

	add_settings_section(
		'alluvio_wphelper_settings_section',
		'Alluvio UJI Settings', 'alluvio_wphelper_settings_section_callback',
		'general'
	);

	add_settings_field(
		'alluvio_wphelper_settings_field',
		'Tag Prefix', 'alluvio_wphelper_settings_field1_callback',
		'general',
		'alluvio_wphelper_settings_section'
	);

	add_settings_field(
		'alluvio_wphelper_settings_field2',
		'User Experience Snippet', 'alluvio_wphelper_settings_field2_callback',
		'general',
		'alluvio_wphelper_settings_section'
        );
}


add_action('admin_init', 'alluvio_wphelper_settings_init');


// Callback function for section title
function alluvio_wphelper_settings_section_callback() {
  echo '<p>Please enter the UJI and APM configuration settings.</p>';
}

// Callback function for BTT setting field
function alluvio_wphelper_settings_field1_callback() {

	$setting = get_option('alluvio_wphelper_setting_btt');
	?>

	<div>
	  <input type="text" name="alluvio_wphelper_setting_btt" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
	</div>
	<div>	
	  <p>Please ask the Aternity SaaS Team for the Tag Prefix. If you have already access to the system, please login</p>
	  <p>into the portal page and open Settings > Site > Sites.</p>
	</div>
    <?php

}

// Callback function for APM setting field
function alluvio_wphelper_settings_field2_callback() {

        $setting = get_option('alluvio_wphelper_setting_apm');
        ?>

        <div>
          <textarea type="text" cols="80" rows="25" name="alluvio_wphelper_setting_apm">
		 <?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>
	  </textarea>
        </div>
        <div>
          <p>Copy the Snippnet from the Define Configutation Page into this textbox.</p>
        </div>
    <?php
}

// Add Hook to add BTT and APM scripts
add_action('wp_head', 'alluvio_wphelper_append_btt_scripts_js');
add_action('wp_head', 'alluvio_wphelper_append_apm_scripts_js');
