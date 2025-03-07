<?php


Namespace Core;
use PDO;

class Database
{
    private static $instance = null;
    protected $conn;

    private function __construct($config)
    {
        try {
            $this->conn = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4", $config['username'], $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance(array $config = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this;
    }
    public function query($query, $params = [])
    {
        try{
        $stmt = $this->conn->prepare( $query);
        foreach ($params as $param => $value) {
//            inspectAndDie($query);
            $stmt->bindValue(':' . $param, $value);
        }
        $stmt->execute();
        return $stmt;
        }
        catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }
}
