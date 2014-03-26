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

    'devmode'           => true,    // Set to True if needing to show errors on the site -  into DEV MODE
    'htaccess'          => false,   // Set this to false if  .htaccess or apache settings are not in effect

    // DATABASE CONNECTION
    'dbname'            => "sketch",
    'user'              => "sketch",
    'password'          => "apple167",
    'driver'            => "pdo_mysql",

    'entityFiles'       => 'Entities',
    'themePath'         => "theme",
    'cache'             => false,
    'cacheseconds'      => 31536000,
    'compress'          => false,
);
