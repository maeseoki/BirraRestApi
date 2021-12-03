<?php
require_once( '../vendor/autoload.php' );
require_once( './database/database.php' );
require_once( './controller/register.php' );

$data = json_decode(file_get_contents("php://input"));
$firstName = $data->user_name;
$email = $data->email;
$password = $data->password;
$rol = $data->rol;

/*var_dump( $data );
echo $firstName;*/
	$register = new Register( $firstName, $email, $password, $rol );

	$register->registerUser();
