=== A/B Test for WordPress ===
Contributors: lassebunk
Donate link: http://lassebunk.dk/donate/
Tags: ab testing, split testing, multivariate testing, themes, content, stylesheets, javascripts
Stable tag: 1.0.2

A/B split testing for WordPress made easy.

== Description ==

A/B Test for WordPress is a free plugin that makes it easy to set up and perform A/B split testing on any WordPress site:

<a href="http://wordpress.org/extend/plugins/abtest/screenshots/"><img src="http://wordpress.org/extend/plugins/abtest/screenshot-1.png" alt="Screenshot 1" title="See more screenshots" /></a>

&rarr; [See a video demonstration of the plugin](http://lassebunk.dk/2012/01/14/ab-test-for-wordpress/) and [see more tutorials](http://lassebunk.dk/plugins/abtest/#tutorials)

You have the opportunity to test four types of content:

* **Content split test** – you set up a number of variations and insert a code in your post, page, widget, or theme where you want the variations to be.
* **Stylesheet split test** – you set up a number of different stylesheets to test, e.g. the color of ‘Read more’ or ‘Buy now’ buttons.
* **Javascript split test** – you set up a number of different javascripts to test. This enables testing almost anything on your site.
* **Theme split test** – you test between a number of themes.

Tracking goal completions:

* **Goal pages** – you insert a goal completion code in your pages, posts, or widgets.
* **Link clicks** – you track every click on a link, e.g. links to other sites.
* **Manual tracking** – you track goals manually via javascript.

You have access to a number of options to measure your split tests:

* **Built-in measuring** – use the built-in measurement statistics.
* **Custom measuring** – use Google Analytics or another of your choice.

[Download the plugin](http://downloads.wordpress.org/plugin/abtest.zip) (put it in your **wp-content/plugins** folder)

== Installation ==

1. Upload the `ab-test-for-wordpress` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Content is easily A/B split tested using this plugin.

== Changelog ==

= 1.0.0 =
* Initial version.

= 1.0.1 =
* Support for inserting name of the current displayed variation, e.g. <code>[abtest experiment="3" variable="name"]</code>.
* Support for split testing themes, e.g. which theme performs better.

= 1.0.2 =
* Support for IP filters, e.g. to filter out visits and conversions from your home or office IPs.

== Upgrade Notice ==

When upgrading, please deactivate and activate the plugin for the database to be updated.