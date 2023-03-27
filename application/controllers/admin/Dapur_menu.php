<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dapur_menu extends CI_Controller {

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
        $bulan = date("m");
        $tahun = date("Y");
		$nickname =  $this->session->userdata('nickname');
        $user = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
		$data["title"] ="Input Pengeluaran";
        $data["dapur_admin"] = $this->db->get_where("master_user", ["role" => "Dapur", "dapur" => null])->result_array();
        $data["nickname"] = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
        layout("admin/dapur_menu", $data);
    }


    public function filter(){
		$id = $this->input->post("dapur");
		$nickname =  $this->session->userdata('nickname'); 
		$data["olah"] = "kosong";
		$data["title"] = "Input Pengeluaran";
		$data["nickname"] = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
		$data["username"] = $this->db->get_where("master_user", ["id" => $id])->row_array();
		layout("admin/input_barang", $data);
	}


    public function rolling_dapur()
    {
        $nickname =  $this->session->userdata('nickname');
        $transaksi = $this->input->get('trx');
        $tanggal = $this->input->get('tanggal');
        $id = $this->input->get('id');
        $data["username"] = $this->db->get_where("master_user", ["id" => $id])->row_array();
        $data["title"] ="Input Pengeluaran";
        $data["nickname"] = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
        $data["date"] = $tanggal;
        $data["olah"] = "kosong";
        
        if($transaksi){
            $trx = $transaksi;
        } else {
            $cekdatak = $this->db->get_where("dapur_pengeluaran", ["tanggal" => $tanggal, "user_id" => $id ])->num_rows();
            if($cekdatak == 0){
                $trx = 1;
            } else {
                $query = $this->db->select("transaksi")->from("dapur_pengeluaran")->where("tanggal", $tanggal)->where("user_id", $id)->order_by("id_dp", "desc")->limit(1)->get();
                $result = $query->row_array();
                $trx = $result["transaksi"] + 1;
            }   
        }
        $data["trx"] = $trx;

        if ($tanggal) {
            $ceklaporan = $this->db->get_where("dapur_pengeluaran", ["tanggal" => $tanggal, "user_id" => $id, 'transaksi' => $trx])->num_rows();
            if ($ceklaporan > 0) {
                $data["olah"] = "edit";
                $data["biaya_rutin"] = $this->db->get_where("dapur_pengeluaran", ["pengeluaran" => 1, "tanggal" => $tanggal, "user_id" => $id, "transaksi" => $trx])->result_array();
                $data["biaya_lain"] = $this->db->get_where("dapur_pengeluaran", ["pengeluaran" => 2, "tanggal" => $tanggal, "user_id" => $id, "transaksi" => $trx])->result_array();
                $data["pembelian"] = $this->db->get_where("dapur_pembelian", ["tanggal" => $tanggal, "user_id" => $id, "transaksi" => $trx])->result_array();
                $data["total_br"] = $this->db->select_sum('nilai')->where(["tanggal" => $tanggal, "user_id" => $id, "pengeluaran" => 1, "transaksi" => $trx])->get('dapur_pengeluaran')->row()->nilai;
                $cek_bl = $this->db->get_where("dapur_pengeluaran", ["pengeluaran" => 2, "tanggal" => $tanggal, "user_id" => $id, "transaksi" => $trx])->num_rows();
                if($cek_bl == 0){
                    $data["total_bl"] = 0;
                } else {
                    $data["total_bl"] = $this->db->select_sum('nilai')->where(["tanggal" => $tanggal, "user_id" => $id, "pengeluaran" => 2, "transaksi" => $trx])->get('dapur_pengeluaran')->row()->nilai;
                }
                $cek_pb = $this->db->get_where("dapur_pembelian", ["tanggal" => $tanggal, "user_id" => $id, "transaksi" => $trx])->num_rows();
                if($cek_pb == 0){
                    $data["total_pb"] = 0;
                } else {
                    $data["total_pb"] = $this->db->select_sum('nilai')->where(["tanggal" => $tanggal, "user_id" => $id, "transaksi" => $trx])->get('dapur_pembelian')->row()->nilai;
                }
                $data["beli"] = $this->db->get("master_barang")->result_array();
                $data["master_biaya"] = $this->db->get_where("master_biaya", ["jenis_biaya" => 2])->result_array();
                $data["no_dok"] = generate_no_dok($tanggal, $id, $trx);
            } else {
                $data["biaya_rutin"] = $this->db->get_where("master_biaya", ["jenis_biaya" => 1])->result_array();
                $data["biaya_lain"] = $this->db->get_where("master_biaya", ["jenis_biaya" => 2])->result_array();
                $data["pembelian"] = $this->db->get_where("master_barang")->result_array();
                $data["olah"] = "input";
                $data["no_dok"] = generate_no_dok($tanggal, $id, $trx);
            }
        }
        layout("admin/input_barang", $data);
    }

    public function tambah($tanggal, $id, $trx)
    {
        $nickname =  $this->session->userdata('nickname');
        $user = $this->db->get_where("master_user", ["id" => $id])->row_array();
        $rol = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
        $id_user = $user["id"];
        $no_dok = $this->input->post("no_dok");
        $biaya_br = $this->input->post("biaya_br");
        $ket_br = $this->input->post("ket_br");
        $jumlah_br = $this->input->post("jumlah_br");
        $nilai_br = $this->input->post("nilai_br");
        $br = [];
        foreach ($biaya_br as $key => $value) {
            $br[] = [
                'biaya_id' =>$value,
                'tanggal' => $tanggal,
                'keterangan' => $ket_br[$key],
                'jumlah' => $jumlah_br[$key],
                'nilai' => $nilai_br[$key],
                'user_id' => $id_user,
                'pengeluaran' => 1,
                'no_dok' => $no_dok,
                'rolling' => $rol["id"],
                'transaksi' => $trx,
            ];
        }
        $this->db->insert_batch('dapur_pengeluaran', $br);

        if ($this->input->post('biaya_bl')) {
            $biaya_bl = $this->input->post("biaya_bl");
            $bl = [];
            foreach ($biaya_bl as $key => $value) {
                $bl[] = [
                    'biaya_id' => $biaya_bl[$key],
                    'keterangan' => $this->input->post("ket_bl".$biaya_bl[$key]),
                    'tanggal' => $tanggal,
                    'jumlah' =>  $this->input->post("jumlah_bl".$biaya_bl[$key]),
                    'nilai' => $this->input->post("nilai_bl".$biaya_bl[$key]),
                    'user_id' => $id_user,
                    'pengeluaran' => 2,
                    'no_dok' => $no_dok,
                    'rolling' => $rol["id"],
                    'transaksi' => $trx,
                ];
            }
            $this->db->insert_batch('dapur_pengeluaran', $bl);
        }

        if ($this->input->post('barang_bp')) {
            $barang_bp = $this->input->post("barang_bp");
            $pb = [];
            foreach ($barang_bp as $key => $value) {
                $pb[] = [
                    'barang_id' => $barang_bp[$key],
                    'tanggal' => $tanggal,
                    'satuan' => $this->input->post("satuan".$barang_bp[$key]),
                    'qty' => $this->input->post("qty".$barang_bp[$key]),
                    'harga' => $this->input->post("harga".$barang_bp[$key]),
                    'nilai' => $this->input->post("nilai".$barang_bp[$key]),
                    'user_id' => $id_user,
                    'no_dok' => $no_dok,
                    'rolling' => $rol["id"],
                    'transaksi' => $trx,
                ];
            }
            $this->db->insert_batch('dapur_pembelian', $pb);
        }

        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menambahkan Data Dapur Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/dapur_menu/rolling_dapur?tanggal='. $tanggal."&id=".$id."&trx=".$trx);
    }


    public function edit($tanggal, $id, $trx)
    {
        $nickname =  $this->session->userdata('nickname');
        $user = $this->db->get_where("master_user", ["id" => $id])->row_array();
        $rol = $this->db->get_where("master_user", ["username" => $nickname])->row_array();
        $id_user = $user["id"];
        $no_dok = $this->input->post("no_dok");
        $biaya_br = $this->input->post("biaya_br");
        $ket_br = $this->input->post("ket_br");
        $jumlah_br = $this->input->post("jumlah_br");
        $nilai_br = $this->input->post("nilai_br");
        $br = [];
        foreach ($biaya_br as $key => $value) {
            $br[] = [
                'biaya_id' => $biaya_br[$key],
                'keterangan' => $ket_br[$key],
                'jumlah' => $jumlah_br[$key],
                'nilai' => $nilai_br[$key],
            ];
        }

        if ($this->input->post('id_dp')) {
            $akun_bl = $this->input->post("akun_bl");
            $idbl = $this->input->post("id_dp");
            $ket_bl = $this->input->post("ket_bl");
            $jumlah_bl = $this->input->post("jumlah_bl");
            $nilai_bl = $this->input->post("nilai_bl");
            $bl = [];
            foreach ($idbl as $key => $value) {
                $bl[] = [
                    'id_dp' => $value,
                    'keterangan' => $ket_bl[$key],
                    'biaya_id' => $akun_bl[$key],
                    'jumlah' => $jumlah_bl[$key],
                    'nilai' => $nilai_bl[$key],
                ];
            }
            $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal, 'transaksi' => $trx ]);
            $this->db->update_batch('dapur_pengeluaran', $bl, "id_dp");
        }

        if ($this->input->post('id_pem')) {
            $barang_bp = $this->input->post("barang_bp");
            $satuan = $this->input->post("satuan");
            $id_pem = $this->input->post("id_pem");
            $qty = $this->input->post("qty");
            $harga = $this->input->post("harga");
            $nilai = $this->input->post("nilai");
            $pb = [];
            foreach ($id_pem as $key => $value) {
                $pb[] = [
                    'id_pb' => $value,
                    'barang_id' => $barang_bp[$key],
                    'satuan' => $satuan[$key],
                    'qty' => $qty[$key],
                    'harga' => $harga[$key],
                    'nilai' => $nilai[$key],
                ];
            }
            $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal, 'transaksi' => $trx ]);
            $this->db->update_batch('dapur_pembelian', $pb, "id_pb");
        }

        $getRoll = $this->db->select('tanggal, rolling, status, no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where([ "tanggal" => $tanggal, "user_id" => $id,"pengeluaran" => 1, "transaksi" => $trx])->order_by('tanggal')->group_by("user_id")->group_by("no_dok")->group_by('tanggal')->group_by('rolling')->group_by('status')->get()->row_array();
        if ($this->input->post('biaya_bl1')) {
            $biaya_bl1 = $this->input->post("biaya_bl1");
            $bl1 = [];
            foreach ($biaya_bl1 as $key => $value) {
                $bl1[] = [
                    'biaya_id' => $biaya_bl1[$key],
                    'keterangan' => $this->input->post("ket_bl1".$biaya_bl1[$key]),
                    'tanggal' => $tanggal,
                    'jumlah' =>  $this->input->post("jumlah_bl1".$biaya_bl1[$key]),
                    'nilai' => $this->input->post("nilai_bl1".$biaya_bl1[$key]),
                    'user_id' => $id_user,
                    'pengeluaran' => 2,
                    'no_dok' => $no_dok,
                    'rolling' => $getRoll["rolling"],
                    'status' => $getRoll["status"],
                    'transaksi' => $trx
                ];
            }
            $this->db->insert_batch('dapur_pengeluaran', $bl1);
        }

        if ($this->input->post('barang_bp1')) {
            $barang_bp1 = $this->input->post("barang_bp1");
            $pb1 = [];
            foreach ($barang_bp1 as $key => $value) {
                $pb1[] = [
                    'barang_id' => $barang_bp1[$key],
                    'tanggal' => $tanggal,
                    'satuan' => $this->input->post("satuan1".$barang_bp1[$key]),
                    'qty' => $this->input->post("qty1".$barang_bp1[$key]),
                    'harga' => $this->input->post("harga1".$barang_bp1[$key]),
                    'nilai' => $this->input->post("nilai1".$barang_bp1[$key]),
                    'user_id' => $id_user,
                    'no_dok' => $no_dok,
                    'rolling' => $getRoll["rolling"],
                    'status' => $getRoll["status"],
                    'transaksi' => $trx
                ];
            }
            $this->db->insert_batch('dapur_pembelian', $pb1);
        }

        $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal, 'transaksi' => $trx ]);
        $this->db->update_batch('dapur_pengeluaran', $br, "biaya_id");

        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Mengedit Data Dapur Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/dapur_menu/rolling_dapur?tanggal='. $tanggal."&id=".$id."&trx=".$trx);
    }
}