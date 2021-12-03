<?php

class Register implements JsonSerializable {

	private $conn;
	private $user_name;
	private $email;
	private $password;
	private $rol;
	private $tableName = 'users';

	function __construct( $user_name, $email, $password, $rol = 'user' )
	{
		$this->user_name = $user_name;
		$this->email     = $email;
		$this->password  = password_hash( $password, PASSWORD_BCRYPT );
		$this->rol       = $rol;

	}

	public function registerUser() {

		require_once( './database/database.php' );

		try {
			$db = new Database();
			$this->conn = $db->getConnection();

		} catch ( Exception $e ) {
			die( $e->getMessage() );
		}

		$query =
			"INSERT INTO birra.users (user_name, email, password, rol) VALUES ( ?, ?, ?, ? )";

		$stmt = $this->conn->prepare( $query );
		/*$stmt->bindParam(':user_name', $this->user_name );
		$stmt->bindParam(':email', $this->email );
		$stmt->bindParam(':password', $this->password );
		$stmt->bindParam(':rol', $this->rol );*/

			$eso = $stmt->execute( array($this->user_name, $this->email, $this->password, $this->rol) );
	
		if( $eso ){

			http_response_code( 200 );
			echo json_encode( array(
				'message' => 'User: ' . $this->user_name . ' was successfully registered.') );
		}
		else{

			http_response_code( 400 );
			echo json_encode( array( 'message' => 'Unable to register the user.' .$stmt->errorInfo()[1] ) );
		}
	}

	public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
