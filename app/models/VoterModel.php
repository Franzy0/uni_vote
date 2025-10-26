<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoterModel extends Model
{
    protected $table = 'voters';

    public function create($student_id, $fullname, $email, $password_hash)
    {
        return $this->db->table($this->table)->insert([
            'student_id' => $student_id,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password_hash
        ]);
    }

    public function findByStudentId($student_id)
    {
        return $this->db->table($this->table)->where('student_id', $student_id)->get()->row_array();
    }

    public function findById($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get()->row_array();
    }

    public function markVoted($id)
    {
        return $this->db->table($this->table)->where('id', $id)->update(['has_voted' => 1]);
    }
}
