<?php
// app/core/Utils.php
namespace App\Core;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Utils {
    public static function startSession() {
        if(session_status() === PHP_SESSION_NONE) session_start();
    }
    public static function generateCSRF() {
        self::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    public static function validateCSRF($token) {
        self::startSession();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
