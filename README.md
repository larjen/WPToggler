# WPToggler

A simple WordPress plugin that lets you toggle exactly one option on and off.

## Installation

1. Download to your Wordpress plugin folder and unzip.
2. Activate plugin.
3. Use the shortcode in your posts to switch between to alternate texts depending on the setting of the switch.
4. Toggle away.

## How to use the shortcode

In your post type in something like this:

    [wptoggler true="This text will be displayed when true" false="This text will be displayed when false"]

This will toggle the text in the post to your liking.

## Example of how to use switch in template

This option is only meant for theme developers. If you put this somewhere in your template file to switch between the two states.

    <?php if (!get_option('WPToggler_VALUE')){ ?>
    <h1>WPToggler is FALSE</h1>
    <?php } else { ?>
    <h1>WPToggler is TRUE</h1>
    <?php } ?>

## Changelog


### 1.0.2
* Added option to rename dashboard widget.

### 1.0.1
* Added dashboard widget, so control is at the dashboard.
* Added fully customizable textual control to the plugin settings page.
* Added the ability to use the shortcodes in blog posts.

### 1.0.0
* Uploaded the plugin
