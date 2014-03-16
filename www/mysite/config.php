<?php 
/**
 * SETUP FOR WEBSITE
 */
return array(
     'directory'           => true,
     'version'             => "4",
     'ignore'              => "",    // Set this to the directory being used to develop the site
     'PathTosketch'        => "",    // This must be the server path to folder with the sketch-system file or leave empty for stand alone version
     'themePath'           => "",    // The default theme path for sketch - use if no Database is present
        /* FORCE removal from url
                Use remove_from_path if the site is in two different locations - BUT using the same database
                Then one of them in a root location may need to ignore the database folder settings
                eg. One server may have the site in a folder and the other does not
        */
    'remove_from_path'   => "",     // Set this value to a folder or path that must not appear in the url
    'googleapi'          => true,   // CHANGE this to true to use googles API to load jQuery
    'cache'              => true,   // Change this true when completed developing CSS and javascript
    'proxy_css_js'       => true,   // Change this false if you dont want proxies serving css and javascript pages
    'www'                => false,  // It will just add "www" to all sketch->urlPath() calls and Style sheet image urls

    // Site Security                // Restrict access to site using basic auth
    'auth'               => false,
    'realm'              =>"sketch",
    'auth_username'      => "",
    'auth_password'      => "",

    'devmode'           => true,   // Set to True if needing to show errors on the site -  into DEV MODE
    'htaccess'          => false,   // Set this to false if  .htaccess or apache settings are not in effect

    'compress'          => true,    // GZIP output to save bandwidth
    'salt'              => '',      // Encrypt passwords

    // DATABASE CONNECTION
    'dbname'            => "sketch",
    'user'              => "sketch",
    'password'          => "apple167",
    'driver'            => "pdo_mysql",
    
    'entityFiles'       => 'Entities',
    
    'cacheseconds'      => 31536000,
    
);