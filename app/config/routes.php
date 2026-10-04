<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/
/** @var object $router **/
// Old web routes (Lab 4) and migration routes are disabled for the API deployment.
// Run migrations from the CLI instead: php lava migration

// ===== API routes (Lab 6) =====
$router->post('/api/auth/register', 'AuthApiController::register');
$router->post('/api/auth/login', 'AuthApiController::login');
$router->post('/api/auth/refresh', 'AuthApiController::refresh');
$router->post('/api/auth/logout', 'AuthApiController::logout');
$router->get('/api/auth/me', 'AuthApiController::me');

$router->get('/api/products', 'ProductApiController::index');
$router->post('/api/products', 'ProductApiController::store');
$router->get('/api/products/{id}', 'ProductApiController::show')->where_number('id');
$router->put('/api/products/{id}', 'ProductApiController::update')->where_number('id');
$router->patch('/api/products/{id}', 'ProductApiController::update')->where_number('id');
$router->delete('/api/products/{id}', 'ProductApiController::destroy')->where_number('id');

// CORS preflight (needed by the React/Vue app)
$router->options('/api/auth/{action}', 'AuthApiController::preflight');
$router->options('/api/products', 'ProductApiController::preflight');
$router->options('/api/products/{id}', 'ProductApiController::preflight');