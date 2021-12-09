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
use V1\model\Register;

$path =  $_SERVER['REQUEST_URI'];
$routes = preg_split('#/#', $path, -1, PREG_SPLIT_NO_EMPTY);

switch ( $routes[2] ) {
	case 'register':
		registerUser();
		break;
	case 'login':
		login();
		break;
	default:
		throw new Exception( "Error de llamada a la API" );
		break;
}

function registerUser() {
	$data = json_decode(file_get_contents("php://input"));
	//var_dump($data);
	$firstName = $data->user_name;
	$email = $data->email;
	$password = $data->password;
	$rol = $data->rol;

	$register = new Register( $firstName, $email, $password, $rol );
	$register->registerUser();
}

function login() {
	echo 'Logueando';
}