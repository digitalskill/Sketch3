<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
chdir(dirname(__DIR__));                        // Everything is called from here (www)
define("SITE_ROOT",__DIR__);                    // Define the Site Root - so the www can be located
include_once 'autoload.php';                    // Get the autoloader
new Sketch\Sketch(include_once("config.php"));  // Start Sketch