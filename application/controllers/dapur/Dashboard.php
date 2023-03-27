<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
        $bulan = date("m");
        $tahun = date("Y");
		$nickname =  $this->session->userdata('nickname');
        $user = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
		$data["bulan"] = [ 
            [ "no" => 1, "nama" => "Januari"],
            [ "no" => 2, "nama" => "Februari"],
            [ "no" => 3, "nama" => "Maret"],
            [ "no" => 4, "nama" => "April"],
            [ "no" => 5, "nama" => "Mei"],
            [ "no" => 6, "nama" => "Juni"],
            [ "no" => 7, "nama" => "Juli"],
            [ "no" => 8, "nama" => "Agustus"],
            [ "no" => 9, "nama" => "September"],
            [ "no" => 10, "nama" => "Oktober"],
            [ "no" => 11, "nama" => "November"],
            [ "no" => 12, "nama" => "Desember"],
        ];
        $data["tahun"] = [ date("Y"), date("Y")-1, date("Y")-2, date("Y")-3, date("Y")-4];
        $data["month"] = $bulan;
        $data["year"] = $tahun;
		$data["title"] ="Lap Input Data";
        $data["nickname"] = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
        $data["dapur"] = $this->db->select('tanggal, transaksi, status, rolling, no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where([ 'MONTH(tanggal)' => $bulan ,'YEAR(tanggal)' => $tahun, 'user_id' => $user["id"] ])->order_by('tanggal')->group_by("user_id")->group_by("no_dok")->group_by('tanggal')->group_by('rolling')->group_by('status')->group_by('transaksi')->get()->result_array();
        layout2("dapur/dashboard", $data);
    }

	public function cari(){
        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");
		$nickname =  $this->session->userdata('nickname');
        $user = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
		$data["bulan"] = [ 
            [ "no" => 1, "nama" => "Januari"],
            [ "no" => 2, "nama" => "Februari"],
            [ "no" => 3, "nama" => "Maret"],
            [ "no" => 4, "nama" => "April"],
            [ "no" => 5, "nama" => "Mei"],
            [ "no" => 6, "nama" => "Juni"],
            [ "no" => 7, "nama" => "Juli"],
            [ "no" => 8, "nama" => "Agustus"],
            [ "no" => 9, "nama" => "September"],
            [ "no" => 10, "nama" => "Oktober"],
            [ "no" => 11, "nama" => "November"],
            [ "no" => 12, "nama" => "Desember"],
        ];
        $data["tahun"] = [ date("Y"), date("Y")-1, date("Y")-2, date("Y")-3, date("Y")-4];
        $data["month"] = $bulan;
        $data["year"] = $tahun;
		$data["title"] ="Lap Input Data";
        $data["nickname"] = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
        $data["dapur"] = $this->db->select('tanggal, transaksi, status, rolling, no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where([ 'MONTH(tanggal)' => $bulan ,'YEAR(tanggal)' => $tahun, 'user_id' => $user["id"] ])->order_by('tanggal')->group_by("user_id")->group_by("no_dok")->group_by('tanggal')->group_by('rolling')->group_by('status')->group_by('transaksi')->get()->result_array();
        layout2("dapur/dashboard", $data);
    }

    public function hapus($no_dok){
        $this->db->delete("dapur_pengeluaran", ["no_dok" => $no_dok]);
        $this->db->delete("dapur_pembelian", ["no_dok" => $no_dok]);
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Dapur Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('dapur/dashboard');
    }
}