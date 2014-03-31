<?php
/**
 * SETUP FOR WEBSITE
 */
return array(
    'version'            => "4",

    'devmode'           => false,  // Set to True if needing to update entities - will run slow until enabled again
    'htaccess'          => true,   // Set this to false if  .htaccess or apache settings are not in effect

    // Ignore in URI for Paths
    "ignoreFolder"      => '',     // If in a user directory on the server - put in the ~username here
    "addtourl"          => '',     // The folder to add to urls - again use if in your username account
    
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
    'cache'             => false,   // Set to true once finished to cache javascript files
    'cacheseconds'      => 31536000,
    
    // Enable if the server is not gzipping - most do.
    'compress'          => false,   // Enable this to have php gzip the page - not needed if the server gzips already.
    
    'timezone'          => 'Pacific/Auckland', // Force the server to the right timezone - delete if not needed
);
