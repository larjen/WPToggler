<?php

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

include_once(__DIR__ . DIRECTORY_SEPARATOR . "includes". DIRECTORY_SEPARATOR . "main.php");

class WPTogglerUninstall extends WPToggler {
    static function uninstall() {
        self::deactivation();

        // delete all settings
        $optionsArr = array(
          self::$plugin_name . "_title",
          self::$plugin_name . "_MESSAGES",
          self::$plugin_name . "_VALUE",
          self::$plugin_name . "_description",
          self::$plugin_name . "_switched_to_true",
          self::$plugin_name . "_switched_to_false",
          self::$plugin_name . "_option_label",
          self::$plugin_name . "_option_label_true",
          self::$plugin_name . "_option_label_false"
        );
        foreach ($optionsArr as $key) {
            delete_option($key);
        }

    }
}

WPTogglerUninstall::uninstall();
