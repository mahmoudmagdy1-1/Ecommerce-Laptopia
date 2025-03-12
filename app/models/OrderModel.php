<?php

namespace App\models;

use Core\Database;

class OrderModel
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/_db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function makeOrder($user_id)
    {
        $query = 'INSERT INTO Orders (user_id) VALUES (:user_id)';
        $this->db->query($query, ['user_id' => $user_id]);
    }

    public function getLastOrderId($user_id)
    {
        $query = 'SELECT MAX(order_id) AS last_id FROM Orders WHERE user_id = :user_id';
        return $this->db->query($query, ['user_id' => $user_id])->fetch()->last_id;
    }

    public function addOrderItem($data)
    {
        $query = 'INSERT INTO OrderItems (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)';
        $this->db->query($query, $data);
    }

    public function getOrderById($orderID)
    {
        $query = 'SELECT * FROM Orders WHERE order_id = :order_id';
        return $this->db->query($query, ['order_id' => $orderID])->fetch();
    }

    public function getOrderItems($orderID)
    {
        $query = 'SELECT * FROM OrderItems WHERE order_id = :order_id';
        return $this->db->query($query, ['order_id' => $orderID])->fetchAll();
    }

    public function getOrdersByUserId($userID)
    {
        $query = 'SELECT * FROM Orders WHERE user_id = :user_id';
        return $this->db->query($query, ['user_id' => $userID])->fetchAll();
    }

    public function getAllOrders()
    {
        $query = 'SELECT o.*, u.name as user_name, u.email as user_email 
                 FROM Orders o 
                 JOIN Users u ON o.user_id = u.user_id 
                 ORDER BY o.created_at DESC';
        return $this->db->query($query)->fetchAll();
    }

    public function getTotalOrders()
    {
        $query = 'SELECT COUNT(*) as count FROM Orders';
        return $this->db->query($query)->fetch()->count;
    }

    public function getRecentOrders($limit = 5)
    {
        $query = 'SELECT o.*, u.name as user_name, u.email as user_email 
                 FROM Orders o 
                 JOIN Users u ON o.user_id = u.user_id 
                 ORDER BY o.created_at DESC 
                 LIMIT :limit';
        return $this->db->query($query, ['limit' => $limit])->fetchAll();
    }

    public function updateOrderStatus($orderId, $status)
    {
        $query = 'UPDATE Orders SET status = :status WHERE order_id = :order_id';
        $params = [
            'status' => $status,
            'order_id' => $orderId
        ];
        return $this->db->query($query, $params)->rowCount() > 0;
    }

    public function getShippingByOrderId($orderId)
    {
        $query = 'SELECT * FROM Shipping WHERE order_id = :order_id';
        return $this->db->query($query, ['order_id' => $orderId])->fetch();
    }

    public function getPaymentByOrderId($orderId)
    {
        $query = 'SELECT * FROM Payments WHERE order_id = :order_id';
        return $this->db->query($query, ['order_id' => $orderId])->fetch();
    }

    public function updateShippingStatus($shippingId, $status)
    {
        $query = 'UPDATE Shipping SET status = :status WHERE shipping_id = :shipping_id';
        $params = [
            'status' => $status,
            'shipping_id' => $shippingId
        ];
        return $this->db->query($query, $params)->rowCount() > 0;
    }

    public function updatePaymentStatus($paymentId, $status)
    {
        $query = 'UPDATE Payments SET status = :status WHERE payment_id = :payment_id';
        $params = [
            'status' => $status,
            'payment_id' => $paymentId
        ];
        return $this->db->query($query, $params)->rowCount() > 0;
    }
}
