<?php

//RUN docker-php-ext-install pdo pdo_mysql
// restart apache


/*
Plugin Name: Lumen 3d
Description:
Author: You
Author URI:
Plugin URI:
*/

use App\Http\Controllers\FlightController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use FatPanda\Illuminate\Support\Facades\Hashids;
use FatPanda\Illuminate\Support\Exceptions\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Illuminate\Database\Capsule\Manager as Capsule;
// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;


//use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Config;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\Request as IlluminateRequest;

use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

require_once('vendor/autoload.php');
require_once('app/helpers.php');

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//$app = null;

call_user_func(function() {

	/* $adapter = new League\Flysystem\Adapter\Local(__DIR__.'/myfiles');
	$filesystem = new Filesystem($adapter); */

    //Debug::enable();
	$namespace = '3d';

	$version = 'v1';

	/**
	 * Create and/or get access to the Lumen application container.
	 * @param $make Can be null, a string, or a function.
	 * @return If `$make` is a string, returns Application::make($make); if `$make`
	 *   is a function, that function is invoked with the Application instance as the
	 *   first and only argument, returning the result of that function call; otherwise,
	 *   the Application instance is returned.
	 */
	$app = function($make) {
		static $app;
		if (empty($app)) {
			$app = require __DIR__.'/bootstrap/app.php';
		}
		if (is_callable($make)) {
			return $make($app);
		}
		return $make ? $app->make($make) : $app;
	};

	/**
	 * Register an activation hook that executions any database migrations.
	 */
	/* register_activation_hook(__FILE__, function() use ($app) {
		$app(function($app) {
			if (!Schema::hasTable('fpc_migrations')) {
				Artisan::call('migrate:install');
			}
			Artisan::call('migrate', ['--force' => '1']);
		});
	}); */





    $app(function($app) {});

    $connection = Config::get('database.connections.mysql');


    $Capsule = new Capsule;
    $Capsule->setAsGlobal();  //this is important
    $Capsule->addConnection($connection);
    $Capsule->bootEloquent();


    $symfonyRequest = SymfonyRequest::createFromGlobals();
    $request = IlluminateRequest::createFromBase($symfonyRequest);

    config(['app.wordpress_mode' => false]);
    clearstatcache();
    echo (new FlightController)->index($request); // routes here




});
