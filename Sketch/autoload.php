<?php
define("SKETCH_ROOT",__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR);                     // Define the Path to Sketch Root
define("SKETCH_CORE",__DIR__);           // Define the path to the Sketch Core

// You can use this trick to make autoloader look for commonly used ".php" type filenames
spl_autoload_extensions('.php');

// Use default autoload implementation
spl_autoload_register();

require_once 'vendor'.DIRECTORY_SEPARATOR."autoload.php";
