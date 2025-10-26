<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoterModel extends Model
{
    protected $table = 'voters';
    protected $primary_key = 'id';
    protected $allowed_fields = ['fullname', 'email', 'password', 'year_level', 'has_voted', 'created_at'];

    public function register($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['has_voted'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)->insert($data);
    }

    public function login($email, $password)
    {
        $voter = $this->db->table($this->table)->where('email', $email)->get();

        if ($voter && password_verify($password, $voter['password'])) {
            return $voter;
        }
        return false;
    }

    public function markAsVoted($voter_id)
    {
        return $this->db->table($this->table)->where('id', $voter_id)->update(['has_voted' => 1]);
    }

    public function hasVoted($voter_id)
    {
        $v = $this->db->table($this->table)->where('id', $voter_id)->get();
        return $v && $v['has_voted'] == 1;
    }
}
