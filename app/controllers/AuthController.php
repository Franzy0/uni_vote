<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('VoterModel');
        $this->call->model('AdminModel');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Show login page
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // reCAPTCHA validation (optional)
            if (!empty($_POST['g-recaptcha-response'])) {
                // Add your Google reCAPTCHA key here
            }

            $voter = $this->VoterModel->authenticate($email, $password);
            $admin = $this->AdminModel->authenticate($email, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                redirect('/admin/dashboard');
            } elseif ($voter) {
                $_SESSION['voter_id'] = $voter['id'];
                redirect('/vote');
            } else {
                $this->call->view('auth/login', ['error' => 'Invalid credentials']);
            }
        } else {
            $this->call->view('auth/login');
        }
    }

    // Registration page
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'fullname' => $_POST['fullname'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'year_level' => $_POST['year_level']
            ];

            if ($this->VoterModel->register($data)) {
                redirect('/auth/login');
            } else {
                $this->call->view('auth/register', ['error' => 'Registration failed.']);
            }
        } else {
            $this->call->view('auth/register');
        }
    }

    // Logout
    public function logout()
    {
        session_destroy();
        redirect('/auth/login');
    }
}
