<?php

/*
  Plugin Name: WPToggler
  Plugin URI: https://github.com/larjen/WPToggler
  Description: A simple WordPress plugin that lets you toggle exactly one option on and off.
  Author: Lars Jensen
  Version: 1.0.0
  Author URI: http://exenova.dk/
 */


class WPToggler {
    
    // Customize these fields to make the plugin more userfriendly

    static $wptoggler_name = "WPToggler"; // shown in menu and control panel.
    static $wptoggler_description = "Switches the value of WPToggler_VALUE between false and true.";
    static $wptoggler_switched_to_true = "WPToggler_VALUE is now true.";
    static $wptoggler_switched_to_false = "WPToggler_VALUE is now false.";
    static $wptoggler_option_label = "Switch:";
    static $wptoggler_option_label_true = " The switch is true";
    static $wptoggler_option_label_false = " The switch is false:";    
    
    // values to use internally in the plugin, do not customize
    
    static $debug = false;
    static $plugin_salt = "WPToggler";

    static function activation() {

        update_option(self::$plugin_salt . "_VALUE", false);

    }

    static function add_message($message) {

        $messages = get_option(self::$plugin_salt . "_MESSAGES");
        array_push($messages, date("Y-m-d H:i:s") . " - ".$message);

        // keep the amount of messages below 10
        if (count($messages) > 10) {
            $temp = array_shift($messages);
        }

        update_option(self::$plugin_salt . "_MESSAGES", $messages);
    }

    static function deactivation() {

        update_option(self::$plugin_salt . "_VALUE", false);

    }

    static function plugin_menu() {
        
        add_management_page(self::$wptoggler_name, self::$wptoggler_name, 'activate_plugins', 'WPToggler', array('WPToggler', 'plugin_options'));
        
    }

    static function plugin_options() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        if (isset($_POST["TOGGLER"])) {
            if ($_POST["TOGGLER"] == 'on') {
                if (get_option(self::$plugin_salt . "_VALUE") == false) {
                    self::add_message(self::$wptoggler_switched_to_true);
                }
                update_option(self::$plugin_salt . "_VALUE", true);
            }

            if ($_POST["TOGGLER"] == 'off') {
                if (get_option(self::$plugin_salt . "_VALUE") == true) {
                    self::add_message(self::$wptoggler_switched_to_false);
                }
                update_option(self::$plugin_salt . "_VALUE", false);
            }
        }

        // debug
        if (self::$debug) {
            echo '<pre>';
            echo 'get_option("' . self::$plugin_salt . '_VALUE")=' . get_option(self::$plugin_salt . "_VALUE") . PHP_EOL;
            echo '</pre>';
        }

        // print the admin page
        echo '<div class="wrap">';
        echo '<h2>'. self::$wptoggler_name .'</h2>';
        echo '<p>'. self::$wptoggler_description . '</p>';
        
        $messages = get_option(self::$plugin_salt ."_MESSAGES");

        while (!empty($messages)) {
            $message = array_shift($messages);
            echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>' . $message . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Afvis denne meddelelse.</span></button></div>';
        }
        
        // since the messages has been shown, purge them.
        update_option(self::$plugin_salt ."_MESSAGES", []);

        echo '<form method="post" action="">';
        echo '<table class="form-table"><tbody>';

        echo '<tr valign="top"><th scope="row">'. self::$wptoggler_option_label .'</th><td><fieldset><legend class="screen-reader-text"><span>On</span></legend>';

        if (get_option(self::$plugin_salt . "_VALUE") == true) {
            echo '<label for="VALUE"><input checked="checked" id="VALUE" name="TOGGLER" type="radio" value="on"> '.self::$wptoggler_option_label_true.'</label><br /><legend class="screen-reader-text"><span>Off</span></legend><label for="DEVALUE"><input id="DEVALUE" name="TOGGLER" type="radio" value="off"> '.self::$wptoggler_option_label_false.'</label>';
        } else {
            echo '<label for="VALUE"><input id="VALUE" name="TOGGLER" type="radio" value="on"> '.self::$wptoggler_option_label_true.'</label><br /><legend class="screen-reader-text"><span>Off</span></legend><label for="DEVALUE"><input checked="checked" id="DEVALUE" name="TOGGLER" type="radio" value="off"> '.self::$wptoggler_option_label_false.'</label>';
        }

        echo '</fieldset></td></tr>';
        echo '</tbody></table>';

        echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
        echo '</form></div>';
    }

}

// register activation and deactivation
register_activation_hook(__FILE__, 'WPToggler::activation');
register_deactivation_hook(__FILE__, 'WPToggler::deactivation');

// register wp hooks
add_action('admin_menu', 'WPToggler::plugin_menu');