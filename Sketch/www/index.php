<?php
define("START_MEMORY",memory_get_usage(false));
define("START_TIME",microtime( true ));
chdir(dirname(__DIR__));                            // Everything is called from here (www)
define("SITE_ROOT",__DIR__);                        // Define the Site Root - so the www can be located
$path = explode("/Sketch/",SITE_ROOT);               // Get path to Sketch
define("SKETCH_ROOT",$path[0]);                     // Define the Path to Sketch Root
define("SKETCH_CORE",$path[0]."/Sketch");           // Define the path to the Sketch Core
include_once(SKETCH_ROOT."/Sketch/autoload.php");   // Get the autoloader
new Sketch\Sketch(include_once("config.php"));      // Start Sketch