<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('CandidateModel');
        $this->call->model('VoteModel');
        $this->call->model('VoterModel');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_id'])) {
            redirect('/auth/login');
        }
    }

    // Dashboard
    public function dashboard()
    {
        $results = $this->VoteModel->get_vote_summary();
        $total_votes = $this->VoteModel->total_votes();
        $this->call->view('admin/admin_dashboard', [
            'results' => $results,
            'total_votes' => $total_votes
        ]);
    }

    // Manage Candidates
    public function candidates()
    {
        $candidates = $this->CandidateModel->get_all();
        $this->call->view('admin/manage_candidates', ['candidates' => $candidates]);
    }

    public function add_candidate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'position' => $_POST['position'],
                'party' => $_POST['party']
            ];
            $this->CandidateModel->create($data);
            redirect('/admin/candidates');
        }
    }

    public function delete_candidate($id)
    {
        $this->CandidateModel->delete($id);
        redirect('/admin/candidates');
    }

    // Election Results (Chart.js)
    public function results()
    {
        $results = $this->VoteModel->get_vote_summary();
        $this->call->view('admin/results', ['results' => $results]);
    }

    // Export results to CSV
    public function export_csv()
    {
        $results = $this->VoteModel->get_vote_summary();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="election_results.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Candidate', 'Position', 'Total Votes']);
        foreach ($results as $row) {
            fputcsv($output, [$row['name'], $row['position'], $row['total_votes']]);
        }
        fclose($output);
        exit;
    }
}
