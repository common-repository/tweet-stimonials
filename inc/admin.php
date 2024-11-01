<?php /***
Admin Page Functions
(SPYR) Tweetstimonials

SPYRmedia.com
*/



/*** Track Active (SPYR) Plugins */
function tweetstimonials_active_spyr_plugin() {
	
	global $spyr_active_plugins;
	$spyr_active_plugins[] = 'tweetstimonials';
	
	}
add_action('admin_init','tweetstimonials_active_spyr_plugin');



/*** Remove Default Twitter API Admin Page */
remove_action('admin_menu','twitter_api_admin_menu');



/*** Create Admin Page */
function tweetstimonials_add_admin_page() {
	
	$menu_item = array(
		'name' => 'SPYR Media',
		'title' => 'Tweet-stimonials',
		'slug' => 'tweetstimonials',
		'function' => 'tweetstimonials_admin_page_init'
		);
	spyr_admin_add_page($menu_item);
	
	}
add_action('admin_menu','tweetstimonials_add_admin_page',40);



/*** Admin Page Content Init */
function tweetstimonials_admin_page_init() {
	
	spyr_admin_standard_page_wrapper(
		'tweetstimonials',
		'Tweet-stimonials',
		__('from','spyr') . ' <a href="http://spyr.me" target="_blank">SPYR Media</a>',
		true
		);
	
	}



/*** Add Fields to Options Page */
function tweetstimonials_options_page() {
	
	global $spyr_forms;
	
	$tabIndex = 50;
	$authenticated = false;
	$note = NULL;
	
	echo '
<div id="tweetstimonial_options" class="spyr_option">';
	
	try {
		
		// Update API Settings
		if ( isset($_POST['saf_twitter']) && is_array($update = $_POST['saf_twitter'])) {
			$conf = _twitter_api_config($update);
			}
		
		// Get API Settings
		else {
			$conf = _twitter_api_config();
			}
		
		// Check for Complete Input
		extract($conf);
		if (!$consumer_key || !$consumer_secret) {
			throw new Exception( __('Twitter application not fully configured',TWEETSTIMONIALS));
			}
		
		// else exchange access token if callback // request secret saved as option
		if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
			$Token = twitter_api_oauth_access_token(
				$consumer_key,
				$consumer_secret,
				$_GET['oauth_token'],
				$request_secret,
				$_GET['oauth_verifier']
				);
			// have access token, update config and destroy request secret
			$conf = _twitter_api_config(array(
				'request_secret' => '',
				'access_key' => $Token->key,
				'access_secret' => $Token->secret,
				));
			extract($conf);
			// fall through to verification of credentials
			}
		
		if (!$access_key || !$access_secret) {
			$note = $spyr_forms->get_note(__('Plugin not yet authenticated with Twitter',TWEETSTIMONIALS));
			twitter_api_admin_render_login( $consumer_key, $consumer_secret );
			}
		
		// Verify credentials are still valid
		else {
			$me = twitter_api_get('account/verify_credentials');
			$note = $spyr_forms->get_note(__('Authenticated as',TWEETSTIMONIALS) . ' @<a href="http://twitter.com/' .  $me['screen_name'] . '" target="_blank" style="color:inherit;">' . $me['screen_name'] . '</a>' );
			$authenticated = true;
			}
		
		}
	catch (TwitterApiException $Ex) {
		
		$note = $spyr_forms->get_note($Ex->getStatus().': Error '.$Ex->getCode().', '.$Ex->getMessage());
		if( 401 === $Ex->getStatus()){
			twitter_api_admin_render_login( $consumer_key, $consumer_secret );
			}
		
		}
	catch (Exception $Ex) {
		
		$note = $spyr_forms->get_note($Ex->getMessage());
		
		}
	
	if (!$authenticated) {
		$note = $spyr_forms->get_note(__('<strong>Not Authenticated:</strong> Retrieve your Twitter API Credentials from',TWEETSTIMONIALS) . ' <a href="https://dev.twitter.com/apps" target="_blank">' . esc_html__('your Twitter dashboard') . '</a>');
		}
	
	extract(_twitter_api_config());
	echo '
<div class="wrap">
	<h3>' . __('Twitter API Authentication',TWEETSTIMONIALS) . '</h3>
	' . $note . '
	' . $spyr_forms->get_textbox(array(
			'type' => 'text',
			'label' => __('OAuth Consumer Key',TWEETSTIMONIALS),
			'value' => esc_html($consumer_key),
			'input_name' => 'saf_twitter[consumer_key]',
			'class' => 'regular-text',
			'tabIndex' => ++$tabIndex,
			'add_margin' => false)
			) . '
	' . $spyr_forms->get_textbox(array(
			'type' => 'text',
			'label' => __('OAuth Consumer Secret',TWEETSTIMONIALS),
			'value' => esc_html($consumer_secret),
			'input_name' => 'saf_twitter[consumer_secret]',
			'class' => 'regular-text',
			'tabIndex' => ++$tabIndex,
			'add_margin' => false)
			) . '
	' . $spyr_forms->get_textbox(array(
			'type' => 'text',
			'label' => __('OAuth Access Key',TWEETSTIMONIALS),
			'value' => esc_html($access_key),
			'input_name' => 'saf_twitter[access_key]',
			'class' => 'regular-text',
			'tabIndex' => ++$tabIndex,
			'add_margin' => false)
			) . '
	' . $spyr_forms->get_textbox(array(
			'type' => 'text',
			'label' => __('OAuth Access Secret',TWEETSTIMONIALS),
			'value' => esc_html($access_secret),
			'input_name' => 'saf_twitter[access_secret]',
			'class' => 'regular-text',
			'tabIndex' => ++$tabIndex,
			'add_margin' => false)
			) . '
	</div>';
	
	}
add_action('tweetstimonials_content','tweetstimonials_options_page',20);



