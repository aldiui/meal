<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	public function __construct(){
        parent::__construct();
		if(!$this->session->userdata("nickname")){
			redirect("auth");
		} 
		if($this->session->userdata("role") == "Admin"){
            redirect("admin/dashboard");
        } elseif($this->session->userdata("role") == "Sales"){
            redirect("sales/dashboard");
        }
    }

	public function index(){
		$nickname =  $this->session->userdata('nickname');
		$data = [
			"title" => "Profil",
			"nickname" => $this->db->get_where("master_user", ["username" => $nickname])->row_array(),
		];
        layout2("dapur/profil", $data);
	}

	public function edit(){
		$this->form_validation->set_rules("nama", "Nama", "required|trim");
		$this->form_validation->set_rules("username", "Username", "required|trim");
		$this->form_validation->set_rules("password", "Password", "min_length[5]");
        if ($this->form_validation->run() == false){
            $this->index();
        } else {
			if ($this->input->post('password') != NULL){
				$data['password'] = password_hash(htmlspecialchars($this->input->post('password',true)), PASSWORD_DEFAULT);
			}
			$data['nama'] = htmlspecialchars($this->input->post('nama',true));
			$data['username'] = htmlspecialchars($this->input->post('username',true));
			$this->db->where("id", $this->input->post("id"));
            $this->db->update('master_user', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Mengedit Data Profil</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("dapur/profil");  
        }
	}
}