<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Validasi_data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('nickname')) {
            redirect('auth');
        } elseif ($this->session->userdata('role') == 'Sales') {
            redirect('sales/dashboard');
        } elseif ($this->session->userdata('role') == 'Dapur') {
            redirect('dapur/dashboard');
        }
    }

    public function index()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $pilihbulan = [
            ['no' => 1, 'nama' => 'Januari'],
            ['no' => 2, 'nama' => 'Februari'],
            ['no' => 3, 'nama' => 'Maret'],
            ['no' => 4, 'nama' => 'April'],
            ['no' => 5, 'nama' => 'Mei'],
            ['no' => 6, 'nama' => 'Juni'],
            ['no' => 7, 'nama' => 'Juli'],
            ['no' => 8, 'nama' => 'Agustus'],
            ['no' => 9, 'nama' => 'September'],
            ['no' => 10, 'nama' => 'Oktober'],
            ['no' => 11, 'nama' => 'November'],
            ['no' => 12, 'nama' => 'Desember'],
        ];
        $pilihtahun = [date('Y'), date('Y') - 1, date('Y') - 2, date('Y') - 3, date('Y') - 4];
        $nickname = $this->session->userdata('nickname');
        $penjualan = $this->db->select('tanggal, no_bukti, rolling, user_id, SUM(total) as total_harga')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 0])->order_by('tanggal')->group_by('user_id')->group_by('no_bukti')->group_by('tanggal')->group_by('rolling')->get()->result_array();
        $data = [
            'title' => 'Validasi Data',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'penjualan' => $penjualan,
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
        ];
        layout('admin/validasi_data', $data);
    }

    public function dapur()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $nickname = $this->session->userdata('nickname');
        $data['bulan'] = [
            ['no' => 1, 'nama' => 'Januari'],
            ['no' => 2, 'nama' => 'Februari'],
            ['no' => 3, 'nama' => 'Maret'],
            ['no' => 4, 'nama' => 'April'],
            ['no' => 5, 'nama' => 'Mei'],
            ['no' => 6, 'nama' => 'Juni'],
            ['no' => 7, 'nama' => 'Juli'],
            ['no' => 8, 'nama' => 'Agustus'],
            ['no' => 9, 'nama' => 'September'],
            ['no' => 10, 'nama' => 'Oktober'],
            ['no' => 11, 'nama' => 'November'],
            ['no' => 12, 'nama' => 'Desember'],
        ];
        $data['tahun'] = [date('Y'), date('Y') - 1, date('Y') - 2, date('Y') - 3, date('Y') - 4];
        $data['month'] = $bulan;
        $data['year'] = $tahun;
        $data['title'] = 'Input Barang';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['dapur'] = $this->db->select('tanggal, transaksi, status, rolling, no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 0])->order_by('tanggal')->group_by('user_id')->group_by('no_dok')->group_by('tanggal')->group_by('rolling')->group_by('status')->group_by('transaksi')->get()->result_array();
        layout('admin/dapur', $data);
    }

    public function caridpr()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $nickname = $this->session->userdata('nickname');
        $data['bulan'] = [
            ['no' => 1, 'nama' => 'Januari'],
            ['no' => 2, 'nama' => 'Februari'],
            ['no' => 3, 'nama' => 'Maret'],
            ['no' => 4, 'nama' => 'April'],
            ['no' => 5, 'nama' => 'Mei'],
            ['no' => 6, 'nama' => 'Juni'],
            ['no' => 7, 'nama' => 'Juli'],
            ['no' => 8, 'nama' => 'Agustus'],
            ['no' => 9, 'nama' => 'September'],
            ['no' => 10, 'nama' => 'Oktober'],
            ['no' => 11, 'nama' => 'November'],
            ['no' => 12, 'nama' => 'Desember'],
        ];
        $data['tahun'] = [date('Y'), date('Y') - 1, date('Y') - 2, date('Y') - 3, date('Y') - 4];
        $data['month'] = $bulan;
        $data['year'] = $tahun;
        $data['title'] = 'Input Barang';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['dapur'] = $this->db->select('tanggal, no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 0])->order_by('tanggal')->group_by('user_id')->group_by('no_dok')->group_by('tanggal')->get()->result_array();
        layout('admin/dapur', $data);
    }

    public function carivalid()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $pilihbulan = [
            ['no' => 1, 'nama' => 'Januari'],
            ['no' => 2, 'nama' => 'Februari'],
            ['no' => 3, 'nama' => 'Maret'],
            ['no' => 4, 'nama' => 'April'],
            ['no' => 5, 'nama' => 'Mei'],
            ['no' => 6, 'nama' => 'Juni'],
            ['no' => 7, 'nama' => 'Juli'],
            ['no' => 8, 'nama' => 'Agustus'],
            ['no' => 9, 'nama' => 'September'],
            ['no' => 10, 'nama' => 'Oktober'],
            ['no' => 11, 'nama' => 'November'],
            ['no' => 12, 'nama' => 'Desember'],
        ];
        $pilihtahun = [date('Y'), date('Y') - 1, date('Y') - 2, date('Y') - 3, date('Y') - 4];
        $nickname = $this->session->userdata('nickname');
        $penjualan = $this->db->select('tanggal, no_bukti, rolling, user_id, SUM(total) as total_harga')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 0])->order_by('tanggal')->group_by('user_id')->group_by('no_bukti')->group_by('tanggal')->group_by('rolling')->get()->result_array();
        $data = [
            'title' => 'Validasi Data',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'penjualan' => $penjualan,
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
        ];
        layout('admin/validasi_data', $data);
    }

    public function data()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $days = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $nickname = $this->session->userdata('nickname');

        $pilihbulan = [
            ['no' => 1, 'nama' => 'Januari'],
            ['no' => 2, 'nama' => 'Februari'],
            ['no' => 3, 'nama' => 'Maret'],
            ['no' => 4, 'nama' => 'April'],
            ['no' => 5, 'nama' => 'Mei'],
            ['no' => 6, 'nama' => 'Juni'],
            ['no' => 7, 'nama' => 'Juli'],
            ['no' => 8, 'nama' => 'Agustus'],
            ['no' => 9, 'nama' => 'September'],
            ['no' => 10, 'nama' => 'Oktober'],
            ['no' => 11, 'nama' => 'November'],
            ['no' => 12, 'nama' => 'Desember'],
        ];
        $pilihtahun = [date('Y'), date('Y') - 1, date('Y') - 2, date('Y') - 3, date('Y') - 4];
        $data = [
            'title' => 'Lap Input Data',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'tanggal' => $days,
            'user' => $this->db->get_where('master_user', ['role' => 'Sales'])->result_array(),
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
        ];
        layout('admin/data_input', $data);
    }

    public function caridata()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $days = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $nickname = $this->session->userdata('nickname');

        $pilihbulan = [
            ['no' => 1, 'nama' => 'Januari'],
            ['no' => 2, 'nama' => 'Februari'],
            ['no' => 3, 'nama' => 'Maret'],
            ['no' => 4, 'nama' => 'April'],
            ['no' => 5, 'nama' => 'Mei'],
            ['no' => 6, 'nama' => 'Juni'],
            ['no' => 7, 'nama' => 'Juli'],
            ['no' => 8, 'nama' => 'Agustus'],
            ['no' => 9, 'nama' => 'September'],
            ['no' => 10, 'nama' => 'Oktober'],
            ['no' => 11, 'nama' => 'November'],
            ['no' => 12, 'nama' => 'Desember'],
        ];
        $pilihtahun = [date('Y'), date('Y') - 1, date('Y') - 2, date('Y') - 3, date('Y') - 4];
        $data = [
            'title' => 'Lap Input Data',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'tanggal' => $days,
            'user' => $this->db->get_where('master_user', ['role' => 'Sales'])->result_array(),
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
        ];
        layout('admin/data_input', $data);
    }

    public function validasi()
    {
        $no_bukti = $this->input->post('checkbox');
        if (!empty($no_bukti)) {
            for ($i = 0; $i < count($no_bukti); ++$i) {
                $this->db->where(['no_bukti' => $no_bukti[$i]]);
                $this->db->update('sales_laporan', ['status' => 1]);
                $this->db->update('sediaan_laporan', ['status' => 1]);
                $this->db->update('lap_pengeluaran', ['status' => 1]);
            }
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Validasi Data</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/validasi_data');
        } else {
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-danger alert-dismissible fade show">
				<div class="text-white">Tidak Ada Data Yang Dipilih</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/validasi_data');
        }
    }

    public function validasidpr()
    {
        $no_dok = $this->input->post('checkbox');
        if (!empty($no_dok)) {
            for ($i = 0; $i < count($no_dok); ++$i) {
                $this->db->where(['no_dok' => $no_dok[$i]]);
                $this->db->update('dapur_pengeluaran', ['status' => 1]);
                $this->db->update('dapur_pembelian', ['status' => 1]);
            }
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Validasi Data</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/validasi_data/dapur');
        } else {
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-danger alert-dismissible fade show">
				<div class="text-white">Tidak Ada Data Yang Dipilih</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/validasi_data/dapur');
        }
    }
}
