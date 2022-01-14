<?php
namespace V1\controller;
use V1\model\Register;

class RegisterController {

	function __construct()
	{
		$data = json_decode( file_get_contents( 'php://input' ) );
		$firstName = $data->user_name;
		$email = $data->email;
		$password = $data->password;
		$rol = $data->rol;

		$register = new Register( $firstName, $email, $password, $rol );
		$register->registerUser();
	}
}