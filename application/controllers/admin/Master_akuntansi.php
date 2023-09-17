<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master_akuntansi extends CI_Controller
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
        $nickname = $this->session->userdata('nickname');
        $data = [
            'title' => 'Master Akuntansi',
            'akuntansi' => $this->db->get('master_akuntansi')->result_array(),
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'tipe' => ['Persediaan', 'Pendapatan Lain', 'Pendapatan', 'Kas/Bank', 'Hutang Lancar Lainnya', 'Hutang Jangka Panjang', 'Harga Pokok Penjualan', 'Ekuitas', 'Beban Lain-lain', 'Beban', 'Akun Piutang', 'Akun Hutang', 'Aktiva Tetap', 'Aktiva Lengkap', 'Aktiva Lancar Lainnya'],
        ];
        $this->form_validation->set_rules('kode_akun', 'Kode Akun', 'required|trim|is_unique[master_akuntansi.kode_akun]');
        $this->form_validation->set_rules('nama_akun', 'Nama Akun', 'required|trim');
        $this->form_validation->set_rules('tipe_akun', 'Tipe Akun', 'required|trim');
        if ($this->form_validation->run() == false) {
            layout('admin/master_akuntansi', $data);
        } else {
            $data = [
                'kode_akun' => htmlspecialchars($this->input->post('kode_akun', true)),
                'nama_akun' => htmlspecialchars($this->input->post('nama_akun', true)),
                'tipe_akun' => $this->input->post('tipe_akun', true),
            ];
            $this->db->insert('master_akuntansi', $data);
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Menambahkan Data Master Akuntansi</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/master_akuntansi');
        }
    }

    public function delete($id)
    {
        $this->db->delete('master_akuntansi', ['id' => $id]);
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Master Akuntansi</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/master_akuntansi');
    }

    public function edit()
    {
        $this->form_validation->set_rules('kode_akun1', 'Kode Akun', 'required|trim');
        $this->form_validation->set_rules('nama_akun1', 'Nama Akun', 'required|trim');
        $this->form_validation->set_rules('tipe_akun1', 'Tipe Akun', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $data = [
                'kode_akun' => htmlspecialchars($this->input->post('kode_akun1', true)),
                'nama_akun' => htmlspecialchars($this->input->post('nama_akun1', true)),
                'tipe_akun' => $this->input->post('tipe_akun1', true),
            ];
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('master_akuntansi', $data);
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Mengedit Data Master Akuntansi</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/master_akuntansi');
        }
    }
}
