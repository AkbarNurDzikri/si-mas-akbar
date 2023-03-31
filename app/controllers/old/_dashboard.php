<?php

class Dashboard extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $data = [
                'title' => 'Dashboard',
                'annualLeaveBalance' => $this->model('dashboard_model')->annualLeaveBalance($_SESSION['userInfo']['emp_id']),
                'intervalAnnualLeave' => $this->model('dashboard_model')->annualLeaveCounter($_SESSION['userInfo']['emp_id']),
                'annualLeaveApproved' =>  $this->model('dashboard_model')->annualLeaveApproved($_SESSION['userInfo']['emp_id']),
                'annualLeaveRejected' =>  $this->model('dashboard_model')->annualLeaveRejected($_SESSION['userInfo']['emp_id']),
                'annualLeaveOnProgress' =>  $this->model('dashboard_model')->annualLeaveOnProgress($_SESSION['userInfo']['emp_id']),

                'intervalSpecialLeave' => $this->model('dashboard_model')->specialLeaveCounter($_SESSION['userInfo']['emp_id']),
                'specialLeaveApproved' =>  $this->model('dashboard_model')->specialLeaveApproved($_SESSION['userInfo']['emp_id']),
                'specialLeaveRejected' =>  $this->model('dashboard_model')->specialLeaveRejected($_SESSION['userInfo']['emp_id']),
                'specialLeaveOnProgress' =>  $this->model('dashboard_model')->specialLeaveOnProgress($_SESSION['userInfo']['emp_id']),
            ];

            $this->view('templates/header', $data);
            $this->view('dashboard/index', $data);
            $this->view('templates/footer');
        }
    }
}