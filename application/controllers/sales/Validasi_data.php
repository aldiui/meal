<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Validasi_data extends CI_Controller
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
            'title' => 'Lap Data Input',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'tanggal' => $days,
            'user' => $this->db->get_where('master_user', ['role' => 'Sales'])->result_array(),
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
        ];
        layout1('sales/data_input', $data);
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
            'title' => 'Lap Data Input',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'tanggal' => $days,
            'user' => $this->db->get_where('master_user', ['role' => 'Sales'])->result_array(),
            'bulan' => $pilihbulan,
            'tahun' => $pilihtahun,
            'month' => $bulan,
            'year' => $tahun,
        ];
        layout1('sales/data_input', $data);
    }
}
