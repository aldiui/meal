<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Serah_terima extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('nickname')) {
            redirect('auth');
        }
        if ($this->session->userdata('role') == 'Admin') {
            redirect('admin/dashboard');
        } elseif ($this->session->userdata('role') == 'Sales') {
            redirect('sales/dashboard');
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
        layout2('dapur/serah_terima', $data);
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
        layout2('dapur/serah_terima', $data);
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
        layout2('dapur/serah_dapur', $data);
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
        redirect('dapur/serah_terima/filter?tanggal='.$tanggal.'&sales='.$id);
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
        redirect('dapur/serah_terima/filter?tanggal='.$tanggal.'&sales='.$id);
    }

    public function excel($bulan, $tahun)
    {
        $spreadsheet = new Spreadsheet();
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Lap Serah Terima');

        $sheet1->setCellValue('A1', 'No');
        $sheet1->setCellValue('B1', 'Tgl Serah Terima');
        $sheet1->setCellValue('C1', 'Outlet');
        $sheet1->setCellValue('D1', 'Jam Datang');
        $sheet1->setCellValue('E1', 'Bubur');
        $sheet1->setCellValue('F1', 'Nasi Tim');
        $sheet1->setCellValue('G1', 'Cup');
        $sheet1->setCellValue('H1', 'Puding');
        $sheet1->setCellValue('I1', 'Oatmeal');
        $sheet1->setCellValue('J1', 'Sayur');

        $sheet1->getColumnDimension('A')->setWidth(5);
        $sheet1->getColumnDimension('B')->setWidth(20);
        $sheet1->getColumnDimension('C')->setWidth(15);
        $sheet1->getColumnDimension('D')->setWidth(12);
        $sheet1->getColumnDimension('E')->setWidth(12);
        $sheet1->getColumnDimension('F')->setWidth(12);
        $sheet1->getColumnDimension('G')->setWidth(12);
        $sheet1->getColumnDimension('H')->setWidth(12);
        $sheet1->getColumnDimension('I')->setWidth(12);
        $sheet1->getColumnDimension('J')->setWidth(12);

        $sheet1->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet1->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle('A1:J1')->getFont()->setBold(true);

        $serta = $this->db->select('tanggal, tglserahterima, jamdatang, user_id, dapur_id, sisanasitim, sisabubur, no_bukti')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1, 'dapur_id !=' => 0])->group_by(['tanggal', 'tglserahterima', 'jamdatang', 'user_id', 'dapur_id', 'sisanasitim', 'sisabubur', 'no_bukti'])->get()->result_array();
        $no3 = 1;
        $x3 = 2;
        foreach ($serta as $row) {
            $sheet1->setCellValue('A'.$x3, $no3++);
            $sheet1->setCellValue('B'.$x3, $row['tglserahterima']);
            $sheet1->setCellValue('C'.$x3, getOutlet3($row['user_id']));
            $sheet1->setCellValue('D'.$x3, $row['jamdatang']);
            $sheet1->setCellValue('E'.$x3, $row['sisabubur']);
            $sheet1->setCellValue('F'.$x3, $row['sisanasitim']);
            $cupserta = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 1])->row_array();
            $sheet1->setCellValue('G'.$x3, $cupserta['qty_akhir'] - $cupserta['qty_selisih']);
            $cupserta1 = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 2])->row_array();
            $sheet1->setCellValue('H'.$x3, $cupserta1['qty_akhir'] - $cupserta1['qty_selisih']);
            $cupserta2 = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 3])->row_array();
            $sheet1->setCellValue('I'.$x3, $cupserta2['qty_akhir'] - $cupserta2['qty_selisih']);
            $cupserta3 = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 4])->row_array();
            $sheet1->setCellValue('J'.$x3, $cupserta3['qty_akhir'] - $cupserta3['qty_selisih']);
            $sheet1->getStyle('A'.$x3.':J'.$x3)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet1->getStyle('A'.$x3.':B'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            ++$x3;
        }

        $sheet1->mergeCells('A'.$x3.':D'.$x3);
        $sheet1->setCellValue('A'.$x3, 'Total');
        $sheet1->setCellValue('E'.$x3, '=SUM(E2:E'.($x3 - 1).')');
        $sheet1->setCellValue('F'.$x3, '=SUM(F2:F'.($x3 - 1).')');
        $sheet1->setCellValue('G'.$x3, '=SUM(G2:G'.($x3 - 1).')');
        $sheet1->setCellValue('H'.$x3, '=SUM(H2:H'.($x3 - 1).')');
        $sheet1->setCellValue('I'.$x3, '=SUM(I2:I'.($x3 - 1).')');
        $sheet1->setCellValue('J'.$x3, '=SUM(J2:J'.($x3 - 1).')');
        $sheet1->getStyle('A'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle('A'.$x3.':J'.$x3)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet1->getStyle('A'.$x3.':J'.$x3)->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Serah Terima'.Tglindo('-'.$bulan.'-').$tahun;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
