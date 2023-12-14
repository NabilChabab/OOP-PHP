<?php
namespace App\config;

require '../../vendor/autoload.php';


class Database {
    private static $cnx;

    public static function connect() {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
  

        self::$cnx = mysqli_connect($_ENV['DB_SERVERNAME'], $_ENV['DB_USERNAME'],  $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

        if (!self::$cnx) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return self::$cnx;
    }
}
?>
