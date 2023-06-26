<?php
final class Database
{

    private static $instance = null;
    private static $connection;

    private function __clone()
    {
    }
    private function __wakeup()
    {
    }
    private function __destruct()
    {
    }
    private function __construct()
    {
    }

    public static function connect($dbName, $host, $user, $password)
    {
        self::$connection = new PDO("mysql:dbname=$dbName;host=$host", $user, $password);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) 
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getConnection()
    {
        return self::$connection;
    }

    /* To connect to database:

   1. Database::connect('php', 'localhost', 'root', '');
   2. $dbh = new Database::getInstance();
   3. $dbc = $dbh->getConnection();
   4. private $db
   5. public function __construct()
    {
        $this->db = $db;
    }
   6. $stmt = $this->db->prepare();


    */
}
