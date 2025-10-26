<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class CandidateModel extends Model
{
    protected $table = 'candidates';
    protected $primary_key = 'id';
    protected $allowed_fields = ['name', 'position', 'party', 'year_level', 'created_at'];

    public function getAllCandidates()
    {
        return $this->db->table($this->table)->order_by('position', 'ASC')->get_all();
    }

    public function getCandidateById($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get();
    }

    public function addCandidate($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)->insert($data);
    }

    public function deleteCandidate($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}
