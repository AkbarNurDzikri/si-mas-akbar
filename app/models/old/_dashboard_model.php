<?php

class Dashboard_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function annualLeaveBalance($userId)
    {
        $query = "SELECT leave_balance FROM master_employees WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->execute();

        return $this->db->single();
    }

    public function annualLeaveCounter($userId)
    {
        $query = "SELECT COUNT(leave_type) AS annual_leave_counted FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Annual Leave');
        $this->db->execute();

        return $this->db->single();
    }

    public function annualLeaveApproved($userId)
    {
        $query = "SELECT COUNT(leave_type) AS annual_leave_approved FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type AND `status` = :status AND sign_to IS NULL";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Annual Leave');
        $this->db->bind('status', 'Approved');
        $this->db->execute();

        return $this->db->single();
    }

    public function annualLeaveRejected($userId)
    {
        $query = "SELECT COUNT(leave_type) AS annual_leave_rejected FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type AND `status` = :status AND sign_to IS NULL";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Annual Leave');
        $this->db->bind('status', 'Rejected');
        $this->db->execute();

        return $this->db->single();
    }

    public function annualLeaveOnProgress($userId)
    {
        $query = "SELECT COUNT(leave_type) AS annual_leave_on_progress FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type AND `status` = :status AND sign_to IS NOT NULL";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Annual Leave');
        $this->db->bind('status', 'Approved');
        $this->db->execute();

        return $this->db->single();
    }

    public function specialLeaveCounter($userId)
    {
        $query = "SELECT COUNT(leave_type) AS special_leave_counted FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Special Leave');
        $this->db->execute();

        return $this->db->single();
    }

    public function specialLeaveApproved($userId)
    {
        $query = "SELECT COUNT(leave_type) AS special_leave_approved FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type AND `status` = :status AND sign_to IS NULL";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Special Leave');
        $this->db->bind('status', 'Approved');
        $this->db->execute();

        return $this->db->single();
    }

    public function specialLeaveRejected($userId)
    {
        $query = "SELECT COUNT(leave_type) AS special_leave_rejected FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type AND `status` = :status AND sign_to IS NULL";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Special Leave');
        $this->db->bind('status', 'Rejected');
        $this->db->execute();

        return $this->db->single();
    }

    public function specialLeaveOnProgress($userId)
    {
        $query = "SELECT COUNT(leave_type) AS special_leave_on_progress FROM leave_out WHERE emp_id = :id AND leave_type = :leave_type AND `status` = :status AND sign_to IS NOT NULL";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('leave_type', 'Special Leave');
        $this->db->bind('status', 'Approved');
        $this->db->execute();

        return $this->db->single();
    }
}
