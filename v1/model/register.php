<?php
namespace V1\model;
use V1\database\Database;

/**
 * Register new user in database.
 * 
 * @since 1.0.0
 */
class Register {

	private $conn;
	private $user_name;
	private $email;
	private $password;
	private $rol;
	private $tableName = 'users';

	/**
	 * Constructs class, sets properties and starts db connection.
	 * 
	 * @param string $user_name User name for the new user.
	 * @param string $email     Email for the new user.
	 * @param string $password  Password for the new user.
	 * @param string $rol       New users role.
	 */
	function __construct( $user_name, $email, $password, $rol = 'user' )
	{
		$this->user_name = $user_name;
		$this->email     = $email;
		$this->password  = password_hash( $password, PASSWORD_BCRYPT );
		$this->rol       = $rol;

		try {
			$db = new Database();
			$this->conn = $db->getConnection();

		} catch ( \Exception $e ) {
			die( $e->getMessage() );
		}

	}

	/**
	 * Register the new user after checking duplicates.
	 * 
	 * @returns void
	 */
	public function registerUser() {

		if ( $this->checkDuplicate() ) {
		
			$query = "INSERT INTO $this->tableName (user_name, email, password, rol) VALUES ( ?, ?, ?, ? )";

			$stmt = $this->conn->prepare( $query );

			$result = $stmt->execute( array( $this->user_name, $this->email, $this->password, $this->rol ) );
		
			if( $result ){

				http_response_code( 200 );
				echo json_encode( array(
					'message' => 'El usuario: ' . $this->user_name . ' ha sido registrado correctamente.') );
				exit();
			}
			else{

				http_response_code( 400 );
				echo json_encode( array( 'message' => 'Imposible registrar al usuario.' .$stmt->errorInfo()[1] ) );
				exit();
			}
		};
	}

	/** 
	 * Check if user already exists by User Name or Email
	 * 
	 * @return true|void True if no duplicates or void http 400 error if user already exists.
	*/
	private function checkDuplicate() {
		$query = "SELECT 1 FROM $this->tableName WHERE user_name = ? OR email = ?";
		$stmt = $this->conn->prepare( $query );

		$stmt->execute( array( $this->user_name, $this->email ) );

		if ( $stmt->fetch() ) {
			http_response_code( 400 );
			echo json_encode(
				array(
					'message' => 'El usuario ya existe.',
					'errorCode'   => 3
				)
			);
		} else {
			return true;
		}
	}
}
