=== (SPYR) Tweet-stimonials ===
Contributors: spyrmedia,jeffsarris
Donate link: http://spyr.me/plugins/tweetstimonials
Tags: twitter, testimonials, tweetstimonials
Requires at least: 2.8
Tested up to: 3.8
Stable tag: trunk

Add a Tweet-stimonials widget to your Available Widgets and use your Twitter favorites for automatic widget area testimonials.

== Description ==

Add a Tweet-stimonials widget to your Available Widgets and use your Twitter favorites for automatic sidebar testimonials. Twitter provides the capability to flag your favorite tweets. If you choose to only favorite tweets, where your clients are saying good things about you, then Tweet-stimonials can turn those tweets into on-site testimonials.

When client testimonials are marked as favorites they are then automatically published to your site, making for one of the easiest and quickest ways to publish testimonials. As soon as you mark a new tweet as a favorite, it will show up on your site.

== Installation ==

You will find that the Tweet-stimonials plugin is very straightforward. Nevertheless here are some instructions.

= Download =
* Download the Tweet-stimonials plugin

= Installation =
1. Unzip and upload the entire Tweet-stimonials folder to the /wp-content/plugins/ directory
2. Activate the plugin through the Plugins menu in WordPress

= Setup and Configuration =
1. Navigate to your Appearance -> Widgets menu. You will see the Tweet-stimonials widget listed within your Available Widgets area.
2. Simply drag this widget to the sidebar of your choice.
3. Enter your Twitter Username, and configure the remaining options as you see fit.
4. Be sure to click Save, and you’re all done. Go back to your homepage and see the Twitter testimonials in all their glory!

= Widget Options =
* How many tweets would you like to display?: You can display up to 20 tweets
* Widget Title (optional): By default the title of the widget will be Tweet-stimonials, but you optionally change it here.
* Show Avatars: When checked, the Twitter avatars that correspond with each tweet will be displayed to the left of the tweet.
* Show Follow Me Link: This will display a Follow @username link at the bottom of the widget which will link directly to your Twitter page.
* Show View All Link: This will display a View All link at the bottom of the widget which will link directly to your Twitter favorites.

= Shortcode Example =
[tweetstimonials username="SPYRmedia" tweet_count="5" show_avatars="true" show_follow_me="true" show_view_all="true"]

== Frequently Asked Questions ==

= What version of PHP is supported? =
Tweet-stimonials requires at least PHP5.

== Changelog ==

= 3.1 =
* Updated (SPYR) Admin Library to v1.3

= 3.0 =
* Completely rewritten to accommodate Twitter API v1.1 Authentication
* New: [tweetstimonials] shortcode

= 2.0 =
* Completely rewritten

= 1.1 =
* Updated widget title to be properly tagged
* Added test for Twitter accessibility

= 1.0 =
* The first full version release of Tweet-stimonials

== Upgrade Notice ==

= 1.0 =
If you are using a pre-release version of Tweet-stimonials (0.9x) you should upgrade to this version which addresses all concerns related to Twitter API throttling.