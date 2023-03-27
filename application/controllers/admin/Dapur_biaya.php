<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dapur_biaya extends CI_Controller {

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
		$jenis = [
			[ "no" => 1, "jenis" => "Rutin"],
			[ "no" => 2, "jenis" => "Lain lain"],
		];
		$data = [
			"title" => "Dapur Biaya",
			"akuntansi" => $this->db->get("master_biaya")->result_array(),
			"nickname" => $this->db->get_where("master_user", ["username" => $nickname])->row_array(),
            "tipe" => $this->db->get("master_akuntansi")->result_array(),
			"jenis" => $jenis,
		];
		$this->form_validation->set_rules("kode_biaya", "Kode Biaya", "required|trim|is_unique[master_biaya.kode_biaya]");
		$this->form_validation->set_rules("nama_biaya", "Nama Biaya", "required|trim");
		$this->form_validation->set_rules("jenis_biaya", "Jenis Biaya", "required|trim");
		$this->form_validation->set_rules("tipe_akun", "Tipe Akun", "required|trim");
        if ($this->form_validation->run() == false){
			layout("admin/dapur_biaya", $data);
        } else {
            $data = [
				'kode_biaya' => htmlspecialchars($this->input->post('kode_biaya',true)),
				'nama_biaya' => htmlspecialchars($this->input->post('nama_biaya',true)),
				'jenis_biaya' => $this->input->post('jenis_biaya',true),
				'akun_id' => $this->input->post('tipe_akun',true),
			];
            $this->db->insert('master_biaya', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Menambahkan Data Dapur Biaya</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/dapur_biaya");  
        }
	}
	
	public function delete($id){
		$this->db->delete("master_biaya", ["id_biaya" => $id]);
		$this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Dapur Biaya</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
		redirect("admin/dapur_biaya");  
	}

	public function edit(){
		$this->form_validation->set_rules("kode_biaya1", "Kode Biaya", "required|trim");
		$this->form_validation->set_rules("nama_biaya1", "Nama Biaya", "required|trim");
		$this->form_validation->set_rules("jenis_biaya1", "Jenis Biaya", "required|trim");
		$this->form_validation->set_rules("tipe_akun1", "Tipe Akun", "required|trim");
        if ($this->form_validation->run() == false){
            $this->index();
        } else {
            $data = [
				'kode_biaya' => htmlspecialchars($this->input->post('kode_biaya1',true)),
				'nama_biaya' => htmlspecialchars($this->input->post('nama_biaya1',true)),
				'jenis_biaya' => $this->input->post('jenis_biaya1',true),
				'akun_id' => $this->input->post('tipe_akun1',true),
			];
			$this->db->where("id_biaya", $this->input->post("id"));
            $this->db->update('master_biaya', $data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Mengedit Data Dapur Biaya</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect("admin/dapur_biaya");  
        }
	}
}