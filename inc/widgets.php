<?php /***
Widgets
(SPYR) Tweet-stimonials

SPYRmedia.com
*/



class SPYR_Tweetstimonials_Widget extends WP_Widget {
	
	protected $defaults;
	
	function __construct() {
		
		$widget_ops = array(
			'classname'   => 'tweetstimonials',
			'description' => __('Magically add Twitter Testimonials to your sidebar.',TWEETSTIMONIALS),
			);
		$control_ops = array(
			'id_base' => 'tweetstimonials',
			'width' => 200,
			'height' => 250,
			);
		
		// Create Widget
		$this->WP_Widget(
			'tweetstimonials',
			'(SPYR) Tweet-stimonials',
			$widget_ops,
			$control_ops
			);
		
		}
	
	
	function widget($args,$instance) {
		
		extract($args);
		
		echo $before_widget;
		if ($instance['title']) {
			echo $before_title . apply_filters('widget_title',$instance['title'],$instance,$this->id_base) . $after_title;
			}
		else {
			echo $before_title . apply_filters('widget_title','Tweet-stimonials') . $after_title;
			}
		
		unset($instance['title']);
		echo get_tweetstimonials($instance);
		
		echo $after_widget;
		
		}
	
	
	function form($instance) {
		
		$instance = wp_parse_args((array)$instance,$this->defaults);
		$tweet = __('Tweet',TWEETSTIMONIALS);
		$tweets = __('Tweets',TWEESTIMONIALS);
		
		echo '
<p>
	<label for="' . $this->get_field_id('title') . '">' . __('Title',TWEETSTIMONIALS) . '</label>
	<input type="text" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . esc_attr($instance['title']) . '" class="widefat" />
	</p>
<p>
	<label for="' . $this->get_field_id('username') . '">' . __('Your Twitter Username',TWEETSTIMONIALS) . '</label>
	<input type="text" id="' . $this->get_field_id('username') . '" name="' . $this->get_field_name('username') . '" value="' . esc_attr($instance['username']) . '" class="widefat" />
	</p>
<p>
	<label for="' . $this->get_field_id('tweet_count') . '">' . __('How Many Would You Like To Display?',TWEETSTIMONIALS) . '</label>
	<select name="' . $this->get_field_name('tweet_count') . '" id="' . $this->get_field_id('tweet_count') . '" style="width:100%;">
		<option value="1" ' . selected(1,$instance['tweet_count'],false) . '>1 ' . $tweet . '</option>
		<option value="2" ' . selected(2,$instance['tweet_count'],false) . '>2 ' . $tweet . '</option>
		<option value="3" ' . selected(3,$instance['tweet_count'],false) . '>3 ' . $tweet . '</option>
		<option value="4" ' . selected(4,$instance['tweet_count'],false) . '>4 ' . $tweet . '</option>
		<option value="5" ' . selected(5,$instance['tweet_count'],false) . '>5 ' . $tweet . '</option>
		<option value="6" ' . selected(6,$instance['tweet_count'],false) . '>6 ' . $tweet . '</option>
		<option value="7" ' . selected(7,$instance['tweet_count'],false) . '>7 ' . $tweet . '</option>
		<option value="8" ' . selected(8,$instance['tweet_count'],false) . '>8 ' . $tweet . '</option>
		<option value="9" ' . selected(9,$instance['tweet_count'],false) . '>9 ' . $tweet . '</option>
		<option value="10" ' . selected(10,$instance['tweet_count'],false) . '>10 ' . $tweet . '</option>
		<option value="11" ' . selected(11,$instance['tweet_count'],false) . '>11 ' . $tweet . '</option>
		<option value="12" ' . selected(12,$instance['tweet_count'],false) . '>12 ' . $tweet . '</option>
		<option value="13" ' . selected(13,$instance['tweet_count'],false) . '>13 ' . $tweet . '</option>
		<option value="14" ' . selected(14,$instance['tweet_count'],false) . '>14 ' . $tweet . '</option>
		<option value="15" ' . selected(15,$instance['tweet_count'],false) . '>15 ' . $tweet . '</option>
		<option value="16" ' . selected(16,$instance['tweet_count'],false) . '>16 ' . $tweet . '</option>
		<option value="17" ' . selected(17,$instance['tweet_count'],false) . '>17 ' . $tweet . '</option>
		<option value="18" ' . selected(18,$instance['tweet_count'],false) . '>18 ' . $tweet . '</option>
		<option value="19" ' . selected(19,$instance['tweet_count'],false) . '>19 ' . $tweet . '</option>
		<option value="20" ' . selected(20,$instance['tweet_count'],false) . '>20 ' . $tweet . '</option>
		</select>
	</p>
<p>
	<input id="' . $this->get_field_id('show_avatars') . '" type="checkbox" name="' . $this->get_field_name('show_avatars') . '" value="1" ' . checked($instance['show_avatars'],true,false) . '/>
	<label for="' . $this->get_field_id('show_avatars') . '">' . __('Show Avatars',TWEETSTIMONIALS) . '</label>
	</p>
<p>
	<input id="' . $this->get_field_id('show_follow_me') . '" type="checkbox" name="' . $this->get_field_name('show_follow_me') . '" value="1" ' . checked($instance['show_follow_me'],true,false) . '/>
	<label for="' . $this->get_field_id('show_follow_me') . '">' . __('Show Follow Me Link',TWEETSTIMONIALS) . '</label>
	</p>
<p>
	<input id="' . $this->get_field_id('show_view_all') . '" type="checkbox" name="' . $this->get_field_name('show_view_all') . '" value="1" ' . checked($instance['show_view_all'],true,false) . '/>
	<label for="' . $this->get_field_id('show_view_all') . '">' . __('Show View All',TWEETSTIMONIALS) . '</label>
	</p>';
		
		}
	
	
	function update( $new_instance, $old_instance ) {
		
		// Clear Cache on Widget Update
		delete_transient($old_instance['username'] . '-' . $old_instance['tweet_count']);
		
		$new_instance['title'] = strip_tags( $new_instance['title'] );
		return $new_instance;
		
		}
	
	
	}
add_action('widgets_init', create_function('','return register_widget("SPYR_Tweetstimonials_Widget");'));



