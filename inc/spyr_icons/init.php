<?php /***
(SPYR) Icons

SPYRmedia.com
Version: 0.95
*/



/*** Defaults */
define('SPYR_ICONS_VERSION','0.95');
define('SPYR_ICONS_URL',apply_filters('spyr_admin_url',untrailingslashit(str_replace(WP_CONTENT_DIR,site_url() . '/wp-content',dirname(__FILE__)))));
define('SPYR_ICONS_PATH',dirname(__FILE__));



/*** Load (SPYR) Icons on Frontend and Backend */
function spyr_icons_init() {
	
	wp_enqueue_style('spyr-icons',SPYR_ICONS_URL . '/style.css',false,SPYR_ICONS_VERSION);
	
	}
add_action('wp_enqueue_scripts','spyr_icons_init',5);
add_action('admin_enqueue_scripts','spyr_icons_init',5);


