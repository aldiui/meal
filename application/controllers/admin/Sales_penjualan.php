<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sales_penjualan extends CI_Controller {

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
			"title" => "Sales Penjualan",
            "nickname" => $this->db->get_where("master_user", ["username" => $nickname])->row_array(),
            "penjualan" => $this->db->get("barang_sediaan")->result_array(),
			"sp" => $this->db->query("SELECT * FROM sales_penjualan JOIN master_barang ON sales_penjualan.barang_id = master_barang.id")->result_array(),
		];
        layout("admin/sales_penjualan", $data);
    }
        
    public function tambah(){
        if ($this->input->post('checkbox')) {
            $checkbox = $this->input->post('checkbox');
            $sediaan = $this->input->post("sediaan");
            $data = [];
            $index = 0;
            foreach($checkbox as $row => $val) {
                array_push($data, [
                    'barang_id' => $val,
                    'sediaan_id' => $sediaan[$row],
                ]);
                $index++;
            }
            $this->db->insert_batch('sales_penjualan', $data);
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                <div class="text-white">Berhasil Menambahkan Data Sales Penjualan</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('admin/sales_penjualan'));
        } else {
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                <div class="text-white">Tidak Ada Data Yang Dipilih</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('admin/sales_penjualan'));
        }
    }

	public function delete($id){
		$this->db->delete("sales_penjualan", ["barang_id" => $id]);
		$this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Sales Penjualan</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
		redirect("admin/sales_penjualan");  
	}

    public function edit(){
        $data = $this->input->post('sediaan',true);
        $sediaan = [
            "sediaan_id" => $data,
            "sediaan2" => $this->input->post("sediaan2"),
            "qty2" => $this->input->post("qty2"),
            "sediaan3" => $this->input->post("sediaan3"),
            "qty3" => $this->input->post("qty3"),
            "sediaan4" => $this->input->post("sediaan4"),
            "qty4" => $this->input->post("qty4"),
            "sediaan5" => $this->input->post("sediaan5"),
            "qty5" => $this->input->post("qty5"),
            "sediaan6" => $this->input->post("sediaan6"),
            "qty6" => $this->input->post("qty6"),
            "sediaan7" => $this->input->post("sediaan7"),
            "qty7" => $this->input->post("qty7"),
        ];
        $this->db->where("barang_id", $this->input->post("id"));
        $this->db->update('sales_penjualan', $sediaan);
        $this->db->where("barang_id", $this->input->post("id"));
        $this->db->update('sales_laporan', ["sediaan_id" => $data]);
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white">Berhasil Mengedit Data Sales Sediaan</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect("admin/sales_penjualan");  
	}
}
