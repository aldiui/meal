<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Serah_terima extends CI_Controller
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
            'title' => 'Serah Terima Penjualan',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
            'ds' => $this->db->select('tanggal, tglserahterima, jamdatang, user_id, dapur_id, no_bukti')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by(['tanggal', 'tglserahterima', 'jamdatang', 'user_id', 'dapur_id', 'no_bukti'])->get()->result_array(),
        ];
        layout('admin/serah_terima', $data);
    }

    public function cari()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
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
            'title' => 'Serah Terima Penjualan',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
            'ds' => $this->db->select('tanggal, tglserahterima, jamdatang, user_id, dapur_id, no_bukti')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by(['tanggal', 'tglserahterima', 'jamdatang', 'user_id', 'dapur_id', 'no_bukti'])->get()->result_array(),
        ];
        layout('admin/serah_terima', $data);
    }

    public function filter()
    {
        $tanggal = $this->input->get('tanggal');
        $sales = $this->input->get('sales');
        $nickname = $this->session->userdata('nickname');
        $data['olah'] = 'kosong';
        if ($tanggal and $sales) {
            $ceklaporan = $this->db->get_where('sales_laporan', ['tanggal' => $tanggal, 'user_id' => $sales])->num_rows();
            if ($ceklaporan > 0) {
                $cekserahterima = $this->db->select('dapur_id')->from('sales_laporan')->where(['tanggal' => $tanggal, 'user_id' => $sales])->group_by('dapur_id')->get()->row_array();
                if ($cekserahterima['dapur_id'] > 0) {
                    $data['olah'] = 'edit';
                    $data['sediaan'] = $this->db->get_where('sediaan_laporan', ['tanggal' => $tanggal, 'user_id' => $sales])->result_array();
                    $data['ds'] = $this->db->select('tglserahterima, jamdatang, sisabubur, sisanasitim, catatan')->from('sales_laporan')->where(['tanggal' => $tanggal, 'user_id' => $sales])->group_by(['tglserahterima', 'jamdatang', 'sisabubur', 'sisanasitim', 'catatan'])->get()->row_array();
                } else {
                    $data['olah'] = 'input';
                    $data['sediaan'] = $this->db->get_where('sediaan_laporan', ['tanggal' => $tanggal, 'user_id' => $sales])->result_array();
                }
            } else {
                $data['olah'] = 'null';
            }
        }
        $data['title'] = 'Serah Terima Penjualan';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['sales'] = $this->db->get_where('master_user', ['role' => 'Sales'])->result_array();
        $data['date'] = $tanggal;
        $data['sales2'] = $sales;
        layout('admin/serah_dapur', $data);
    }

    public function tambah($tanggal, $id)
    {
        $nickname = $this->session->userdata('nickname');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $id_user = $id;
        $dapur_id = $user['id'];
        $sediaan = $this->input->post('sediaan');
        $qtycek = $this->input->post('qty_cek');
        $qtyselisih = $this->input->post('qty_selisih');
        $qtyrusak = $this->input->post('qty_rusak');
        $sediaan_penjualan = [];
        foreach ($sediaan as $key => $value) {
            $sediaan_penjualan[] = [
                'id_sad' => $value,
                'qty_cek' => $qtycek[$key],
                'qty_selisih' => $qtyselisih[$key],
                'qty_rusak' => $qtyrusak[$key],
                'dapur_id' => $user['id'],
            ];
        }
        $tglserah = $this->input->post('tglserah');
        $jamdatang = $this->input->post('jamdatang');
        $sisabubur = $this->input->post('sisabubur');
        $sisanasi = $this->input->post('sisanasi');
        $catatan = $this->input->post('catatan');
        $sales_penjualan = [
            'tglserahterima' => $tglserah,
            'dapur_id' => $user['id'],
            'jamdatang' => $jamdatang,
            'sisabubur' => $sisabubur,
            'sisanasitim' => $sisanasi,
            'catatan' => $catatan,
        ];
        $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal]);
        $this->db->update('sales_laporan', $sales_penjualan);
        $this->db->update_batch('sediaan_laporan', $sediaan_penjualan, 'id_sad');
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menambahakn Data Serah Terima</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/serah_terima/filter?tanggal='.$tanggal.'&sales='.$id);
    }

    public function edit($tanggal, $id)
    {
        $nickname = $this->session->userdata('nickname');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $id_user = $id;
        $dapur_id = $user['id'];
        $sediaan = $this->input->post('sediaan');
        $qtycek = $this->input->post('qty_cek');
        $qtyselisih = $this->input->post('qty_selisih');
        $qtyrusak = $this->input->post('qty_rusak');
        $sediaan_penjualan = [];
        foreach ($sediaan as $key => $value) {
            $sediaan_penjualan[] = [
                'id_sad' => $value,
                'qty_cek' => $qtycek[$key],
                'qty_selisih' => $qtyselisih[$key],
                'qty_rusak' => $qtyrusak[$key],
            ];
        }
        $tglserah = $this->input->post('tglserah');
        $jamdatang = $this->input->post('jamdatang');
        $sisabubur = $this->input->post('sisabubur');
        $sisanasi = $this->input->post('sisanasi');
        $catatan = $this->input->post('catatan');
        $sales_penjualan = [
            'tglserahterima' => $tglserah,
            'jamdatang' => $jamdatang,
            'sisabubur' => $sisabubur,
            'sisanasitim' => $sisanasi,
            'catatan' => $catatan,
        ];
        $this->db->where(['user_id' => $id_user, 'tanggal' => $tanggal]);
        $this->db->update('sales_laporan', $sales_penjualan);
        $this->db->update_batch('sediaan_laporan', $sediaan_penjualan, 'id_sad');
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menambahakn Data Serah Terima</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/serah_terima/filter?tanggal='.$tanggal.'&sales='.$id);
    }
}
