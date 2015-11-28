<?php

class WPToggler {

  // Customize these fields to make the plugin more userfriendly

  static $plugin_name = "WPToggler"; // shown in menu and control panel.

  // values to use internally in the plugin, do not customize
  static $debug = false;

  static function activation() {

    // set all settings
    $optionsArr = array(
      self::$plugin_name . "_VALUE" => false,
      self::$plugin_name . "_title" => "WPToggler",
      self::$plugin_name . "_description" => "Switches the value of WPToggler_VALUE between false and true.",
      self::$plugin_name . "_switched_to_true" => "WPToggler_VALUE is now true.",
      self::$plugin_name . "_switched_to_false" => "WPToggler_VALUE is now false.",
      self::$plugin_name . "_option_label" => "Switch:",
      self::$plugin_name . "_option_label_true" => "The switch is true",
      self::$plugin_name . "_option_label_false" => "The switch is false"
    );

    foreach ($optionsArr as $key => $value) {
      $stored_value = get_option($key);
      if (empty($stored_value) || $stored_value == ""){
        update_option($key,$value);
      }
    }
  }

  static function add_message($message) {

    $messages = get_option(self::$plugin_name . "_MESSAGES");
    array_push($messages, date("Y-m-d H:i:s") . " - ".$message);

    // keep the amount of messages below 10
    if (count($messages) > 10) {
      $temp = array_shift($messages);
    }

    update_option(self::$plugin_name . "_MESSAGES", $messages);
  }

  static function deactivation() {
    update_option(self::$plugin_name . "_VALUE", false);
  }

  static function short_code( $atts ) {
    $a = shortcode_atts( array(
      'true' => 'something',
      'false' => 'something else',
    ), $atts );

    if (get_option(self::$plugin_name."_VALUE") == false){
      return "{$a['false']}";
    }else{
      return "{$a['true']}";
    }
  }
}

add_shortcode( 'wptoggler', 'WPToggler::short_code' );
