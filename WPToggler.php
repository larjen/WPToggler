<?php

/*
Plugin Name: WPToggler
Plugin URI: https://github.com/larjen/WPToggler
Description: A simple WordPress plugin that lets you toggle exactly one option on and off.
Author: Lars Jensen
Version: 1.0.1
Author URI: http://exenova.dk/
*/

include_once(__DIR__ . DIRECTORY_SEPARATOR . "includes". DIRECTORY_SEPARATOR . "main.php");

if (is_admin()) {

    // include admin ui
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "includes". DIRECTORY_SEPARATOR . "admin.php");

    // register activation and deactivation
    register_activation_hook(__FILE__, 'WPToggler::activation');
    register_deactivation_hook(__FILE__, 'WPToggler::deactivation');

}
