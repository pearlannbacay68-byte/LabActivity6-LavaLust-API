<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->library('api');

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        // Every product endpoint requires a valid access token
        $this->api->require_jwt();
    }

    public function preflight() {}

    private function find($id)
    {
        return $this->db->raw(
            "SELECT * FROM products WHERE id = ? LIMIT 1",
            [$id]
        )->fetch(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $this->api->require_method('GET');

        $rows = $this->db->raw("SELECT * FROM products ORDER BY id DESC")
                         ->fetchAll(PDO::FETCH_ASSOC);

        $this->api->respond(['data' => $rows]);
    }

    public function show($id)
    {
        $this->api->require_method('GET');

        $product = $this->find($id);
        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }

        $this->api->respond(['data' => $product]);
    }

    public function store()
    {
        $this->api->require_method('POST');
        $data = $this->api->body();

        $name        = $data['product_name'] ?? '';
        $description = $data['description'] ?? '';
        $price       = $data['price'] ?? '';
        $quantity    = $data['quantity'] ?? '';

        if ($name === '' || strlen($name) > 100) {
            $this->api->respond_error('product_name is required (max 100 characters)', 422);
        }
        if (!is_numeric($price) || $price < 0) {
            $this->api->respond_error('price must be a number >= 0', 422);
        }
        if (filter_var($quantity, FILTER_VALIDATE_INT) === false || $quantity < 0) {
            $this->api->respond_error('quantity must be a whole number >= 0', 422);
        }

        $this->db->raw(
            "INSERT INTO products (product_name, description, price, quantity) VALUES (?, ?, ?, ?)",
            [$name, $description, $price, (int) $quantity]
        );

                $new_id = $this->db->raw("SELECT LAST_INSERT_ID() AS id")->fetch(PDO::FETCH_ASSOC)['id'];

        $this->api->respond([
            'message' => 'Product created',
            'data'    => $this->find((int) $new_id),
        ], 201);
    }

    // Handles both PUT (all fields) and PATCH (any fields)
    public function update($id)
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? '';
        if (!in_array($method, ['PUT', 'PATCH'], true)) {
            $this->api->respond_error('Method Not Allowed', 405);
        }

        $product = $this->find($id);
        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }

        $data = $this->api->body();

        if ($method === 'PUT') {
            foreach (['product_name', 'price', 'quantity'] as $field) {
                if (!isset($data[$field]) || $data[$field] === '') {
                    $this->api->respond_error("{$field} is required for PUT", 422);
                }
            }
        }

        $name        = $data['product_name'] ?? $product['product_name'];
        $description = $data['description']  ?? $product['description'];
        $price       = $data['price']        ?? $product['price'];
        $quantity    = $data['quantity']     ?? $product['quantity'];

        if ($name === '' || strlen($name) > 100) {
            $this->api->respond_error('product_name must be 1-100 characters', 422);
        }
        if (!is_numeric($price) || $price < 0) {
            $this->api->respond_error('price must be a number >= 0', 422);
        }
        if (filter_var($quantity, FILTER_VALIDATE_INT) === false || $quantity < 0) {
            $this->api->respond_error('quantity must be a whole number >= 0', 422);
        }

        $this->db->raw(
            "UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ? WHERE id = ?",
            [$name, $description, $price, (int) $quantity, $id]
        );

        $this->api->respond([
            'message' => 'Product updated',
            'data'    => $this->find($id),
        ]);
    }

    public function destroy($id)
    {
        $this->api->require_method('DELETE');

        if (!$this->find($id)) {
            $this->api->respond_error('Product not found', 404);
        }

        $this->db->raw("DELETE FROM products WHERE id = ?", [$id]);

        $this->api->respond(['message' => 'Product deleted']);
    }
}