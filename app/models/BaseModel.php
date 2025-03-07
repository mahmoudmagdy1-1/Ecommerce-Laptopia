<?php

Namespace App\models;

use Core\Database;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
//        $this->db = ;
        $this->db = Database::getInstance($config)->getConnection();

    }

    public function getAll($table)
    {
        return $this->db->query("SELECT * FROM {$table}")->fetchAll();
    }

    public function getById($table, $id)
    {
        return $this->db->query("SELECT * FROM {$table} WHERE id = :id", ['id' => $id])->fetch();
    }
}