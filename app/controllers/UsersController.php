<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load UsersModel so it is available as $this->UsersModel
        $this->call->model('UsersModel');
    }

    /**
     * Retrieve all users and display them in the view.
     */
    public function index()
    {
        // UsersController -> UsersModel -> all() -> users table records
        $users = $this->UsersModel->all();

        // Pass the retrieved records to the view
        $data['users'] = $users;

        // Load the user view
        $this->call->view('users_view', $data);
    }
}