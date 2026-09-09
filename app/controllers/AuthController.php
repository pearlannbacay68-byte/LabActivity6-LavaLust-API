<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('session');
    }

    public function login()
    {
        if ($this->session->userdata('logged_in') === true) {
            redirect('products');
            return;
        }

        $this->call->view('auth/login', [
            'error' => null
        ]);
    }

    public function authenticate()
    {
        $username = trim($this->request->post('username', ''));
        $password = trim($this->request->post('password', ''));

        if ($username === '' || $password === '') {
            $this->call->view('auth/login', [
                'error' => 'Username and password are required.'
            ]);
            return;
        }

        $valid_user = $username === 'bacaypearlann@gmail.com' && $password === '12345';

        if (!$valid_user) {
            $this->call->view('auth/login', [
                'error' => 'Invalid username or password.'
            ]);
            return;
        }

        $this->session->set_userdata([
            'logged_in' => true,
            'username' => $username
        ]);

        redirect('products');
    }

    public function logout()
    {
        $this->session->unset_userdata(['logged_in', 'username']);
        redirect('login');
    }
}
