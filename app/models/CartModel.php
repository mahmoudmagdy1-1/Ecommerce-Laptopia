<?php

namespace App\models;

use Core\Database;

class CartModel
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function createCart($user_id)
    {
        $query = 'INSERT INTO Cart (user_id) VALUES (:user_id)';
        $this->db->query($query, ['user_id' => $user_id]);
    }

    public function addToCart($data)
    {
        $cartId = $this->getCartId($data['user_id']);
        // Insert cart item
        $query = 'INSERT INTO CartItems (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)';
        $this->db->query($query, [
            'cart_id' => $cartId,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity']
        ]);
    }

    public function deleteFromCart($data)
    {
        $query = 'DELETE FROM CartItems WHERE cart_id = :cart_id AND product_id = :product_id';
        $this->db->query($query, [
            'cart_id' => $this->getCartId($data['user_id']),
            'product_id' => $data['product_id']
        ]);
    }

    public function hasProductInCart($data)
    {
        $query = 'SELECT * FROM CartItems WHERE cart_id = :cart_id AND product_id = :product_id';
        $cartId = $this->getCartId($data['user_id']);
        return $this->db->query($query, ['cart_id' => $cartId, 'product_id' => $data['product_id']])->fetch();
    }

    public function editFromCart($data)
    {
        $query = 'UPDATE CartItems SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id';
        $this->db->query($query, [
            'cart_id' => $this->getCartId($data['user_id']),
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity']
        ]);
    }

    public function mergeCart($userId)
    {
        // Get the cart ID
        $cartId = $this->getCartId($userId);

        // Get the cart items from the database
        $dbCart = $this->getCartItems($cartId);

        // Get the cart items from the session
        $sessionCart = \Core\Session::get('cart') ?? [];

        // Merge the cart items
        $mergedCart = [];

        foreach ($dbCart as $item) {
            $mergedCart[$item->product_id] = (int)$item->quantity;
        }

        foreach ($sessionCart as $item) {
            $productId = $item['product_id'];
            $qty = (int)$item['quantity'];
            if (array_key_exists($productId, $mergedCart)) {
                $mergedCart[$productId] += $qty;
            } else {
                $mergedCart[$productId] = $qty;
            }
        }

        // Update the cart items in the database
        foreach ($mergedCart as $productID => $qty) {
            $newCart = [
                'user_id' => $userId,
                'product_id' => $productID,
                'quantity' => $qty
            ];
            if ($this->hasProductInCart([
                    'product_id' => $productID,
                    'user_id' => $userId
                ]
            )) {
                $this->editFromCart($newCart);
            } else {
                $this->addToCart($newCart);
            }
        }

        \Core\Session::delete('cart');
    }

    public function getCartID($userId)
    {
        $query = 'SELECT cart_id FROM Cart WHERE user_id = :user_id';
        $result = $this->db->query($query, ['user_id' => $userId])->fetch();
        return $result->cart_id ?? null;
    }

    public function getCartItems($cartId)
    {
        $query = 'SELECT * FROM CartItems WHERE cart_id = :cart_id';
        return $this->db->query($query, ['cart_id' => $cartId])->fetchAll();
    }
    public function clearCart($userId)
    {
        $query = 'DELETE FROM CartItems WHERE cart_id = :cart_id';
        $this->db->query($query, ['cart_id' => $this->getCartId($userId)]);
    }
}
