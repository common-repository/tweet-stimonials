<?php /***
Plugin Name: (SPYR) Tweet-stimonials
Plugin URI: http://spyr.me/plugins/tweetstimonials
Description: Use Twitter favorites to track and display testimonials on site. Includes a widget and a shortcode for placing anywhere within your theme.
Author: SPYR Media
Author URI: http://spyr.me
Version: 3.1
*/



/*** Defaults */
define('TWEETSTIMONIALS_VERSION','3.1');
define('TWEETSTIMONIALS_PATH',dirname(__FILE__));
define('TWEETSTIMONIALS_URL',plugin_dir_url(__FILE__));
define('TWEETSTIMONIALS','tweetstimonials');



/*** Init */
if (!function_exists('spyr_icons_init')) { require_once(TWEETSTIMONIALS_PATH . '/inc/spyr_icons/init.php'); }
if (!class_exists('SPYR_Admin_Forms')) { require_once(TWEETSTIMONIALS_PATH . '/inc/spyr_admin/init.php'); }
if (!function_exists('twitter_api_get')) { require_once(TWEETSTIMONIALS_PATH . '/inc/lib/twitter-api.php'); }
require_once(TWEETSTIMONIALS_PATH . '/inc/admin.php');
require_once(TWEETSTIMONIALS_PATH . '/inc/widgets.php');



/*** Enqueue Style */
function tweetstimonials_enqueue_style() {
	
	wp_enqueue_style(
		'spyr-tweetstimonials',
		TWEETSTIMONIALS_URL . 'style.css',
		false,
		TWEETSTIMONIALS_VERSION
		);
	
	}
add_action('wp_enqueue_scripts','tweetstimonials_enqueue_style');



/*** Convert URLs, Usernames and Hashtags to Links */
function tweetstimonials_add_links($text) {
	
	// Convert URLs
	$text = preg_replace( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#",'\\1<a href="\\2" target="_blank">\\2</a>',$text);
	$text = preg_replace( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#",'\\1<a href="http://\\2" target="_blank">\\2</a>',$text);
	
	// Convert Usernames
	$text = preg_replace('/@(\w+)/','<a href="http://twitter.com/\\1" target="_blank">@\\1</a>',$text);
	
	// Convert Hashtags
	$text = preg_replace('/#(\w+)/','<a href="http://search.twitter.com/search?q=\\1" target="_blank">#\\1</a>',$text);
	
	return $text;
	
	}



/*** Get Tweet-stimonials List ***

$instance = array(
	'username' => 'SPYRmedia',
	'tweet_count' => 5,
	'show_avatars' => 1,
	'show_follow_me' => 1,
	'show_view_all' => 1
	);

***/
function get_tweetstimonials($instance) {
	
	$defaults = array(
		'username' => '',
		'tweet_count' => 1,
		'show_avatars' => 1,
		'show_follow_me' => 1,
		'show_view_all' => 1,
		);
	$to_return = '';
	
	// Retrieve Cached Tweets
	$tweets = get_transient($instance['username'] . '-' . $instance['tweet_count']);
	
	// If Cache is Empty or Expired
	if (!$tweets) {
		
		$count = (int)$instance['tweet_count'];
		
		try {
			
			$tweets = twitter_api_get(
				'favorites/list',
				array(
					'count' => $instance['tweet_count'],
					'screen_name' => $instance['username']
					)
				);			
			
			$time = apply_filters('tweetstimonials_cache_duration',300);
			set_transient($instance['username'] . '-' . $instance['tweet_count'],$tweets,$time);
			
			}
		catch (Exception $Ex) {
			
			echo '
<div class="tweetstimonial_error">
	<strong>' . __('Error',TWEETSTIMONIALS) . ':</strong> ' . esc_html($Ex->getMessage()) . '
	<div><a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=tweetstimonials">' . __('Authenticate with Twitter',TWEETSTIMONIALS) . '</a></div>
	</div>';
			
			}
		
		}
	
	foreach ((array)$tweets as $tweet) {
		
		extract((array)$tweet);
		if ($instance['show_avatars']) {
			$has_avatar = " has-avatar";
			$show_avatar = '<img src="' . $tweet[user][profile_image_url] . '" alt="' . $tweet[user][name] . '" class="tweetstimonial_avatar" />';
			}
		$to_return .= '
<div class="tweetstimonial_tweet">
	<div class="tweetstimonial_content">
		' . tweetstimonials_add_links($text) . '
		</div>
	<div class="tweetstimonial_name' . $has_avatar . '">
		<a href="' .  sprintf('http://twitter.com/%s/status/%s',$tweet[user][screen_name],$tweet[id_str] ) . '" target="_blank">' . $tweet[user][name] . $show_avatar . '</a>
		</div>
	</div>';
		
		}
	
	if ($instance['show_view_all'] || $instance['show_follow_me']) {
		
		$to_return .= '
<div class="tweetstimonial_links">
	' . ($instance['show_follow_me'] ? '<a href="http://twitter.com/' . $instance['username'] . '" target="_blank">' . __('Follow Me',TWEETSTIMONIALS) . '</a>' : '') . '
	' . ($instance['show_view_all'] && $instance['show_follow_me'] ? ' | ' : '') . '
	' . ($instance['show_view_all'] ? '<a href="http://twitter.com/' . $instance['username'] . '/favorites" target="_blank">' . __('View All',TWEETSTIMONIALS) . '</a>' : '') . '
	</div>';
		
		}
	
	return $to_return;
	
	}



/*** Shortcode */
function tweetstimonials_shortcode($atts) {
	
	extract(shortcode_atts(array(
		'username' => '',
		'tweet_count' => 1,
		'show_avatars' => 1,
		'show_follow_me' => 1,
		'show_view_all' => 1,
		),$atts));
	
	$instance = array(
		'username' => $username,
		'tweet_count' => (int)$tweet_count,
		'show_avatars' => (bool)$show_avatars,
		'show_follow_me' => (bool)$show_follow_me,
		'show_view_all' => (bool)$show_view_all
		);
	
	return get_tweetstimonials($instance);
	
	}
add_shortcode('tweetstimonials','tweetstimonials_shortcode');



