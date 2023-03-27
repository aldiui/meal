<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_user extends CI_Controller {

	public function __construct(){
        parent::__construct();
		if(!$this->session->userdata("nickname")){
			redirect("auth");
		} elseif($this->session->userdata("role") == "Sales"){
            redirect("sales/dashboard");
        } elseif($this->session->userdata("role") == "Dapur"){
            redirect("dapur/dashboard");
        }
    }
	
	public function index(){
		$nickname =  $this->session->userdata('nickname');
		$data = [
			"title" => "Master User",
			"user" => $this->db->get("master_user")->result_array(),
			"outlet" => $this->db->get("master_outlet")->result_array(),
			"role" => ["Admin", "Sales", "Dapur"],
			"nickname" => $this->db->get_where("master_user", ["username" => $nickname])->row_array(),
		];
		$this->form_validation->set_rules("nama", "Nama", "required|trim");
		$this->form_validation->set_rules("username", "Username", "required|trim|is_unique[master_user.username]");
		$this->form_validation->set_rules("password", "Password", "required|trim|min_length[5]");
		$this->form_validation->set_rules("role", "Role", "required|trim");
        if ($this->form_validation->run() == false){
			layout("admin/master_user", $data);
        } else {
            $data = [
				'nama' => htmlspecialchars($this->input->post('nama',true)),
				'username' => htmlspecialchars($this->input->post('username',true)),
				'password' => password_hash(htmlspecialchars($this->input->post('password',true)), PASSWORD_DEFAULT),
				'outlet_id' => $this->input->post('outlet',true),
				'role' => $this->input->post('role',true),
				'rolling' => $this->input->post('rolling'),
				'dapur' => $this->input->post('dapur'),
			];
            $this->db->insert('master_user', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Menambahkan Data Master User</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/master_user");  
        }
	}
	
	public function delete($id){
		$this->db->delete("master_user", ["id" => $id]);
		$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Menghapus Data Master User</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		redirect("admin/master_user");  
	}

	public function edit(){
		$this->form_validation->set_rules("nama1", "Nama", "required|trim");
		$this->form_validation->set_rules("username1", "Username", "required|trim");
		$this->form_validation->set_rules("password1", "Password", "min_length[5]");
		$this->form_validation->set_rules("role1", "Role", "required|trim");
        if ($this->form_validation->run() == false){
            $this->index();
        } else {
			if ($this->input->post('password1') != NULL){
				$data['password'] = password_hash(htmlspecialchars($this->input->post('password1',true)), PASSWORD_DEFAULT);
			}
			$data['nama'] = htmlspecialchars($this->input->post('nama1',true));
			$data['username'] = htmlspecialchars($this->input->post('username1',true));
			$data['outlet_id'] = $this->input->post('outlet1',true);
			$data['role'] = $this->input->post('role1',true);
			$data['rolling'] = $this->input->post('rolling1',true);
			$data['dapur'] = $this->input->post('dapur1',true);
			$this->db->where("id", $this->input->post("id"));
            $this->db->update('master_user', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Mengedit Data Master User</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/master_user");  
        }
	}
}