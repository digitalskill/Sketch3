<?php
define("SKETCH_ROOT",__DIR__.FOLDER_SEPERATOR."..".FOLDER_SEPERATOR);                     // Define the Path to Sketch Root
define("SKETCH_CORE",__DIR__);           // Define the path to the Sketch Core
// Update Include path for Sketch
set_include_path(SKETCH_ROOT.INCLUDE_SEPERATOR.SKETCH_CORE.INCLUDE_SEPERATOR.get_include_path());

// You can use this trick to make autoloader look for commonly used ".php" type filenames
spl_autoload_extensions('.php');

// Use default autoload implementation
spl_autoload_register();

require_once("vendor/autoload.php");