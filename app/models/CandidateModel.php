<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class CandidateModel extends Model
{
    protected $table = 'candidates';
    protected $primary_key = 'id';
    protected $allowed_fields = ['name', 'position', 'party'];

    public function __construct()
    {
        parent::__construct();
    }

    // Get all candidates ordered by position
    public function get_all()
    {
        return $this->db->table($this->table)
                        ->order_by('position', 'ASC')
                        ->get_all();
    }

    // Override find() with correct signature
    public function find($id, $with_deleted = false)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->get();
    }

    // Create a new candidate
    public function create($data)
    {
        return $this->db->table($this->table)
                        ->insert($data);
    }

    // Update candidate
    public function update_candidate($id, $data)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->update($data);
    }

    // Delete candidate
    public function delete_candidate($id)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->delete();
    }

    // Count total votes per candidate
    public function tally()
    {
        $sql = "SELECT c.id, c.name, c.position, COUNT(v.id) AS votes
                FROM candidates c
                LEFT JOIN votes v ON c.id = v.candidate_id
                GROUP BY c.id, c.name, c.position
                ORDER BY votes DESC";

        return $this->db->raw($sql);
    }
}
