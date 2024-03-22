<?php

global $table_prefix;

if (!$table_prefix) $table_prefix = 'wp_';

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', "localhost"),
            'port'      => 3306,
            'database'  => env('DB_DATABASE', "wordpress"),
            'username'  => env('DB_USERNAME', "wordpress"),
            'password'  => env('DB_PASSWORD', "wordpress"),
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => env('DB_WP_PREFIX', ''),
            'strict'    => false,
        ],

        /* 'mysql' => [
            'driver'    => 'mysql',
            'host'      => @constant('DB_HOST') ?: '127.0.0.1',
            'port'      => env('DB_PORT', 3306),
            'database'  => @constant('DB_NAME')?: 'wordpress',
            'username'  => @constant('DB_USER')?: 'wordpress',
            'password'  => @constant('DB_PASSWORD')?: 'wordpress',
            'charset'   => @constant('DB_CHARSET')?: 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => $table_prefix,
            'strict'    => false,
        ], */

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'fpc_migrations',

];