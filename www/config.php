<?php
/**
 * SETUP FOR WEBSITE
 */
return array(
    'version'            => "4",

    'devmode'           => false,  // Set to True if needing to update entities - will run slow until enabled again
    'htaccess'          => false,  // Set this to false if  .htaccess or apache settings are not in effect

    // DATABASE CONNECTION
    'dbname'            => "sketch",
    'user'              => "sketch",
    'password'          => "sketch",
    'driver'            => "pdo_mysql",

    // Database Entity Files
    'entityFiles'       => 'Entities',
    
    // Theme path
    'themePath'         => "theme",
    
    // Root Page of the site (landing page)
    'landingstub'       => "home",

    // Cache
    'cache'             => true,   // Set to true once finished to cache javascript files
    'cacheseconds'      => 31536000,
    
    // Enable if the server is not gzipping - most do.
    'compress'          => false,   // Enable this to have php gzip the page - not needed if the server gzips already.
);
