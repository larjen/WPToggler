<?php

class WPTogglerAdmin extends WPToggler {

  static function register_my_dashboard_widget(){
    wp_add_dashboard_widget('my_dashboard_widget','WPToggler','WPTogglerAdmin::my_dashboard_widget_display');
  }

  static function my_dashboard_widget_display() {
    if (!current_user_can('manage_options')) {
      echo '<div class="wrap"><p>You do not have sufficient permissions to access this page.</p></div>';
    } else {

      if (isset($_POST["TOGGLER"])) {
        if ($_POST["TOGGLER"] == 'on') {
          if (get_option(self::$plugin_name . "_VALUE") == false) {
            self::add_message(get_option(self::$plugin_name . "_switched_to_true"));
          }
          update_option(self::$plugin_name . "_VALUE", true);
        }

        if ($_POST["TOGGLER"] == 'off') {
          if (get_option(self::$plugin_name . "_VALUE") == true) {
            self::add_message(get_option(self::$plugin_name . "_switched_to_false"));
          }
          update_option(self::$plugin_name . "_VALUE", false);
        }
      }
      // print the admin page
      echo '<div class="wrap">';

      $messages = get_option(self::$plugin_name . "_MESSAGES");

      while (!empty($messages)) {
        $message = array_shift($messages);
        echo '<div class="updated settings-error notice is-dismissible"><p><strong>' . $message . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Afvis denne meddelelse.</span></button></div>';
      }

      // since the messages has been shown, purge them.
      update_option(self::$plugin_name . "_MESSAGES", []);

      echo '<p>'. get_option(self::$plugin_name . "_description") . '</p>';

      echo '<form method="post" action="">';
      echo '<table class="form-table"><tbody>';

      echo '<tr valign="top"><th scope="row">'. get_option(self::$plugin_name . "_option_label") .'</th><td><fieldset><legend class="screen-reader-text"><span>On</span></legend>';

      if (get_option(self::$plugin_name . "_VALUE") == true) {
        echo '<label for="VALUE"><input checked="checked" id="VALUE" name="TOGGLER" type="radio" value="on"> '. get_option(self::$plugin_name . "_option_label_true") .'</label><br /><legend class="screen-reader-text"><span>Off</span></legend><label for="DEVALUE"><input id="DEVALUE" name="TOGGLER" type="radio" value="off"> '.get_option(self::$plugin_name . "_option_label_false") .'</label>';
      } else {
        echo '<label for="VALUE"><input id="VALUE" name="TOGGLER" type="radio" value="on"> '.get_option(self::$plugin_name . "_option_label_true").'</label><br /><legend class="screen-reader-text"><span>Off</span></legend><label for="DEVALUE"><input checked="checked" id="DEVALUE" name="TOGGLER" type="radio" value="off"> '.get_option(self::$plugin_name . "_option_label_false") .'</label>';
      }

      echo '</fieldset></td></tr>';
      echo '</tbody></table>';

      echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
      echo '</form></div>';
    }
  }

  static function plugin_menu() {
    add_management_page(self::$plugin_name, self::$plugin_name, 'activate_plugins', 'WPTogglerAdmin', array('WPTogglerAdmin', 'plugin_options'));
  }

  /*
  * Plugin menu
  */

