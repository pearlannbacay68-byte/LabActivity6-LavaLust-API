<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->library('session');
    }

    private function session()
    {
        return lava_instance()->session;
    }

    public function index()
    {
        $this->call->view('home', [
            'logged_in' => $this->session()->userdata('logged_in') === true,
        ]);
    }

    public function login()
    {
        if ($this->session()->userdata('logged_in') === true) {
            redirect('products');
            return;
        }

        $this->call->view('auth/login');
    }

    public function register()
    {
        if ($this->session()->userdata('logged_in') === true) {
            redirect('products');
            return;
        }

        $this->call->view('auth/register');
    }

    public function create_account()
    {
        $postedUsername = $this->request->post('username', '');
        $postedEmail = $this->request->post('email', '');
        $postedPassword = $this->request->post('password', '');
        $username = is_string($postedUsername) ? trim($postedUsername) : '';
        $email = is_string($postedEmail) ? trim($postedEmail) : '';
        $password = is_string($postedPassword) ? $postedPassword : '';
        $formData = ['username' => $username, 'email' => $email];

        if ($username === '' || $email === '' || $password === '') {
            $this->call->view('auth/register', [
                'error' => 'Username, email, and password are required.',
                'form' => $formData,
            ]);
            return;
        }

        if (strlen($username) > 100 || strlen($email) > 255) {
            $this->call->view('auth/register', [
                'error' => 'Username must be 100 characters or fewer and email must be 255 characters or fewer.',
                'form' => $formData,
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->call->view('auth/register', [
                'error' => 'Enter a valid email address.',
                'form' => $formData,
            ]);
            return;
        }

        if (strlen($password) < 6) {
            $this->call->view('auth/register', [
                'error' => 'Password must be at least 6 characters.',
                'form' => $formData,
            ]);
            return;
        }

        $exists = $this->db->raw(
            'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$username, $email]
        )->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $this->call->view('auth/register', [
                'error' => 'Username or email already exists.',
                'form' => $formData,
            ]);
            return;
        }

        $this->db->raw(
            'INSERT INTO users (username, email, password) VALUES (?, ?, ?)',
            [$username, $email, password_hash($password, PASSWORD_DEFAULT)]
        );

        $this->call->view('auth/login', [
            'success' => 'Account created. Sign in with your new account.',
            'username' => $username,
        ]);
    }

    public function authenticate()
    {
        $login = trim($this->request->post('username', ''));
        $password = $this->request->post('password', '');

        if ($login === '' || $password === '') {
            $this->call->view('auth/login', ['error' => 'Username and password are required.']);
            return;
        }

        $user = $this->db->raw(
            'SELECT id, username, email, password, role, is_active
             FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$login, $login]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->call->view('auth/login', ['error' => 'Invalid username or password.']);
            return;
        }

        if (isset($user['is_active']) && (int) $user['is_active'] === 0) {
            $this->call->view('auth/login', ['error' => 'This account is disabled.']);
            return;
        }

        $session = $this->session();
        $session->regenerate_on_login();
        $session->set_userdata([
            'user_id' => (int) $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true,
        ]);

        redirect('products');
    }

    public function logout()
    {
        $this->session()->sess_destroy();
        redirect('login');
    }
}
