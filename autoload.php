<?php
define("SKETCH_ROOT",__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR);                     // Define the Path to Sketch Root
define("SKETCH_CORE",__DIR__);           // Define the path to the Sketch Core

// You can use this trick to make autoloader look for commonly used ".php" type filenames
spl_autoload_extensions('.php');
    
    function sketch_autoload($class){
        if (0 !== strpos($class, 'Sketch')) {
            return;
        }
        $class = trim($class,"\\");
        $path = dirname(__FILE__).DIRECTORY_SEPARATOR.str_replace("\\",DIRECTORY_SEPARATOR,$class).'.php';
       
        if (!file_exists($path)) {
            return;
        }
        require $path;
        
    }
// Use default autoload implementation
spl_autoload_register('sketch_autoload');

require_once 'vendor'.DIRECTORY_SEPARATOR."autoload.php";