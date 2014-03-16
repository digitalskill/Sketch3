<?php
chdir(dirname(__DIR__));
define("SITE_ROOT",__DIR__);
$path = explode("Sketch",SITE_ROOT);
define("SKETCH_ROOT",$path[0]."Sketch");        // Define the Path to Sketch Core
define("SKETCH_CORE",SKETCH_ROOT."/Sketch");
include_once(SKETCH_CORE."/autoload.php");      // Get the autoloader
new \Sketch\Sketch(include_once("config.php")); // Start Sketch