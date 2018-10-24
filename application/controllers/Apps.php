<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apps extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('mod_monitoring');
		$this->load->model('mod_log');
		$this->load->model('mod_user');
	}

	public function index(){
        if($this->session->userdata("session_appssystem_code")){
            redirect(site_url('apps/dashboard'),'refresh');
        }else{
            $this->load->view("apps/login");
        }
    }
    
    public function dashboard(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view('apps/header');
            $this->load->view('apps/body_dashboard');
            $this->load->view('apps/footer');
        }else{
            $this->load->view("apps/login");
        }
    }

    public function pengguna(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view('apps/header');
            $this->load->view('apps/body_pengguna');
            $this->load->view('apps/footer');
        }else{
            $this->load->view("apps/login");
        }
    }

    public function pengguna_detail(){
        $this->load->view('apps/header');
        $this->load->view('apps/body_pengguna_detail');
        $this->load->view('apps/footer');
    }

    public function pengguna_tambah(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view('apps/header');
            $this->load->view('apps/body_pengguna_tambah');
            $this->load->view('apps/footer');
        }else{
            $this->load->view("apps/login");
        }
    }

    public function pengguna_edit(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view('apps/header');
            $this->load->view('apps/body_pengguna_edit');
            $this->load->view('apps/footer');
        }else{
            $this->load->view("apps/login");
        }
    }

    public function admin(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view('apps/header');
            $this->load->view('apps/body_pengguna_admin_edit');
            $this->load->view('apps/footer');
        }else{
            $this->load->view("apps/login");
        }
    }

    public function logout(){
        if($this->session->userdata("session_appssystem_code")){
            $this->session->sess_destroy();
        }
        $this->load->view("apps/login");
    }

    public function login(){
        if($this->session->userdata("session_appssystem_code")){
            redirect(site_url('apps/dashboard'),'refresh');
        }else{
            $this->load->view("apps/login");
        }
    }


    public function debug(){
        $this->load->view('apps/template');
    }
}