<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master_template extends CI_Controller
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
            'title' => 'Sales Sediaan',
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
            'sediaan' => $this->db->query('SELECT * FROM barang_sediaan JOIN master_barang ON barang_sediaan.barang_id = master_barang.id')->result_array(),
        ];
        layout('admin/master_template', $data);
    }

    public function tambah()
    {
        if ($this->input->post('checkbox')) {
            $checkbox = $this->input->post('checkbox');
            $data = [];
            $index = 0;
            foreach ($checkbox as $row) {
                array_push($data, [
                    'barang_id' => $row,
                ]);
                ++$index;
            }
            $this->db->insert_batch('barang_sediaan', $data);
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                <div class="text-white">Berhasil Menambahkan Data Sales Sediaan</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('admin/master_template'));
        } else {
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                <div class="text-white">Tidak Ada Data Yang Dipilih</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('admin/master_template'));
        }
    }

    public function delete($id)
    {
        $this->db->delete('barang_sediaan', ['barang_id' => $id]);
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Sales Sediaan</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/master_template');
    }
}
