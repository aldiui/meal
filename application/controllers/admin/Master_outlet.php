<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_outlet extends CI_Controller {

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
			"title" => "Master Outlet",
			"outlet" => $this->db->get("master_outlet")->result_array(),
			"nickname" => $this->db->get_where("master_user", ["username" => $nickname])->row_array(),
		];
		$this->form_validation->set_rules("kode_outlet", "Kode Outlet", "required|trim|is_unique[master_outlet.kode_outlet]");
		$this->form_validation->set_rules("nama_outlet", "Nama Outlet", "required|trim");
        if ($this->form_validation->run() == false){
			layout("admin/master_outlet", $data);
        } else {
            $data = [
				'kode_outlet' => htmlspecialchars($this->input->post('kode_outlet',true)),
				'nama_outlet' => htmlspecialchars($this->input->post('nama_outlet',true))
			];
            $this->db->insert('master_outlet', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Menambahkan Data Master outlet</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/master_outlet");  
        }
	}
	
	public function delete($id){
		$this->db->delete("master_outlet", ["id" => $id]);
		$this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Master Outlet</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
		redirect("admin/master_outlet");  
	}

	public function edit(){
		$this->form_validation->set_rules("kode_outlet1", "Kode Outlet", "required|trim");
		$this->form_validation->set_rules("nama_outlet1", "Nama Outlet", "required|trim");
        if ($this->form_validation->run() == false){
            $this->index();
        } else {
			$data = [
				'kode_outlet' => htmlspecialchars($this->input->post('kode_outlet1',true)),
				'nama_outlet' => htmlspecialchars($this->input->post('nama_outlet1',true))
			];
			$this->db->where("id", $this->input->post("id"));
            $this->db->update('master_outlet', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Mengedit Data Master Outlet</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/master_outlet");  
        }
	}
}
