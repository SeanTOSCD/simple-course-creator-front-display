=== Simple Course Creator Front Display ===
Contributors: sdavis2702
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=52HQDSEUA542S
Tags: customizer, series, course, lesson, taxonomy, sdavis2702
Requires at least: 3.8
Tested up to: 5.3
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Outputs the course name on each post listed on a blog home, archive page, or search results page.

== Description ==

This plugin must be used with [Simple Course Creator](http://wordpress.org/plugins/simple-course-creator/).

By default, the only way to know that a post is part of a Simple Course Creator course is by viewing the individual post page or another post in the same course. This add-on allows you to see if a post is part of a course in "byline" fashion. The name of the course a post is part of can be seen from the blog home, archive, or search results.

== Installation ==

1. Upload `simple-course-creator-front-display` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. [Optional] Customizer options under the 'Appearance -> Customizer' menu

Follow Simple Course Creator Post Meta on [Github](https://github.com/sdavismedia/simple-course-creator-front-display)

== Frequently Asked Questions ==

= Can I customize the output? =

Yes. You can filter the text that displays both before and after the course name. [See documentation](https://github.com/SDavisMedia/simple-course-creator-front-display#theme-overrides).

= Does this plugin add customizer options for the Front Display output? =

Yes.

= What if I already have Simple Course Creator Customizer installed? =

The Front Display customizer options will be merged with SCC Customizer.

== Screenshots ==

1. customizer settings and output

== Changelog ==

= 1.0.5 =
* Added: allow front display message to link directly to Course archive
* Improved: compatibility with latest WordPress versions and Simple Course Creator 1.0.7+

= 1.0.4 =
* Fixed: PHP notices in Customizer

= 1.0.3 =
* improved: removed white space

= 1.0.2 =
* improved: user input sanitization

= 1.0.1 =
* fixed: languages directory path

= 1.0.0 =
* first stable version