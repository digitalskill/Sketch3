<?php
/**
 * SETUP FOR WEBSITE
 */
return array(
    'version'             => "4",
    'googleapi'          => true,   // CHANGE this to true to use googles API to load jQuery

    // Site Security                // Restrict access to site using basic auth
    'auth'               => false,
    'realm'              =>"sketch",
    'auth_username'      => "",
    'auth_password'      => "",

    'devmode'           => false,   // Set to True if needing to update entities - will run slow until enabled again
    'htaccess'          => false,   // Set this to false if  .htaccess or apache settings are not in effect

    // DATABASE CONNECTION
    'dbname'            => "sketch",
    'user'              => "sketch",
    'password'          => "apple167",
    'driver'            => "pdo_mysql",

    'entityFiles'       => 'Entities',
    'themePath'         => "theme",
    'cache'             => false,   // Set to true once finished to cache javascript files
    'cacheseconds'      => 31536000,
    'compress'          => false,   // Enable this to have php gzip the page - not needed if the server gzips already.
);
