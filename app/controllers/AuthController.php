<?php
// app/controllers/AuthController.php
namespace App\Controllers;
use App\Core\Utils;
use App\Models\VoterModel;
use App\Models\AdminModel;
use PHPMailer\PHPMailer\PHPMailer;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController {
    protected $voterModel;
    protected $adminModel;
    protected $cfg;
    public function __construct() {
        $this->voterModel = new VoterModel();
        $this->adminModel = new AdminModel();
        $this->cfg = require __DIR__ . '/../config/config.php';
        Utils::startSession();
    }

    public function login() {
        // if GET: show login view
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrf = Utils::generateCSRF();
            include __DIR__ . '/../views/auth/login.php';
            return;
        }
        // POST: process
        $recaptcha = $this->verifyRecaptcha($_POST['g-recaptcha-response'] ?? '');
        if(!$recaptcha) {
            $_SESSION['error'] = "reCAPTCHA validation failed";
            header("Location: /");
            exit;
        }
        $type = $_POST['type'] ?? 'voter';
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($type === 'admin') {
            $admin = $this->adminModel->authenticate($username, $password);
            if ($admin) {
                $_SESSION['admin'] = $admin;
                header("Location: /admin");
            } else {
                $_SESSION['error'] = "Invalid admin username or password";
                header("Location: /");
            }
            exit;
        } else {
            $voter = $this->voterModel->authenticate($username, $password);
            if ($voter) {
                $_SESSION['voter'] = $voter;
                header("Location: /vote");
            } else {
                $_SESSION['error'] = "Invalid student ID or password";
                header("Location: /");
            }
            exit;
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrf = Utils::generateCSRF();
            include __DIR__ . '/../views/auth/register.php';
            return;
        }
        // POST
        if (!Utils::validateCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = "Invalid CSRF token";
            header("Location: /register");
            exit;
        }
        $recaptcha = $this->verifyRecaptcha($_POST['g-recaptcha-response'] ?? '');
        if(!$recaptcha) {
            $_SESSION['error'] = "reCAPTCHA validation failed";
            header("Location: /register");
            exit;
        }
        $student_id = trim($_POST['student_id']);
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if ($this->voterModel->findByStudentId($student_id)) {
            $_SESSION['error'] = "Student ID already registered";
            header("Location: /register");
            exit;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->voterModel->create($student_id, $fullname, $email, $hash);
        // send confirmation email
        $this->sendEmail($email, 'Registration Successful', "Hello $fullname, your account has been created.");
        $_SESSION['success'] = "Registration successful. Please login.";
        header("Location: /");
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
    }

    protected function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $mCfg = $this->cfg['mail'];
            $mail->isSMTP();
            $mail->Host = $mCfg['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mCfg['username'];
            $mail->Password = $mCfg['password'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $mCfg['port'];
            $mail->setFrom($mCfg['from_email'], $mCfg['from_name']);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
        } catch (\Exception $e) {
            // for student project, we can silently ignore email errors or log them
            error_log("Mail error: " . $e->getMessage());
        }
    }

    protected function verifyRecaptcha($response) {
        $secret = $this->cfg['recaptcha']['secret_key'] ?? '';
        if (!$secret) return true; // if not configured, bypass (for testing)
        $resp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
        $json = json_decode($resp, true);
        return $json['success'] ?? false;
    }
}
