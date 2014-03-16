<?php
// Update Include path for Sketch
set_include_path(get_include_path().":".SKETCH_ROOT);

// You can use this trick to make autoloader look for commonly used ".php" type filenames
spl_autoload_extensions('.php');

// Use default autoload implementation
spl_autoload_register();

require_once("vendor/autoload.php");