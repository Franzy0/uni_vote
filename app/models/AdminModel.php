<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AdminModel extends Model
{
    protected $table = 'admins';

    public function authenticate($username, $password)
    {
        $row = $this->db->table($this->table)->where('username', $username)->get()->row_array();
        if ($row && password_verify($password, $row['password'])) return $row;
        return false;
    }
}
