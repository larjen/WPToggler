=== WPToggler ===
Contributors: larjen
Donate link: http://exenova.dk/
Tags: Toggle
Requires at least: 4.3.1
Tested up to: 4.3.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple WordPress plugin that lets you toggle exactly one option on and off.

== Description ==

A simple WordPress plugin that lets you toggle exactly one option on and off.

== Installation ==

1. Download to your Wordpress plugin folder.
2. Activate plugin.
3. Modify your template file where you want the switch to take effect. (See example below.)
4. Toggle away.

Example of how to use switch in template

```
<?php if (!get_option('WPToggler_VALUE')){ ?>
<h1>WPToggler is FALSE</h1>
<?php } else { ?>
<h1>WPToggler is TRUE</h1>
<?php } ?>

```  

== Frequently Asked Questions ==

= Do I use this at my own risk? =

Yes.

== Screenshots ==

== Changelog ==

= 1.0.0 =
* Uploaded plugin.

== Upgrade Notice ==
