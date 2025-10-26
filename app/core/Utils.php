<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Utils
{
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function redirect($url)
    {
        header("Location: " . site_url($url));
        exit;
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['voter_id']);
    }
}
