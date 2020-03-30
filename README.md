Simple Course Creator Front Display
=====================

View it on WordPress: (http://wordpress.org/plugins/simple-course-creator-front-display/)

This is an add-on plugin for use with the [Simple Course Creator](https://github.com/sdavismedia/simple-course-creator
) plugin.

Simple Course Creator is designed to easily link posts together in a series and output that series list in the content of each included post.

The Simple Course Creator Front Display add-on outputs that course name on each post listed on the blog, archives, and search results. If a post is not part of a course, nothing displays. SCC Front Display behaves just like a typical byline displaying post meta information. It will not show on the individual post.

### How It Works
---

SCC Front Display requires no settings. Once you install it, it works. However, it does have built-in customization options in the theme customizer.

### Theme Overrides
---

SCC Front Display will output complete sentences on your posts. You're in control of every word. The text that displays before your course name and after your course name can be filtered like so.

For the leading text:

```php
function your_filter_name( $content ) {
	$content = str_replace( 'This post is part of the', 'Course:', $content );
	return $content;
}
add_filter( 'course_leading_text', 'your_filter_name' );
```

For the trailing text:

```php
function your_other_filter_name( $content ) {
	$content = str_replace( 'course.', '', $content );
	return $content;
}
add_filter( 'course_trailing_text', 'your_other_filter_name' );
```

Those two filters will result in the following output:

![SCC Front Display Filtered](http://buildwpyourself.com/wp-content/uploads/edd/2014/04/sccfd-filtered.png)

Customize the output to have its own style or blend it in with your byline. The freedom is yours.

### Bugs and Contributions
---

If you notice any mistakes, feel free to fork the repo and submit a pull request with your corrections. The same is true of any features you feel should be added or changes that can be made. 

### License
---

This plugin, like WordPress, is licensed under the GPL. Do what you want with it. I seriously don't care. 

### Developer
---

I'm Sean. I've created a few little pieces of software. I'm not that easy to find online. That's by design.

Is this plugin useful to you? If so, please consider buying me a bag of coffee beans. Thank you much. [Donate via
 PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=52HQDSEUA542S)