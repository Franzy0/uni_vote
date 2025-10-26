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
$router->get('/', 'AuthController::login');

# Authentication routes
$router->match('/auth/login', 'AuthController::login', ['GET', 'POST']);
$router->match('/auth/register', 'AuthController::register', ['GET', 'POST']);
$router->get('/auth/logout', 'AuthController::logout');

# Voter routes
$router->get('/vote', 'VoteController::index');
$router->post('/vote/submit', 'VoteController::submitVote');
$router->get('/vote/confirmation', 'VoteController::confirmation');

# Admin routes
$router->match('/admin/login', 'AuthController::adminLogin', ['GET', 'POST']);
$router->get('/admin/dashboard', 'AdminController::dashboard');
$router->match('/admin/candidates', 'AdminController::manageCandidates', ['GET', 'POST']);
$router->get('/admin/delete/(:num)', 'AdminController::deleteCandidate/$1');
$router->get('/admin/results', 'AdminController::results');
$router->get('/admin/export/csv', 'AdminController::exportCSV');
$router->get('/admin/export/pdf', 'AdminController::exportPDF');