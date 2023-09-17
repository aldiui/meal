<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master_barang extends CI_Controller
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
            'title' => 'Barang',
            'barang' => $this->db->get('master_barang')->result_array(),
            'kategori' => $this->db->get('master_kategori')->result_array(),
            'nickname' => $this->db->get_where('master_user', ['username' => $nickname])->row_array(),
        ];
        $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required|trim|is_unique[master_barang.kode_barang]');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('kategori_barang', 'Kategori Barang', 'required|trim');
        $this->form_validation->set_rules('satuan_utama', 'Satuan Utama', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');
        if ($this->form_validation->run() == false) {
            layout('admin/master_barang', $data);
        } else {
            $data = [
                'kode_barang' => htmlspecialchars($this->input->post('kode_barang', true)),
                'nama_barang' => htmlspecialchars($this->input->post('nama_barang', true)),
                'kategori_id' => $this->input->post('kategori_barang', true),
                'satuan_utama' => htmlspecialchars($this->input->post('satuan_utama', true)),
                'satuan_kedua' => htmlspecialchars($this->input->post('satuan_kedua', true)),
                'qty_kedua' => htmlspecialchars($this->input->post('qty_kedua', true)),
                'satuan_ketiga' => htmlspecialchars($this->input->post('satuan_ketiga', true)),
                'qty_ketiga' => htmlspecialchars($this->input->post('qty_ketiga', true)),
                'satuan_keempat' => htmlspecialchars($this->input->post('satuan_keempat', true)),
                'qty_keempat' => htmlspecialchars($this->input->post('qty_keempat', true)),
                'satuan_kelima' => htmlspecialchars($this->input->post('satuan_kelima', true)),
                'qty_kelima' => htmlspecialchars($this->input->post('qty_kelima', true)),
                'harga' => htmlspecialchars($this->input->post('harga', true)),
            ];
            $this->db->insert('master_barang', $data);
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Menambahkan Data Barang</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/master_barang');
        }
    }

    public function delete($id)
    {
        $this->db->delete('master_barang', ['id' => $id]);
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Barang</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/master_barang');
    }

    public function edit()
    {
        $this->form_validation->set_rules('kode_barang1', 'Kode Barang', 'required|trim');
        $this->form_validation->set_rules('nama_barang1', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('kategori_barang1', 'Kategori Barang', 'required|trim');
        $this->form_validation->set_rules('satuan_utama1', 'Satuan Utama', 'required|trim');
        $this->form_validation->set_rules('harga1', 'Harga', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $data = [
                'kode_barang' => htmlspecialchars($this->input->post('kode_barang1', true)),
                'nama_barang' => htmlspecialchars($this->input->post('nama_barang1', true)),
                'kategori_id' => $this->input->post('kategori_barang1', true),
                'satuan_utama' => htmlspecialchars($this->input->post('satuan_utama1', true)),
                'satuan_kedua' => htmlspecialchars($this->input->post('satuan_kedua1', true)),
                'qty_kedua' => htmlspecialchars($this->input->post('qty_kedua1', true)),
                'satuan_ketiga' => htmlspecialchars($this->input->post('satuan_ketiga1', true)),
                'qty_ketiga' => htmlspecialchars($this->input->post('qty_ketiga1', true)),
                'satuan_keempat' => htmlspecialchars($this->input->post('satuan_keempat1', true)),
                'qty_keempat' => htmlspecialchars($this->input->post('qty_keempat1', true)),
                'satuan_kelima' => htmlspecialchars($this->input->post('satuan_kelima1', true)),
                'qty_kelima' => htmlspecialchars($this->input->post('qty_kelima1', true)),
                'harga' => htmlspecialchars($this->input->post('harga1', true)),
            ];
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('master_barang', $data);
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
				<div class="text-white">Berhasil Mengedit Data Barang</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('admin/master_barang');
        }
    }
}
