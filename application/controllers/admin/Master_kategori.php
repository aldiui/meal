<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_kategori extends CI_Controller {

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
			"title" => "Kategori Barang",
			"kategori" => $this->db->get("master_kategori")->result_array(),
			"akun" => $this->db->get("master_akuntansi")->result_array(),
			"nickname" => $this->db->get_where("master_user", ["username" => $nickname])->row_array(),
		];
		$this->form_validation->set_rules("kode_kategori", "Kode kategori", "required|trim|is_unique[master_kategori.kode_kategori]");
		$this->form_validation->set_rules("nama_kategori", "Nama kategori", "required|trim");
		$this->form_validation->set_rules("akun", "Akun Sediaan", "required|trim");
		$this->form_validation->set_rules("akun_hpp", "Akun HPP", "required|trim");
        if ($this->form_validation->run() == false){
			layout("admin/master_kategori", $data);
        } else {
            $data = [
				'kode_kategori' => htmlspecialchars($this->input->post('kode_kategori',true)),
				'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori',true)),
				'akun_id' => $this->input->post('akun',true),
				'akun_hpp' => $this->input->post('akun_hpp',true),
			];
            $this->db->insert('master_kategori', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Menambahkan Data Kategori Barang</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/master_kategori");  
        }
	}
	
	public function delete($id){
		$this->db->delete("master_kategori", ["id" => $id]);
		$this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Kategori Barang</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
		redirect("admin/master_kategori");  
	}

	public function edit(){
		$this->form_validation->set_rules("kode_kategori1", "Kode kategori", "required|trim");
		$this->form_validation->set_rules("nama_kategori1", "Nama kategori", "required|trim");
		$this->form_validation->set_rules("akun1", "Akun Sediaan", "required|trim");
		$this->form_validation->set_rules("akun_hpp1", "Akun HPP", "required|trim");
        if ($this->form_validation->run() == false){
            $this->index();
        } else {
			$data = [
				'kode_kategori' => htmlspecialchars($this->input->post('kode_kategori1',true)),
				'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori1',true)),
				'akun_id' => $this->input->post('akun1',true),
				'akun_hpp' => $this->input->post('akun_hpp1',true),
			];
			$this->db->where("id", $this->input->post("id"));
            $this->db->update('master_kategori', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Mengedit Data Kategori Barang</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/master_kategori");  
        }
	}
}
