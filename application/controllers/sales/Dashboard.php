<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $nickname = $this->session->userdata('nickname');
        $bulan = date('m');
        $tahun = date('Y');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $banyakDataPerTanggal = $this->db->select('tanggal')->from('sales_laporan')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('tanggal')->get()->num_rows();
        if ($banyakDataPerTanggal == 0) {
            $rataRata = 0;
            $totalPenjualan = 0;
            $tp = 0;
            $penjualan = 0;
            $penjualanDetail = 0;
            $outlet = 0;
            $performaBarang = 0;
        } else {
            $totalPenjualan = $this->db->select_sum('total')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->get('sales_laporan')->row()->total;
            $rataRata = $totalPenjualan / $banyakDataPerTanggal;
            $tp = $this->db->select('barang_id, SUM(qty_pemakaian) as pemakaian, SUM(total) as total_harga')->from('sales_laporan')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('barang_id')->get()->result_array();
            $penjualan = $this->db->select('tanggal, no_bukti, rolling, user_id, SUM(total) as total_harga')->from('sales_laporan')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('tanggal')->group_by('user_id')->group_by('tanggal')->group_by('rolling')->group_by('no_bukti')->get()->result_array();
            $this->db->order_by('tanggal', 'ASC');
            $penjualanDetail = $this->db->get_where('sales_laporan', ['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->result_array();
            $outlet = $this->db->select("DATE_FORMAT(tanggal, '%d') as day, SUM(total) as total_sales")->from('sales_laporan')->where('user_id', $user['id'])->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->order_by('tanggal')->group_by(['DAY(tanggal)', 'tanggal'])->get()->result();
            $performaBarang = [];
            foreach ($tp as $row) {
                $datares = [];
                foreach ($penjualanDetail as $val) {
                    if ($row['barang_id'] == $val['barang_id']) {
                        array_push($datares, $val['qty_pemakaian']);
                    }
                }
                array_push($performaBarang, [
                    'name' => getBarang($row['barang_id']),
                    'data' => $datares,
                ]);
            }
        }
        $data['performaBarang'] = $performaBarang;
        $data['tp'] = $tp;
        $data['outlet'] = $outlet;
        $data['pj'] = $penjualan;
        $data['pd'] = $penjualanDetail;
        $data['title'] = 'Dashboard';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['totalPenjualan'] = $totalPenjualan;
        $data['rataRata'] = $rataRata;
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
        dashboardsales('sales/dashboard', $data);
    }

    public function caridata()
    {
        $nickname = $this->session->userdata('nickname');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $banyakDataPerTanggal = $this->db->select('tanggal')->from('sales_laporan')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('tanggal')->get()->num_rows();
        if ($banyakDataPerTanggal == 0) {
            $rataRata = 0;
            $totalPenjualan = 0;
            $tp = 0;
            $penjualan = 0;
            $penjualanDetail = 0;
            $outlet = 0;
            $performaBarang = 0;
        } else {
            $totalPenjualan = $this->db->select_sum('total')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->get('sales_laporan')->row()->total;
            $rataRata = $totalPenjualan / $banyakDataPerTanggal;
            $tp = $this->db->select('barang_id, SUM(qty_pemakaian) as pemakaian, SUM(total) as total_harga')->from('sales_laporan')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('barang_id')->get()->result_array();
            $penjualan = $this->db->select('tanggal, no_bukti, rolling, user_id, SUM(total) as total_harga')->from('sales_laporan')->where(['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('tanggal')->group_by('user_id')->group_by('tanggal')->group_by('rolling')->group_by('no_bukti')->get()->result_array();
            $this->db->order_by('tanggal', 'ASC');
            $penjualanDetail = $this->db->get_where('sales_laporan', ['user_id' => $user['id'], 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->result_array();
            $outlet = $this->db->select("DATE_FORMAT(tanggal, '%d') as day, SUM(total) as total_sales")->from('sales_laporan')->where('user_id', $user['id'])->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->order_by('tanggal')->group_by(['DAY(tanggal)', 'tanggal'])->get()->result();
            $performaBarang = [];
            foreach ($tp as $row) {
                $datares = [];
                foreach ($penjualanDetail as $val) {
                    if ($row['barang_id'] == $val['barang_id']) {
                        array_push($datares, $val['qty_pemakaian']);
                    }
                }
                array_push($performaBarang, [
                    'name' => getBarang($row['barang_id']),
                    'data' => $datares,
                ]);
            }
        }
        $data['performaBarang'] = $performaBarang;
        $data['outlet'] = $outlet;
        $data['tp'] = $tp;
        $data['pj'] = $penjualan;
        $data['pd'] = $penjualanDetail;
        $data['title'] = 'Dashboard';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['totalPenjualan'] = $totalPenjualan;
        $data['rataRata'] = $rataRata;
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
        dashboardsales('sales/dashboard', $data);
    }
}
