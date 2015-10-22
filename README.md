# WPToggler

A simple WordPress plugin that lets you toggle exactly one option on and off.

## Installation

1. Download to your Wordpress plugin folder.
2. Activate plugin.
3. Modify your template file where you want the switch to take effect. (See example below.)
4. Toggle away.

## Example of how to use switch in template

Put this somewhere in your template file to switch between the two states.

```
<?php if (!get_option('WPToggler_VALUE')){ ?>
<h1>WPToggler is FALSE</h1>
<?php } else { ?>
<h1>WPToggler is TRUE</h1>
<?php } ?>

``` 