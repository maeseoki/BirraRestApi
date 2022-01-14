<?php
/**
 * Entry point to all api calls. Endpoints:
 * 
 * /v1/register POST user_name, email, password, rol
 * /v1/login    POST user_name, password
 * /v1/beers    GET
 * /v1/beers/search GET q
 * /v1/beers/insert POST
 * /v1/beers/delete DELETE
 * /v1/beers/update UPDATE
 */
require_once( '../vendor/autoload.php' );
use V1\controller\RegisterController;

/**
 * Extract routes to the api.
 */
$path =  $_SERVER['REQUEST_URI'];
$routes = preg_split('#/#', $path, -1, PREG_SPLIT_NO_EMPTY);

/**
 * Initialize controllers depending on route.
 */
switch ( $routes[2] ) {
	case 'register':
		try {
			new RegisterController;
		} catch (\Throwable $th) {
			http_response_code( 500 );
			throw $th;
			exit;
		}
		break;
	case 'login':
		login();
		break;
	default:
		throw new Exception( "Error de llamada a la API" );
		break;
}

function login() {
	echo 'Logueando';
}