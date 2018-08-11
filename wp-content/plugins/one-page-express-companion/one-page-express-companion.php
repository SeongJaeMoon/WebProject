<?php
/* 
 *  Plugin Name: One Page Express Companion
 *  Author: Horea Radu
 *  Description: The One Page Express Companion plugin adds drag and drop page builder functionality to the One Page Express theme. 
 *
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Version: 1.2.5
 */

// Makse sure that the companion is not already active from another theme
if (!defined("OPE_COMPANION_AUTOLOAD")) {
    require_once __DIR__ . "/vendor/autoload.php";
    define("OPE_COMPANION_AUTOLOAD", true);
}

OnePageExpress\Companion::load(__FILE__);
