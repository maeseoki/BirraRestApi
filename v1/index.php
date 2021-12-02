<?php
require_once( '../vendor/autoload.php' );
require_once( './database/database.php' );
$db = new Database();

$conn = $db->getConnection();
