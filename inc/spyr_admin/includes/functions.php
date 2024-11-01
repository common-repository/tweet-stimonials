<?php /***
Functions
(SPYR) Admin Library

SPYRmedia.com
*/



/*** Create SPYR Media Admin Page or Add Sub-Menu *

$menu_item = array(
	'name' => 'SPYR Media',
	'title' => __('(SPYR) Plugin Options',SPYRPLUGIN),
	'slug' => 'spyr_opts',
	'function' => 'spyr_admin_add_page_content'
	);
*/
function spyr_admin_add_page($menu_item = NULL) {
	
	// SPYR Media Section Does Not Exist
	if (!defined('SPYR_ADMIN_PAGE')) {
		
		// Add Menu Separator
		spyr_admin_add_menu_separator('58.0000001');
		
		// Add Default About SPYR Root Page
		define('SPYR_ADMIN_PAGE','SPYRmedia');
		
		add_menu_page(
			'SPYR Media',
			'SPYR Media',
			'edit_theme_options',
			SPYR_ADMIN_PAGE,
			'spyr_admin_main_page_init',
			'div',
			'58.0000002'
			);
		
		add_submenu_page(
			SPYR_ADMIN_PAGE,
			'SPYR Media',
			'(SPYR) ' . __('Vault','spyr'),
			'edit_theme_options',
			SPYR_ADMIN_PAGE,
			'spyr_admin_main_page_init'
			);
		
		}
	
	if (isset($menu_item)) {
		$defaults = array(
			'name' => 'SPYR Media',
			'title' => '(SPYR) ' . __('Plugin Options','spyr'),
			'slug' => 'spyr_opts',
			'function' => NULL
			);
		
		$menu_item = wp_parse_args((array)$menu_item,$defaults);
	
		// Add Sub-Menu Page
		add_submenu_page(
			SPYR_ADMIN_PAGE,
			$menu_item['title'],
			$menu_item['title'],
			'edit_theme_options',
			$menu_item['slug'],
			$menu_item['function']
			);
		}
	
	}



/*** Admin Menu Separator */
function spyr_admin_add_menu_separator($menu_position) {
	
	global $menu; 
	if (!isset($menu[$menu_position])) {
		$menu[$menu_position] = array(
			0 => '',
			1 => 'read',
			2 => 'separator' . $menu_position,
			3 => '',
			4 => 'wp-menu-separator'
			);
		}
	
	}



/*** Init Standard Admin Page Wrapper */
function spyr_admin_standard_page_wrapper($menu_slug,$page_title,$page_subtitle,$form = false) {
	
	echo '
<div class="wrap spyr_admin_page_wrap ' . $menu_slug . '_page_wrap" id="' . $menu_slug . '">
	' . ($form ? '<form name="options-form" method="post">' : '') . '
		<div class="spyr_header">
			' . ($form ? '<input type="submit" class="button button-primary" name="' . $menu_slug . '_save" value="' . __('Save Settings','spyr') . '" />' : '') . '
			<div class="icon64"></div>
			<h2>' . $page_title . (isset($page_subtitle) ? ' <span class="spyr_subtitle">' . $page_subtitle . '</span>' : '') . '</h2>
			<div class="clear"></div>
			</div>';
	
	// Only Include Validation on Form Pages
	if ($form) {
		
		if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'],$menu_slug . '_updated')) {
			do_action($menu_slug . '_save');
			echo '
		<div class="updated option_updated"><p>' . __('Options Saved!','spyr') . '</p></div>';
			}
		
		}
	
	do_action($menu_slug . '_content');
	
	if ($form) {
		
		wp_nonce_field($menu_slug . '_updated');
	
		echo '
		<p class="submit"><input type="submit" class="button button-primary" name="' . $menu_slug . '_update_options" value="' . __('Save Settings','spyr') . '" /></p>
		</form>';
		
		}
	echo '
	</div>';
	
	}



/*** Main SPYR Media Page */
function spyr_admin_main_page_init() {
	
	spyr_admin_standard_page_wrapper(
		SPYR_ADMIN_PAGE,
		__('The Vault','spyr'),
		__('from','spyr') . ' <a href="http://spyr.me" target="_blank">SPYR Media</a>'
		);
	
	}


function spyr_admin_main_page() {
	
	// Pass Active (SPYR) Plugins
	global $spyr_active_plugins;
	$url = 'http://by.spyr.me/default/?plugins=' . implode(',',$spyr_active_plugins);
	
	$default_page = wp_remote_get($url);
	
	if (is_wp_error($default_page)) {
		$error_message = $default_page->get_error_message();
		echo '<p style="text-align:center;">' . __('Uh oh, something went wrong. Please try again.<br />Error: ','spyr') . $error_message . '</p>';
		}
	else {
		echo $default_page['body'];
		}
	
	}
add_action('SPYRmedia_content','spyr_admin_main_page');



