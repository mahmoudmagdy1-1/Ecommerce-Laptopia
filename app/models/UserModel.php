<?php

Namespace App\models;

use Core\Database;

class UserModel
{
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function createUser($data)
    {
        $query = 'INSERT INTO Users (name, email, phone, password) VALUES (:name, :email, :phone, :password)';
        $this->db->query($query, $data);
    }

    public function getLastUserId()
    {
        return $this->db->query('SELECT MAX(user_id) AS last_id FROM Users')->fetch()->last_id;
    }


    public  function getUserByEmail($email)
    {
        $query = 'SELECT * FROM Users WHERE email = :email';
        return $this->db->query($query, ['email' => $email])->fetch();
    }

//    public  function getUserByID($id)
//    {
//        $query = 'SELECT * FROM Users WHERE user_id = :id';
//        return $this->db->query($query, ['id' => $id])->fetch();
//    }


}