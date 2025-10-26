<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primary_key = 'id';
    protected $allowed_fields = ['username', 'password', 'created_at'];

    public function login($username, $password)
    {
        $admin = $this->db->table($this->table)->where('username', $username)->get();
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    public function createAdmin($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)->insert($data);
    }
}