  static function plugin_options() {
    if (!current_user_can('manage_options')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // save all settings
    $optionsArr = array(self::$plugin_name . "_description", self::$plugin_name . "_switched_to_true", self::$plugin_name . "_switched_to_false", self::$plugin_name . "_option_label", self::$plugin_name . "_option_label_true", self::$plugin_name . "_option_label_false");
    foreach ($optionsArr as $value) {
      if (isset($_POST[$value])) {
        update_option($value, $_POST[$value]);
      }
    }
    // debug
    if (self::$debug) {
      echo '<pre>';
      echo 'get_option(self::$plugin_name."_description")=' . get_option(self::$plugin_name . "_description") . PHP_EOL;
      echo 'get_option(self::$plugin_name."_switched_to_true")=' . get_option(self::$plugin_name . "_switched_to_true") . PHP_EOL;
      echo 'get_option(self::$plugin_name."_switched_to_false")=' . get_option(self::$plugin_name . "_switched_to_false") . PHP_EOL;
      echo 'get_option(self::$plugin_name."_option_label")=' . get_option(self::$plugin_name . "_option_label") . PHP_EOL;
      echo 'get_option(self::$plugin_name."_option_label_true")=' . get_option(self::$plugin_name . "_option_label_true") . PHP_EOL;
      echo 'get_option(self::$plugin_name."_option_label_false")=' . print_r(get_option(self::$plugin_name . "_option_label_false")) . PHP_EOL;
      echo '</pre>';
    }

    // print the admin page
    echo '<div class="wrap">';
    echo '<h2>' . self::$plugin_name . '</h2>';

    $messages = get_option(self::$plugin_name . "_MESSAGES");

    while (!empty($messages)) {
      $message = array_shift($messages);
      echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>' . $message . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Afvis denne meddelelse.</span></button></div>';
    }

    // since the messages has been shown, purge them.
    update_option(self::$plugin_name . "_MESSAGES", []);

    echo '<form method="post" action="">';

    echo '<h3 class="title">WPToggler settings</h3>';
    echo '<p>From here you may customize the messages and options displayed in the dashboard widget.';
    echo '<table class="form-table"><tbody>';
    echo '<tr valign="top"><th scope="row"><label for="' . self::$plugin_name . '_description">Description for the toggle switch</label></th><td><input id="' . self::$plugin_name . '_description" name="' . self::$plugin_name . '_description" type="text" value="' . get_option(self::$plugin_name . "_description") . '" class="regular-text"></td></tr>';
    echo '<tr valign="top"><th scope="row"><label for="' . self::$plugin_name . '_switched_to_true">Message to display when switched to true</label></th><td><input id="' . self::$plugin_name . '_switched_to_true" name="' . self::$plugin_name . '_switched_to_true" type="text" value="' . get_option(self::$plugin_name . "_switched_to_true") . '" class="regular-text"></td></tr>';
    echo '<tr valign="top"><th scope="row"><label for="' . self::$plugin_name . '_switched_to_false">Message to display when switched to false</label></th><td><input id="' . self::$plugin_name . '_switched_to_false" name="' . self::$plugin_name . '_switched_to_false" type="text" value="' . get_option(self::$plugin_name . "_switched_to_false") . '" class="regular-text"></td></tr>';
    echo '<tr valign="top"><th scope="row"><label for="' . self::$plugin_name . '_option_label">Label for the switch</label></th><td><input id="' . self::$plugin_name . '_option_label" name="' . self::$plugin_name . '_option_label" type="text" value="' . get_option(self::$plugin_name . "_option_label") . '" class="regular-text"></td></tr>';
    echo '<tr valign="top"><th scope="row"><label for="' . self::$plugin_name . '_option_label_true">Label for switch when true</label></th><td><input id="' . self::$plugin_name . '_option_label_true" name="' . self::$plugin_name . '_option_label_true" type="text" value="' . get_option(self::$plugin_name . "_option_label_true") . '" class="regular-text"></td></tr>';
    echo '<tr valign="top"><th scope="row"><label for="' . self::$plugin_name . '_option_label_false">Label for switch when false</label></th><td><input id="' . self::$plugin_name . '_option_label_false" name="' . self::$plugin_name . '_option_label_false" type="text" value="' . get_option(self::$plugin_name . "_option_label_false") . '" class="regular-text"></td></tr>';
    echo '</tbody></table>';

    echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
    echo '</form></div>';
  }
}

add_action( 'wp_dashboard_setup', 'WPTogglerAdmin::register_my_dashboard_widget' );

// register wp hooks
add_action('admin_menu', 'WPTogglerAdmin::plugin_menu');
