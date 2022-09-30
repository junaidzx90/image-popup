<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.fiverr.com/junaidzx90
 * @since             1.0.0
 * @package           Image_Popup
 *
 * @wordpress-plugin
 * Plugin Name:       Image Popup
 * Plugin URI:        https://www.fiverr.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Developer Junayed
 * Author URI:        https://www.fiverr.com/junaidzx90
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       image-popup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IMAGE_POPUP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_image_popup() {
	
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_image_popup() {
	
}

register_activation_hook( __FILE__, 'activate_image_popup' );
register_deactivation_hook( __FILE__, 'deactivate_image_popup' );

add_action("wp_enqueue_scripts", "image_popup_styles");
function image_popup_styles(){
	wp_register_style("image-popup", plugin_dir_url(__FILE__ )."css/style.css",array(), "1.0.0", "all" );
}

add_action("wp_footer", "image_popup_contents" );
function image_popup_contents(){
	if(!get_option('img_pp_img')){
		return;
	}
	if(!is_home() ){
		return;
	}
	wp_enqueue_style( "image-popup" );
	?>
	<div id="image-popup">
		<div class="img-pp-contents">
			<div class="closebtnbox">
				<span class="close-img-pp">+</span>
			</div>
			<img src="<?php echo get_option('img_pp_img') ?>">
		</div>
	</div>

	<script>
		jQuery(document).ready(function ($) {
			$(document).on("click", ".close-img-pp", function(){
				$("#image-popup").addClass("dnone");
			});
		});
	</script>
	<?php
}

add_action("admin_menu", "image_popup_admin_menu" );
function image_popup_admin_menu(){
	add_options_page("Image Popup", "Image Popup", "manage_options", "image-popup", "image_popup_menupage", null );

	add_settings_section( 'img_pp_setting_section', '', '', 'img_pp_setting_page' );
	add_settings_field( 'img_pp_img', 'Image URL', 'img_pp_img_cb', 'img_pp_setting_page','img_pp_setting_section' );
	register_setting( 'img_pp_setting_section', 'img_pp_img' );
}

function img_pp_img_cb(){
	echo '<input type="url" name="img_pp_img" value="'.get_option('img_pp_img').'" class="widefat">';
}

function image_popup_menupage(){
	?>
	<h3>Settings</h3>
	<hr>
	<div class="img_pp_settings">
		<form style="width: 75%;" method="post" action="options.php">
			<?php
			settings_fields( 'img_pp_setting_section' );
			do_settings_sections('img_pp_setting_page');
			echo get_submit_button( 'Save Changes', 'secondary', 'save-img-pp-setting' );
			?>
		</form>
	</div>
	<?php
}