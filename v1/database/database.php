<?php
/**
 * Class used to get the MariaDB/MySQL database connection
 * 
 * @since 1.0.0
 */
class Database{

	private $dotenv;
    private $db_host;
	private $db_port;
    private $db_name;
    private $db_user;
    private $db_password;
    private $connection;

	public function __construct()
	{
		$this->dotenv = Dotenv\Dotenv::createImmutable('..');
		$this->dotenv->load();

		$this->db_host = $_ENV['DB_HOST'];
		$this->db_port = $_ENV['DB_PORT'];
		$this->db_name = $_ENV['DB_NAME'];
		$this->db_user = $_ENV['DB_USER'];
		$this->db_password = $_ENV['DB_PASSWORD'];
	}

    public function getConnection(){

        $this->connection = null;

        try{
            $this->connection = new PDO( "mysql:host=" . $this->db_host . ";port=" . $this->db_port . ";dbname=" . $this->db_name, $this->db_user, $this->db_password );
        }catch( PDOException $exception ){
            echo "Fallo en la connexión: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>