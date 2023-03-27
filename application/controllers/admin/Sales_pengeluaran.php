<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_pengeluaran extends CI_Controller {

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
			"title" => "Sales Pengeluaran",
			"akun" => $this->db->get_where("master_biaya", ["sales_pengeluaran" => 1])->result_array(),
            "nickname" => $this->db->get_where("master_user", ["username" => $nickname])->row_array(),
		];
        layout("admin/sales_pengeluaran", $data);
    }
        
    public function tambah(){
        if ($this->input->post('checkbox')) {
            $checkbox = $this->input->post('checkbox');
            $data = [];
            foreach($checkbox as $row => $val) {
                array_push($data, [
                    'id_biaya' => $val,
                    'sales_pengeluaran' => 1,
                ]);
            }
            $this->db->update_batch('master_biaya', $data, "id_biaya");
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                <div class="text-white">Berhasil Menambahkan Data Sales Pengeluaran</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('admin/sales_pengeluaran'));
        } else {
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                <div class="text-white">Tidak Ada Data Yang Dipilih</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('admin/sales_pengeluaran'));
        }
    }

	public function delete($id){
        $this->db->where('id_biaya', $id);
		$this->db->update("master_biaya", ["sales_pengeluaran" => 0]);
		$this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Sales Pengeluaran</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
		redirect("admin/sales_pengeluaran");  
	}
}
