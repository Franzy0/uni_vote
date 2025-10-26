<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('VoterModel');
        Utils::startSession();
    }

    // GET/POST login
    public function login()
    {
        $cfg = require __DIR__ . '/../config/config.php';
        if ($this->form_validation->submitted()) {
            $student_id = trim($this->io->post('student_id'));
            $password = $this->io->post('password');
            // reCAPTCHA check (skip if not configured)
            $rec = $this->io->post('g-recaptcha-response');
            if (!empty($cfg['recaptcha']['secret_key'])) {
                $verify = $this->verifyRecaptcha($rec, $cfg['recaptcha']['secret_key']);
                if (!$verify) {
                    Utils::flash('error', 'reCAPTCHA verification failed');
                    redirect('/auth/login');
                }
            }

            $user = $this->VoterModel->findByStudentId($student_id);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['voter'] = $user;
                redirect('/');
            } else {
                Utils::flash('error', 'Invalid credentials.');
                redirect('/auth/login');
            }
        }

        $csrf = Utils::generateCSRF();
        $this->call->view('auth/login', ['csrf' => $csrf]);
    }

    // GET/POST register
    public function register()
    {
        $cfg = require __DIR__ . '/../config/config.php';
        if ($this->form_validation->submitted()) {
            // CSRF
            if (!Utils::validateCSRF($this->io->post('csrf_token'))) {
                Utils::flash('error', 'Invalid CSRF token.');
                redirect('/auth/register');
            }

            $student_id = trim($this->io->post('student_id'));
            $fullname = trim($this->io->post('fullname'));
            $email = trim($this->io->post('email'));
            $password = $this->io->post('password');

            // reCAPTCHA
            $rec = $this->io->post('g-recaptcha-response');
            if (!empty($cfg['recaptcha']['secret_key'])) {
                $verify = $this->verifyRecaptcha($rec, $cfg['recaptcha']['secret_key']);
                if (!$verify) {
                    Utils::flash('error', 'reCAPTCHA verification failed');
                    redirect('/auth/register');
                }
            }

            if ($this->VoterModel->findByStudentId($student_id)) {
                Utils::flash('error', 'Student ID already registered');
                redirect('/auth/register');
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->VoterModel->create($student_id, $fullname, $email, $hash);
            // send email confirmation
            if (class_exists('Mailer')) {
                $mail = new Mailer();
                $mail->send($email, 'Registration Successful', "Hi $fullname, your account was created.");
            }

            Utils::flash('success', 'Registration successful. Please login.');
            redirect('/auth/login');
        }

        $csrf = Utils::generateCSRF();
        $this->call->view('auth/register', ['csrf' => $csrf, 'recaptcha_site' => $cfg['recaptcha']['site_key'] ?? '']);
    }

    public function logout()
    {
        Utils::startSession();
        session_unset();
        session_destroy();
        redirect('/auth/login');
    }

    protected function verifyRecaptcha($response, $secret)
    {
        if (empty($secret)) return true; // bypass in dev
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = http_build_query(['secret'=>$secret,'response'=>$response]);
        $opts = ['http' => ['method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $data]];
        $context = stream_context_create($opts);
        $res = @file_get_contents($url, false, $context);
        if (!$res) return false;
        $json = json_decode($res, true);
        return $json['success'] ?? false;
    }
}
