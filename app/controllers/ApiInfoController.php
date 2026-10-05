<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiInfoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
    }

    public function index()
    {
        $this->api->require_method('GET');
        $this->api->respond([
            'name' => 'LavaLust Product Management API',
            'status' => 'ok',
            'version' => '1.0.0',
            'endpoints' => [
                'POST /api/auth/register',
                'POST /api/auth/login',
                'POST /api/auth/refresh',
                'POST /api/auth/logout',
                'GET /api/auth/me',
                'GET|POST /api/products',
                'GET|PUT|PATCH|DELETE /api/products/{id}',
            ],
        ]);
    }
}
