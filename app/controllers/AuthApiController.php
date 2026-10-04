<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->library('api');

        // Browser preflight request (CORS headers are already sent by the api library)
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }

    public function preflight() {}

    public function register()
    {
        $this->api->require_method('POST');
        $data = $this->api->body();

        $username = $data['username'] ?? '';
        $email    = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if ($username === '' || $email === '' || $password === '') {
            $this->api->respond_error('username, email and password are required', 422);
        }
        if (!filter_var(htmlspecialchars_decode($email), FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('Invalid email address', 422);
        }
        if (strlen($password) < 6) {
            $this->api->respond_error('Password must be at least 6 characters', 422);
        }

        $exists = $this->db->raw(
            "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1",
            [$username, $email]
        )->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $this->api->respond_error('Username or email already exists', 409);
        }

        $this->db->raw(
            "INSERT INTO users (username, email, password) VALUES (?, ?, ?)",
            [$username, $email, password_hash($password, PASSWORD_DEFAULT)]
        );

                $new_id = $this->db->raw("SELECT LAST_INSERT_ID() AS id")->fetch(PDO::FETCH_ASSOC)['id'];

        $this->api->respond([
            'message' => 'Account created successfully',
            'user'    => ['id' => (int) $new_id, 'username' => $username, 'email' => $email],
        ], 201);
    }

    public function login()
    {
        $this->api->require_method('POST');
        $data = $this->api->body();

        $login    = $data['username'] ?? ($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if ($login === '' || $password === '') {
            $this->api->respond_error('username and password are required', 422);
        }

        $user = $this->db->raw(
            "SELECT id, username, email, password, role, is_active
             FROM users WHERE username = ? OR email = ? LIMIT 1",
            [$login, $login]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->api->respond_error('Invalid credentials', 401);
        }
        if (isset($user['is_active']) && (int) $user['is_active'] === 0) {
            $this->api->respond_error('Account is disabled', 403);
        }

        $tokens = $this->api->issue_tokens([
            'id'   => $user['id'],
            'role' => $user['role'],
        ]);

        $this->api->respond(array_merge($tokens, [
            'message' => 'Login successful',
            'user'    => [
                'id'       => $user['id'],
                'username' => $user['username'],
                'email'    => $user['email'],
                'role'     => $user['role'],
            ],
        ]));
    }

    public function refresh()
    {
        $this->api->require_method('POST');
        $data = $this->api->body();

        if (empty($data['refresh_token'])) {
            $this->api->respond_error('refresh_token is required', 422);
        }

        // Responds with a new token pair by itself
        $this->api->refresh_access_token($data['refresh_token']);
    }

    public function logout()
    {
        $this->api->require_method('POST');
        $this->api->require_jwt();
        $data = $this->api->body();

        if (!empty($data['refresh_token'])) {
            $this->api->revoke_refresh_token($data['refresh_token']);
        }

        $this->api->respond(['message' => 'Logged out successfully']);
    }

    public function me()
    {
        $this->api->require_method('GET');
        $auth = $this->api->require_jwt();

        $user = $this->db->raw(
            "SELECT id, username, email, role FROM users WHERE id = ? LIMIT 1",
            [$auth['sub']]
        )->fetch(PDO::FETCH_ASSOC);

        $this->api->respond(['user' => $user]);
    }
}