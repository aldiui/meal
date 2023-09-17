<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('nickname')) {
            redirect('auth');
        } elseif ($this->session->userdata('role') == 'Admin') {
            redirect('admin/dashboard');
        } elseif ($this->session->userdata('role') == 'Dapur') {
            redirect('dapur/dashboard');
        }
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');
        $nickname = $this->session->userdata('nickname');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['olah'] = 'kosong';

        if ($tanggal) {
            $ceklaporan = $this->db->get_where('sales_laporan', ['tanggal' => $tanggal, 'user_id' => $user['id']])->num_rows();
            if ($ceklaporan > 0) {
                $data['olah'] = 'edit';
                $data['sediaan'] = $this->db->get_where('sediaan_laporan', ['tanggal' => $tanggal, 'user_id' => $user['id']])->result_array();
                $data['penjualan'] = $this->db->get_where('sales_laporan', ['tanggal' => $tanggal, 'user_id' => $user['id']])->result_array();
                $data['pengeluaran'] = $this->db->get_where('lap_pengeluaran', ['tanggal' => $tanggal, 'user_id' => $user['id']])->result_array();
                $data['totalpenjualan'] = $this->db->select_sum('total')->where(['tanggal' => $tanggal, 'user_id' => $user['id']])->get('sales_laporan')->row()->total;
                $ceklpengeluaran = $this->db->get_where('lap_pengeluaran', ['tanggal' => $tanggal, 'user_id' => $user['id']])->num_rows();
                if ($ceklpengeluaran > 0) {
                    $data['totalpengeluaran'] = $this->db->select_sum('nilai')->where(['tanggal' => $tanggal, 'user_id' => $user['id']])->get('lap_pengeluaran')->row()->nilai;
                } else {
                    $data['totalpengeluaran'] = 0;
                }
            } else {
                $data['sediaan'] = $this->db->query('SELECT * FROM barang_sediaan JOIN master_barang ON barang_sediaan.barang_id = master_barang.id')->result_array();
                $data['penjualan'] = $this->db->query('SELECT * FROM sales_penjualan JOIN master_barang ON sales_penjualan.barang_id = master_barang.id')->result_array();
                $data['akun'] = $this->db->query('SELECT * FROM master_biaya WHERE sales_pengeluaran = 1')->result_array();
                $data['olah'] = 'input';
                $data['no_bukti'] = generate_no_bukti($tanggal, $user['id']);
            }
        }

        $data['title'] = 'Input Penjualan';
        $data['sales'] = $this->db->get('master_user')->result_array();
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['date'] = $tanggal;
        layout1('sales/sales_menu', $data);
    }

    public function tambah($tanggal)
    {
        $nickname = $this->session->userdata('nickname');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $id_user = $user['id'];
        $barang_id = $this->input->post('barang_id');
        $sediaan_id = $this->input->post('sediaan_id');
        $qty_pemakaian = $this->input->post('qty_pemakaian');
        $total = $this->input->post('total');
        $sales_penjualan = [];
        $no_bukti = $this->input->post('no_bukti');
        foreach ($barang_id as $key => $value) {
            if (!empty($total[$key])) {
                $sales_penjualan[] = [
                    'tanggal' => $tanggal,
                    'barang_id' => $barang_id[$key],
                    'sediaan_id' => $sediaan_id[$key],
                    'qty_pemakaian' => $qty_pemakaian[$key],
                    'total' => $total[$key],
                    'user_id' => $id_user,
                    'no_bukti' => $no_bukti,
                ];
            }
        }
        $sediaan = $this->input->post('sediaan');
        $qtyawl = $this->input->post('qtyawl');
        $qtypki = $this->input->post('qtypki');
        $sediaan_penjualan = [];
        foreach ($sediaan as $key => $value) {
            $sediaan_penjualan[] = [
                'tanggal' => $tanggal,
                'sediaan_id' => $value,
                'qty_awal' => $qtyawl[$key],
                'qty_pemakaian' => $qtypki[$key],
                'qty_akhir' => (int) $qtyawl[$key] - (int) $qtypki[$key],
                'user_id' => $id_user,
                'no_bukti' => $no_bukti,
            ];
        }
        $akun_id = $this->input->post('akun_id');
        $keterangan = $this->input->post('keterangan');
        $nilai = $this->input->post('nilai');
        $jumlah = $this->input->post('jumlah');
        $lap_pengeluaran = [];
        foreach ($akun_id as $key => $value) {
            if (!empty($nilai[$key])) {
                $lap_pengeluaran[] = [
                    'akun_id' => $akun_id[$key],
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan[$key],
                    'nilai' => $nilai[$key],
                    'user_id' => $id_user,
                    'no_bukti' => $no_bukti,
                    'jumlah' => $jumlah[$key],
                ];
            }
        }
        $this->db->insert_batch('sales_laporan', $sales_penjualan);
        $this->db->insert_batch('sediaan_laporan', $sediaan_penjualan);
        if (!empty($lap_pengeluaran)) {
            $this->db->insert_batch('lap_pengeluaran', $lap_pengeluaran);
        }
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menambahkan Data Sales Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('sales/sales_menu?tanggal='.$tanggal);
    }

    public function edit($tanggal)
    {
        $nickname = $this->session->userdata('nickname');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $id_user = $user['id'];
        $barang_id = $this->input->post('barang_id');
        $qty_pemakaian = $this->input->post('qty_pemakaian');
        $total = $this->input->post('total');
        $sales_penjualan = [];
        foreach ($barang_id as $key => $value) {
            $sales_penjualan[] = [
                'barang_id' => $barang_id[$key],
                'qty_pemakaian' => $qty_pemakaian[$key],
                'total' => $total[$key],
            ];
        }
        $sediaan = $this->input->post('sediaan');
        $qtyawl = $this->input->post('qtyawl');
        $qtypki = $this->input->post('qtypki');
        $sediaan_penjualan = [];
        foreach ($sediaan as $key => $value) {
            $sediaan_penjualan[] = [
                'id_sad' => $value,
                'qty_awal' => $qtyawl[$key],
                'qty_pemakaian' => $qtypki[$key],
                'qty_akhir' => (int) $qtyawl[$key] - (int) $qtypki[$key],
            ];
        }
        $ceklpengeluaran = $this->db->get_where('lap_pengeluaran', ['tanggal' => $tanggal, 'user_id' => $id_user])->num_rows();
        if ($ceklpengeluaran > 0) {
            $akun_id = $this->input->post('akun_id');
            $keterangan = $this->input->post('keterangan');
            $jumlah = $this->input->post('jumlah');
            $nilai = $this->input->post('nilai');
            $lap_pengeluaran = [];
            foreach ($akun_id as $key => $value) {
                $lap_pengeluaran[] = [
                    'id_pengeluaran' => $akun_id[$key],
                    'keterangan' => $keterangan[$key],
                    'nilai' => $nilai[$key],
                    'jumlah' => $jumlah[$key],
                ];
            }
            $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal]);
            $this->db->update_batch('lap_pengeluaran', $lap_pengeluaran, 'id_pengeluaran');
        }
        $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal]);
        $this->db->update_batch('sales_laporan', $sales_penjualan, 'barang_id');
        $this->db->update_batch('sediaan_laporan', $sediaan_penjualan, 'id_sad');
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Mengedit Data Sales Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('sales/sales_menu?tanggal='.$tanggal);
    }

    public function filter()
    {
        $id = $this->input->post('sales');
        $nickname = $this->session->userdata('nickname');
        $data['olah'] = 'kosong';
        $data['title'] = 'Input Penjualan';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['username'] = $this->db->get_where('master_user', ['id' => $id])->row_array();
        layout1('sales/tambah_rolling', $data);
    }

    public function rolling_sales()
    {
        $nickname = $this->session->userdata('nickname');
        $tanggal = $this->input->get('tanggal');
        $id = $this->input->get('id');

        if ($tanggal) {
            $ceklaporan = $this->db->get_where('sales_laporan', ['tanggal' => $tanggal, 'user_id' => $id])->num_rows();
            if ($ceklaporan > 0) {
                $data['olah'] = 'edit';
                $data['sediaan'] = $this->db->get_where('sediaan_laporan', ['tanggal' => $tanggal, 'user_id' => $id])->result_array();
                $data['penjualan'] = $this->db->get_where('sales_laporan', ['tanggal' => $tanggal, 'user_id' => $id])->result_array();
                $data['pengeluaran'] = $this->db->get_where('lap_pengeluaran', ['tanggal' => $tanggal, 'user_id' => $id])->result_array();
                $data['totalpenjualan'] = $this->db->select_sum('total')->where(['tanggal' => $tanggal, 'user_id' => $id])->get('sales_laporan')->row()->total;
                $ceklpengeluaran = $this->db->get_where('lap_pengeluaran', ['tanggal' => $tanggal, 'user_id' => $id])->num_rows();
                if ($ceklpengeluaran > 0) {
                    $data['totalpengeluaran'] = $this->db->select_sum('nilai')->where(['tanggal' => $tanggal, 'user_id' => $id])->get('lap_pengeluaran')->row()->nilai;
                } else {
                    $data['totalpengeluaran'] = 0;
                }
            } else {
                $data['sediaan'] = $this->db->query('SELECT * FROM barang_sediaan JOIN master_barang ON barang_sediaan.barang_id = master_barang.id')->result_array();
                $data['penjualan'] = $this->db->query('SELECT * FROM sales_penjualan JOIN master_barang ON sales_penjualan.barang_id = master_barang.id')->result_array();
                $data['akun'] = $this->db->query('SELECT * FROM master_biaya WHERE sales_pengeluaran = 1')->result_array();
                $data['olah'] = 'input';
                $data['no_bukti'] = generate_no_bukti($tanggal, $id);
            }
        }

        $data['title'] = 'Input Penjualan';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['username'] = $this->db->get_where('master_user', ['id' => $id])->row_array();
        $data['date'] = $tanggal;
        layout1('sales/tambah_rolling', $data);
    }

    public function tambah_rs($tanggal, $id)
    {
        $nickname = $this->session->userdata('nickname');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $id_user = $id;
        $rolling_id = $user['id'];
        $barang_id = $this->input->post('barang_id');
        $sediaan_id = $this->input->post('sediaan_id');
        $qty_pemakaian = $this->input->post('qty_pemakaian');
        $total = $this->input->post('total');
        $no_bukti = $this->input->post('no_bukti');
        $sales_penjualan = [];
        foreach ($barang_id as $key => $value) {
            if (!empty($total[$key])) {
                $sales_penjualan[] = [
                    'tanggal' => $tanggal,
                    'barang_id' => $barang_id[$key],
                    'sediaan_id' => $sediaan_id[$key],
                    'qty_pemakaian' => $qty_pemakaian[$key],
                    'total' => $total[$key],
                    'user_id' => $id_user,
                    'rolling' => $rolling_id,
                    'no_bukti' => $no_bukti,
                ];
            }
        }
        $sediaan = $this->input->post('sediaan');
        $qtyawl = $this->input->post('qtyawl');
        $qtypki = $this->input->post('qtypki');
        $sediaan_penjualan = [];
        foreach ($sediaan as $key => $value) {
            $sediaan_penjualan[] = [
                'tanggal' => $tanggal,
                'sediaan_id' => $value,
                'qty_awal' => $qtyawl[$key],
                'qty_pemakaian' => $qtypki[$key],
                'qty_akhir' => (int) $qtyawl[$key] - (int) $qtypki[$key],
                'user_id' => $id_user,
                'no_bukti' => $no_bukti,
            ];
        }
        $akun_id = $this->input->post('akun_id');
        $keterangan = $this->input->post('keterangan');
        $jumlah = $this->input->post('jumlah');
        $nilai = $this->input->post('nilai');
        $lap_pengeluaran = [];
        foreach ($akun_id as $key => $value) {
            if (!empty($nilai[$key])) {
                $lap_pengeluaran[] = [
                    'akun_id' => $akun_id[$key],
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan[$key],
                    'nilai' => $nilai[$key],
                    'user_id' => $id_user,
                    'rolling' => $rolling_id,
                    'no_bukti' => $no_bukti,
                    'jumlah' => $jumlah[$key],
                ];
            }
        }
        $this->db->insert_batch('sales_laporan', $sales_penjualan);
        $this->db->insert_batch('sediaan_laporan', $sediaan_penjualan);
        if (!empty($lap_pengeluaran)) {
            $this->db->insert_batch('lap_pengeluaran', $lap_pengeluaran);
        }
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menambahkan Data Sales Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('sales/sales_menu/rolling_sales?tanggal='.$tanggal.'&id='.$id);
    }

    public function edit_rs($tanggal, $id)
    {
        $nickname = $this->session->userdata('nickname');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $id_user = $id;
        $rolling_id = $user['id'];
        $barang_id = $this->input->post('barang_id');
        $qty_pemakaian = $this->input->post('qty_pemakaian');
        $total = $this->input->post('total');
        $sales_penjualan = [];
        foreach ($barang_id as $key => $value) {
            $sales_penjualan[] = [
                'barang_id' => $barang_id[$key],
                'qty_pemakaian' => $qty_pemakaian[$key],
                'total' => $total[$key],
            ];
        }
        $sediaan = $this->input->post('sediaan');
        $qtyawl = $this->input->post('qtyawl');
        $qtypki = $this->input->post('qtypki');
        $sediaan_penjualan = [];
        foreach ($sediaan as $key => $value) {
            $sediaan_penjualan[] = [
                'id_sad' => $value,
                'qty_awal' => $qtyawl[$key],
                'qty_pemakaian' => $qtypki[$key],
                'qty_akhir' => (int) $qtyawl[$key] - (int) $qtypki[$key],
            ];
        }
        $ceklpengeluaran = $this->db->get_where('lap_pengeluaran', ['tanggal' => $tanggal, 'user_id' => $id])->num_rows();
        if ($ceklpengeluaran > 0) {
            $akun_id = $this->input->post('akun_id');
            $keterangan = $this->input->post('keterangan');
            $jumlah = $this->input->post('jumlah');
            $nilai = $this->input->post('nilai');
            $lap_pengeluaran = [];
            foreach ($akun_id as $key => $value) {
                $lap_pengeluaran[] = [
                    'id_pengeluaran' => $akun_id[$key],
                    'keterangan' => $keterangan[$key],
                    'nilai' => $nilai[$key],
                    'jumlah' => $jumlah[$key],
                ];
            }
            $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal]);
            $this->db->update_batch('lap_pengeluaran', $lap_pengeluaran, 'id_pengeluaran');
        }
        $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal]);
        $this->db->update_batch('sales_laporan', $sales_penjualan, 'barang_id');
        $this->db->update_batch('sediaan_laporan', $sediaan_penjualan, 'id_sad');
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Mengedit Data Sales Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('sales/sales_menu/rolling_sales?tanggal='.$tanggal.'&id='.$id);
    }
}
