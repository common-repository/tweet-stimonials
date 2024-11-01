<?php /***
(SPYR) Admin Library

SPYRmedia.com
Version: 1.3

CHANGELOG

1.3
* Adjusted Tutorial styling for WordPress 3.8
* Adjusted SPYR Media menu styling for WordPress 3.8

1.2
* Adjusted Tutorial CSS
* Changed Google Fonts to protocol relative URL

1.1
* Allows for creating SPYR Media menu without adding page (useful for Custom Post Types)

*/



/*** Defaults */
define('SPYR_ADMIN_VERSION','1.3');
define('SPYR_ADMIN_URL',apply_filters('spyr_admin_url',untrailingslashit(str_replace(WP_CONTENT_DIR,site_url() . '/wp-content',dirname(__FILE__)))));
define('SPYR_ADMIN_PATH',dirname(__FILE__));




/*** Init */
require_once(SPYR_ADMIN_PATH . '/includes/forms.php');
require_once(SPYR_ADMIN_PATH . '/includes/functions.php');

$spyr_forms = new SPYR_Admin_Forms();



/*** Admin Init */
function spyr_admin_scripts() {
	
	wp_enqueue_style('spyr-admin-fonts','//fonts.googleapis.com/css?family=Rokkitt:400,700',false,SPYR_ADMIN_VERSION);
	wp_enqueue_style('spyr-admin',SPYR_ADMIN_URL . '/style-admin.css',array('spyr-admin-fonts'),SPYR_ADMIN_VERSION);
	wp_enqueue_script('spyr-admin-js',SPYR_ADMIN_URL . '/includes/js/admin.js',array('jquery'),SPYR_ADMIN_VERSION,true);
	
	}
add_action('admin_enqueue_scripts','spyr_admin_scripts',20);



