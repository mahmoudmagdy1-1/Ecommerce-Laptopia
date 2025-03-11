<?php

namespace App\models;

use Core\Database;

class UserModel
{
    protected $db;

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

    public function getUserByEmail($email)
    {
        $query = 'SELECT * FROM Users WHERE email = :email';
        return $this->db->query($query, ['email' => $email])->fetch();
    }

    public function getUserById($id)
    {
        $query = 'SELECT * FROM Users WHERE user_id = :id';
        return $this->db->query($query, ['id' => $id])->fetch();
    }

    public function getAllUsers()
    {
        $query = 'SELECT * FROM Users ORDER BY created_at DESC';
        return $this->db->query($query)->fetchAll();
    }

    public function getTotalUsers()
    {
        $query = 'SELECT COUNT(*) as count FROM Users';
        return $this->db->query($query)->fetch()->count;
    }

    public function deleteUser($userId)
    {
        $this->db->query('DELETE FROM Cart WHERE user_id = :user_id', ['user_id' => $userId]);

        $this->db->query('DELETE FROM Wishlist WHERE user_id = :user_id', ['user_id' => $userId]);

        $query = 'DELETE FROM Users WHERE user_id = :user_id';
        return $this->db->query($query, ['user_id' => $userId])->rowCount() > 0;
    }
}
