<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends CI_Controller
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
        $bulan = date('m');
        $tahun = date('Y');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $banyakDataPerTanggal = $this->db->select('tanggal')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('tanggal')->get()->num_rows();
        if ($banyakDataPerTanggal == 0) {
            $rataRata = 0;
            $totalPenjualan = 0;
            $tp = 0;
            $penjualan = 0;
            $penjualanDetail = 0;
            $outlet = 0;
            $performaBarang = 0;
            $perSalesOutlet = 0;
            $outletasli = 0;
            $pemakaian = 0;
            $totalpenjualanhari = 0;
        } else {
            $totalPenjualan = $this->db->select_sum('total')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->get('sales_laporan')->row()->total;
            $rataRata = $totalPenjualan / $banyakDataPerTanggal;
            $tp = $this->db->select('barang_id, SUM(qty_pemakaian) as pemakaian, SUM(total) as total_harga')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('barang_id')->get()->result_array();
            $penjualan = $this->db->select('tanggal, no_bukti, rolling, user_id, SUM(total) as total_harga')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('tanggal')->group_by('user_id')->group_by('tanggal')->group_by('rolling')->group_by('no_bukti')->get()->result_array();
            $this->db->order_by('tanggal', 'ASC');
            $penjualanDetail = $this->db->get_where('sales_laporan', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->result_array();
            $outlet = $this->db->select("DATE_FORMAT(tanggal, '%d') as day, SUM(total) as total_sales")->from('sales_laporan')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->order_by('tanggal')->group_by(['DAY(tanggal)', 'tanggal'])->get()->result();
            $perBarang = $this->db->select('barang_id, SUM(qty_pemakaian) as pemakaian, tanggal')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by(['barang_id', 'tanggal'])->get()->result_array();
            $outletasli = $this->db->get('master_outlet')->result_array();
            $tp2 = $this->db->select('outlet_id, SUM(total) as total_harga')->from('sales_laporan')->join('master_user', 'sales_laporan.user_id = master_user.id')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by(['tanggal', 'outlet_id'])->get()->result_array();
            $pemakaian = $this->db->select('outlet_id, SUM(qty_pemakaian) as pakai')->from('sales_laporan')->join('master_user', 'sales_laporan.user_id = master_user.id')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('outlet_id')->group_by('outlet_id')->get()->result_array();
            $totalpenjualanhari = $this->db->select('tanggal, SUM(total) as total_sales')->from('sales_laporan')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->order_by('tanggal')->group_by('tanggal')->get()->result_array();
            $performaBarang = [];
            foreach ($tp as $row) {
                $datares = [];
                foreach ($perBarang as $val) {
                    if ($row['barang_id'] == $val['barang_id']) {
                        array_push($datares, $val['pemakaian']);
                    }
                }
                array_push($performaBarang, [
                    'name' => getBarang($row['barang_id']),
                    'data' => $datares,
                ]);
            }
            $perSalesOutlet = [];
            foreach ($outletasli as $row) {
                $datares = [];
                foreach ($tp2 as $val) {
                    if ($row['id'] == $val['outlet_id']) {
                        array_push($datares, $val['total_harga']);
                    }
                }
                array_push($perSalesOutlet, [
                    'name' => getOutlet($row['id']),
                    'data' => $datares,
                ]);
            }
        }

        $data['performaBarang'] = $performaBarang;
        $data['perSalesOutlet'] = $perSalesOutlet;
        $data['pemakaian'] = $pemakaian;
        $data['outletasli'] = $outletasli;
        $data['tp'] = $tp;
        $data['totalpenjualanhari'] = $totalpenjualanhari;
        $data['pj'] = $penjualan;
        $data['outlet'] = $outlet;
        $data['pd'] = $penjualanDetail;
        $data['title'] = 'Dashboard';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['totalPenjualan'] = $totalPenjualan;
        $data['rataRata'] = $rataRata;
        $data['dapur'] = $this->db->select('tanggal, transaksi, status, rolling, no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('tanggal')->group_by('user_id')->group_by('no_dok')->group_by('tanggal')->group_by('rolling')->group_by('status')->group_by('transaksi')->get()->result_array();
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
        dashboardadmin('admin/dashboard', $data);
    }

    public function caridata()
    {
        $nickname = $this->session->userdata('nickname');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $user = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $banyakDataPerTanggal = $this->db->select('tanggal')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('tanggal')->get()->num_rows();
        if ($banyakDataPerTanggal == 0) {
            $rataRata = 0;
            $totalPenjualan = 0;
            $tp = 0;
            $penjualan = 0;
            $penjualanDetail = 0;
            $outlet = 0;
            $performaBarang = 0;
            $perSalesOutlet = 0;
            $outletasli = 0;
            $pemakaian = 0;
            $totalpenjualanhari = 0;
        } else {
            $totalPenjualan = $this->db->select_sum('total')->where(['YEAR(tanggal)' => $tahun])->get('sales_laporan')->row()->total;
            $banyakDataPerTanggal = $this->db->select('tanggal')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('tanggal')->get()->num_rows();
            $rataRata = $totalPenjualan / $banyakDataPerTanggal;
            $tp = $this->db->select('barang_id, SUM(qty_pemakaian) as pemakaian, SUM(total) as total_harga')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by('barang_id')->get()->result_array();
            $this->db->order_by('tanggal', 'ASC');
            $penjualanDetail = $this->db->get_where('sales_laporan', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->result_array();
            $outlet = $this->db->select("DATE_FORMAT(tanggal, '%d') as day, SUM(total) as total_sales")->from('sales_laporan')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->order_by('tanggal')->group_by(['DAY(tanggal)', 'tanggal'])->get()->result();
            $penjualan = $this->db->select('tanggal, no_bukti, rolling, user_id, SUM(total) as total_harga')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('tanggal')->group_by('user_id')->group_by('tanggal')->group_by('rolling')->group_by('no_bukti')->get()->result_array();
            $this->db->order_by('tanggal', 'ASC');
            $outlet = $this->db->select("DATE_FORMAT(tanggal, '%d') as day, SUM(total) as total_sales")->from('sales_laporan')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->order_by('tanggal')->group_by(['DAY(tanggal)', 'tanggal'])->get()->result();
            $perBarang = $this->db->select('barang_id, SUM(qty_pemakaian) as pemakaian, tanggal')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by(['barang_id', 'tanggal'])->get()->result_array();
            $outletasli = $this->db->get('master_outlet')->result_array();
            $tp2 = $this->db->select('outlet_id, SUM(total) as total_harga')->from('sales_laporan')->join('master_user', 'sales_laporan.user_id = master_user.id')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->group_by(['tanggal', 'outlet_id'])->get()->result_array();
            $pemakaian = $this->db->select('outlet_id, SUM(qty_pemakaian) as pakai')->from('sales_laporan')->join('master_user', 'sales_laporan.user_id = master_user.id')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('outlet_id')->group_by('outlet_id')->get()->result_array();
            $totalpenjualanhari = $this->db->select('tanggal, SUM(total) as total_sales')->from('sales_laporan')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->order_by('tanggal')->group_by('tanggal')->get()->result_array();
            $performaBarang = [];
            foreach ($tp as $row) {
                $datares = [];
                foreach ($perBarang as $val) {
                    if ($row['barang_id'] == $val['barang_id']) {
                        array_push($datares, $val['pemakaian']);
                    }
                }
                array_push($performaBarang, [
                    'name' => getBarang($row['barang_id']),
                    'data' => $datares,
                ]);
            }
            $perSalesOutlet = [];
            foreach ($outletasli as $row) {
                $datares = [];
                foreach ($tp2 as $val) {
                    if ($row['id'] == $val['outlet_id']) {
                        array_push($datares, $val['total_harga']);
                    }
                }
                array_push($perSalesOutlet, [
                    'name' => getOutlet($row['id']),
                    'data' => $datares,
                ]);
            }
        }
        $data['performaBarang'] = $performaBarang;
        $data['perSalesOutlet'] = $perSalesOutlet;
        $data['pemakaian'] = $pemakaian;
        $data['outletasli'] = $outletasli;
        $data['pj'] = $penjualan;
        $data['tp'] = $tp;
        $data['month'] = $bulan;
        $data['year'] = $tahun;
        $data['outlet'] = $outlet;
        $data['pd'] = $penjualanDetail;
        $data['totalpenjualanhari'] = $totalpenjualanhari;
        $data['title'] = 'Dashboard';
        $data['nickname'] = $this->db->get_where('master_user', ['username' => $nickname])->row_array();
        $data['totalPenjualan'] = $totalPenjualan;
        $data['rataRata'] = $rataRata;
        $data['dapur'] = $this->db->select('tanggal, transaksi, status, rolling, no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun])->order_by('tanggal')->group_by('user_id')->group_by('no_dok')->group_by('tanggal')->group_by('rolling')->group_by('status')->group_by('transaksi')->get()->result_array();
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
        dashboardadmin('admin/dashboard', $data);
    }

    public function excel($bulan, $tahun)
    {
        $spreadsheet = new Spreadsheet();
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Laporan Penjualan');

        $sheet1->setCellValue('A1', 'No');
        $sheet1->setCellValue('B1', 'No Bukti');
        $sheet1->setCellValue('C1', 'Tanggal');
        $sheet1->setCellValue('D1', 'Kode Barang');
        $sheet1->setCellValue('E1', 'Nama Barang');
        $sheet1->setCellValue('F1', 'Kode Outlet');
        $sheet1->setCellValue('G1', 'Sales');
        $sheet1->setCellValue('H1', 'Status Rolling');
        $sheet1->setCellValue('I1', 'Qty');
        $sheet1->setCellValue('J1', 'Harga');
        $sheet1->setCellValue('K1', 'Nominal');

        $sheet1->getColumnDimension('A')->setWidth(5);
        $sheet1->getColumnDimension('B')->setWidth(20);
        $sheet1->getColumnDimension('C')->setWidth(12);
        $sheet1->getColumnDimension('D')->setWidth(12);
        $sheet1->getColumnDimension('E')->setWidth(30);
        $sheet1->getColumnDimension('F')->setWidth(12);
        $sheet1->getColumnDimension('G')->setWidth(15);
        $sheet1->getColumnDimension('H')->setWidth(15);
        $sheet1->getColumnDimension('I')->setWidth(7);
        $sheet1->getColumnDimension('J')->setWidth(15);
        $sheet1->getColumnDimension('K')->setWidth(20);

        $sheet1->getStyle('A1:K1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet1->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle('A1:K1')->getFont()->setBold(true);

        $this->db->order_by('tanggal');
        $penjualan = $this->db->get_where('sales_laporan', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1])->result_array();
        $no = 1;
        $x = 2;
        foreach ($penjualan as $row) {
            $sheet1->setCellValue('A'.$x, $no++);
            $sheet1->setCellValue('B'.$x, $row['no_bukti']);
            $sheet1->setCellValue('C'.$x, $row['tanggal']);
            $barang = $this->db->get_where('master_barang', ['id' => $row['barang_id']])->row_array();
            $sheet1->setCellValue('D'.$x, $barang['kode_barang']);
            $sheet1->setCellValue('E'.$x, getBarang($row['barang_id']));
            $sheet1->setCellValue('F'.$x, getOutlet3($row['user_id']));
            $sheet1->setCellValue('G'.$x, getUser($row['user_id']));
            $sheet1->setCellValue('H'.$x, getRolling($row['rolling']));
            $sheet1->setCellValue('I'.$x, $row['qty_pemakaian']);
            $sheet1->setCellValue('J'.$x, $barang['harga']);
            $sheet1->setCellValue('K'.$x, '=I'.$x.'*J'.$x);
            $sheet1->getStyle('J'.$x)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet1->getStyle('K'.$x)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet1->getStyle('A'.$x.':K'.$x)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet1->getStyle('A'.$x.':C'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet1->getStyle('D'.$x.':H'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet1->getStyle('I'.$x.':K'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            ++$x;
        }
        $sheet1->mergeCells('A'.$x.':J'.$x);
        $sheet1->setCellValue('A'.$x, 'Total Penjualan');
        $sheet1->setCellValue('K'.$x, '=SUM(K2:K'.($x - 1).')');
        $sheet1->getStyle('K'.$x)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
        $sheet1->getStyle('A'.$x.':J'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle('A'.$x.':K'.$x)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet1->getStyle('A'.$x.':K'.$x)->getFont()->setBold(true);

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Laporan Pengeluaran');

        $sheet2->setCellValue('A1', 'No');
        $sheet2->setCellValue('B1', 'No Bukti');
        $sheet2->setCellValue('C1', 'Tanggal');
        $sheet2->setCellValue('D1', 'Kode Biaya');
        $sheet2->setCellValue('E1', 'Keterangan');
        $sheet2->setCellValue('F1', 'Kode Outlet');
        $sheet2->setCellValue('G1', 'Sales');
        $sheet2->setCellValue('H1', 'Status Rolling');
        $sheet2->setCellValue('I1', 'Jumlah');
        $sheet2->setCellValue('J1', 'Nominal');

        $sheet2->getColumnDimension('A')->setWidth(5);
        $sheet2->getColumnDimension('B')->setWidth(20);
        $sheet2->getColumnDimension('C')->setWidth(12);
        $sheet2->getColumnDimension('D')->setWidth(12);
        $sheet2->getColumnDimension('E')->setWidth(30);
        $sheet2->getColumnDimension('F')->setWidth(12);
        $sheet2->getColumnDimension('G')->setWidth(15);
        $sheet2->getColumnDimension('H')->setWidth(15);
        $sheet2->getColumnDimension('I')->setWidth(10);
        $sheet2->getColumnDimension('J')->setWidth(20);

        $sheet2->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet2->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A1:J1')->getFont()->setBold(true);

        $this->db->order_by('tanggal');
        $pengeluaran = $this->db->get_where('lap_pengeluaran', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1])->result_array();
        $no1 = 1;
        $x1 = 2;
        foreach ($pengeluaran as $row) {
            $sheet2->setCellValue('A'.$x1, $no1++);
            $sheet2->setCellValue('B'.$x1, $row['no_bukti']);
            $sheet2->setCellValue('C'.$x1, $row['tanggal']);
            $biayak = $this->db->get_where('master_biaya', ['id_biaya' => $row['akun_id']])->row_array();
            $sheet2->setCellValue('D'.$x1, $biayak['kode_biaya']);
            $sheet2->setCellValue('E'.$x1, $row['keterangan']);
            $sheet2->setCellValue('F'.$x1, getOutlet3($row['user_id']));
            $sheet2->setCellValue('G'.$x1, getUser($row['user_id']));
            $sheet2->setCellValue('H'.$x1, getRolling($row['rolling']));
            $sheet2->setCellValue('I'.$x1, $row['jumlah']);
            $sheet2->setCellValue('J'.$x1, $row['nilai']);
            $sheet2->getStyle('J'.$x1)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet2->getStyle('A'.$x1.':J'.$x1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet2->getStyle('A'.$x1.':D'.$x1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('E'.$x1.':H'.$x1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet2->getStyle('I'.$x1.':J'.$x1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            ++$x1;
        }
        $sheet2->mergeCells('A'.$x1.':I'.$x1);
        $sheet2->setCellValue('A'.$x1, 'Total Pengeluaran');
        $sheet2->setCellValue('J'.$x1, '=SUM(J2:J'.($x1 - 1).')');
        $sheet2->getStyle('J'.$x1)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
        $sheet2->getStyle('A'.$x1.':I'.$x1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A'.$x1.':J'.$x1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet2->getStyle('A'.$x1.':J'.$x1)->getFont()->setBold(true);

        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Laporan Sales');

        $sheet3->setCellValue('A1', 'No');
        $sheet3->setCellValue('B1', 'No Bukti');
        $sheet3->setCellValue('C1', 'Tanggal');
        $sheet3->setCellValue('D1', 'Kode Outlet');
        $sheet3->setCellValue('E1', 'Sales');
        $sheet3->setCellValue('F1', 'Status Rolling');
        $sheet3->setCellValue('G1', 'Total Penjualan');
        $sheet3->setCellValue('H1', 'Total Pengeluaran');
        $sheet3->setCellValue('I1', 'Nominal');
        $sheet3->setCellValue('J1', 'Dapur');
        $sheet3->setCellValue('K1', 'Tanggal Terima');
        $sheet3->setCellValue('L1', 'Sisa Bubur');
        $sheet3->setCellValue('M1', 'Sisa Tim');
        $sheet3->setCellValue('N1', 'Catatan');
        $sheet3->setCellValue('O1', 'Jam Datang');

        $sheet3->getColumnDimension('A')->setWidth(5);
        $sheet3->getColumnDimension('B')->setWidth(20);
        $sheet3->getColumnDimension('C')->setWidth(12);
        $sheet3->getColumnDimension('D')->setWidth(12);
        $sheet3->getColumnDimension('E')->setWidth(15);
        $sheet3->getColumnDimension('F')->setWidth(15);
        $sheet3->getColumnDimension('G')->setWidth(20);
        $sheet3->getColumnDimension('H')->setWidth(20);
        $sheet3->getColumnDimension('I')->setWidth(20);
        $sheet3->getColumnDimension('J')->setWidth(15);
        $sheet3->getColumnDimension('K')->setWidth(15);
        $sheet3->getColumnDimension('L')->setWidth(15);
        $sheet3->getColumnDimension('M')->setWidth(15);
        $sheet3->getColumnDimension('N')->setWidth(50);
        $sheet3->getColumnDimension('O')->setWidth(15);

        $sheet3->getStyle('A1:O1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet3->getStyle('A1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet3->getStyle('A1:O1')->getFont()->setBold(true);

        $totalsales = $this->db->select('tanggal, tglserahterima, sisabubur, sisanasitim, catatan, jamdatang, user_id, dapur_id, no_bukti, rolling, SUM(total) as total_harga')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'dapur_id !=' => 0, 'status' => 1])->group_by(['tanggal', 'tglserahterima', 'rolling', 'jamdatang', 'user_id', 'dapur_id', 'no_bukti', 'catatan', 'sisabubur', 'sisanasitim'])->get()->result_array();
        $no2 = 1;
        $x2 = 2;
        foreach ($totalsales as $row) {
            $sheet3->setCellValue('A'.$x2, $no2++);
            $sheet3->setCellValue('B'.$x2, $row['no_bukti']);
            $sheet3->setCellValue('C'.$x2, $row['tanggal']);
            $sheet3->setCellValue('D'.$x2, getOutlet3($row['user_id']));
            $sheet3->setCellValue('E'.$x2, getUser($row['user_id']));
            $sheet3->setCellValue('F'.$x2, getRolling($row['rolling']));
            $sheet3->setCellValue('G'.$x2, $row['total_harga']);
            $sheet3->setCellValue('H'.$x2, getTotalPembiayaan($row['tanggal'], $row['user_id']));
            $sheet3->setCellValue('I'.$x2, '=G'.$x2.'-H'.$x2);
            $sheet3->setCellValue('J'.$x2, getUser($row['dapur_id']));
            $sheet3->setCellValue('K'.$x2, $row['tglserahterima']);
            $sheet3->setCellValue('L'.$x2, $row['sisabubur']);
            $sheet3->setCellValue('M'.$x2, $row['sisanasitim']);
            $sheet3->setCellValue('N'.$x2, $row['catatan']);
            $sheet3->setCellValue('O'.$x2, $row['jamdatang']);
            $sheet3->getStyle('G'.$x2.':I'.$x2)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet3->getStyle('A'.$x2.':O'.$x2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet3->getStyle('A'.$x2.':D'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet3->getStyle('K'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet3->getStyle('O'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet3->getStyle('E'.$x2.':F'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet3->getStyle('G'.$x2.':I'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            ++$x2;
        }
        $sheet3->mergeCells('A'.$x2.':H'.$x2);
        $sheet3->setCellValue('A'.$x2, 'Total Laporan Sales');
        $sheet3->setCellValue('I'.$x2, '=SUM(I2:I'.($x2 - 1).')');
        $sheet3->getStyle('I'.$x2)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
        $sheet3->getStyle('A'.$x2.':H'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet3->getStyle('A'.$x2.':I'.$x2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet3->getStyle('A'.$x2.':I'.$x2)->getFont()->setBold(true);

        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Lap Selisih Serah Terima Barang');

        $sheet4->setCellValue('A1', 'No');
        $sheet4->setCellValue('B1', 'No Bukti');
        $sheet4->setCellValue('C1', 'Tanggal Serah Terima');
        $sheet4->setCellValue('D1', 'Outlet');
        $sheet4->setCellValue('E1', 'Sales');
        $sheet4->setCellValue('F1', 'Dapur');
        $sheet4->setCellValue('G1', 'Barang');
        $sheet4->setCellValue('H1', 'Qty Akhir');
        $sheet4->setCellValue('I1', 'Qty Serah Terima');
        $sheet4->setCellValue('J1', 'Qty Selisih');
        $sheet4->setCellValue('K1', 'Qty Rusak');

        $sheet4->getColumnDimension('A')->setWidth(5);
        $sheet4->getColumnDimension('B')->setWidth(15);
        $sheet4->getColumnDimension('C')->setWidth(20);
        $sheet4->getColumnDimension('D')->setWidth(12);
        $sheet4->getColumnDimension('E')->setWidth(15);
        $sheet4->getColumnDimension('F')->setWidth(15);
        $sheet4->getColumnDimension('G')->setWidth(50);
        $sheet4->getColumnDimension('H')->setWidth(12);
        $sheet4->getColumnDimension('I')->setWidth(20);
        $sheet4->getColumnDimension('J')->setWidth(12);
        $sheet4->getColumnDimension('K')->setWidth(12);

        $sheet4->getStyle('A1:K1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet4->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet4->getStyle('A1:K1')->getFont()->setBold(true);

        $sediaan = $this->db->get_where('sediaan_laporan', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1, 'dapur_id !=' => 0])->result_array();
        $no2 = 1;
        $x2 = 2;
        foreach ($sediaan as $row) {
            $barangsediaan = $this->db->get_where('barang_sediaan', ['id' => $row['sediaan_id']])->row_array();
            $bs = $this->db->get_where('master_barang', ['id' => $barangsediaan['barang_id']])->row_array();
            $datajual = $this->db->select('tglserahterima, user_id, rolling, no_bukti')->from('sales_laporan')->where(['no_bukti' => $row['no_bukti']])->group_by(['tglserahterima', 'no_bukti', 'rolling', 'user_id'])->get()->row_array();
            if ($datajual['rolling'] == 0) {
                $namauser = $row['user_id'];
            } else {
                $namauser = $datajual['rolling'];
            }
            $qtyakhir = $row['qty_awal'] - $row['qty_pemakaian'];
            $qtyselisihb = $qtyakhir - $row['qty_cek'];
            if ($qtyselisihb != 0) {
                $sheet4->setCellValue('A'.$x2, $no2++);
                $sheet4->setCellValue('B'.$x2, $row['no_bukti']);
                $sheet4->setCellValue('C'.$x2, $datajual['tglserahterima']);
                $sheet4->setCellValue('D'.$x2, getOutlet3($row['user_id']));
                $sheet4->setCellValue('E'.$x2, getUser($namauser));
                $sheet4->setCellValue('F'.$x2, getUser($row['dapur_id']));
                $sheet4->setCellValue('G'.$x2, $bs['nama_barang']);
                $sheet4->setCellValue('H'.$x2, $qtyakhir);
                $sheet4->setCellValue('I'.$x2, $row['qty_cek']);
                $sheet4->setCellValue('J'.$x2, $qtyselisihb);
                $sheet4->setCellValue('K'.$x2, $row['qty_rusak']);
                $sheet4->getStyle('A'.$x2.':K'.$x2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet4->getStyle('A'.$x2.':D'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet4->getStyle('E'.$x2.':G'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet4->getStyle('H'.$x2.':K'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                ++$x2;
            }
        }

        $sheet5 = $spreadsheet->createSheet();
        $sheet5->setTitle('Lap Serah Terima');

        $sheet5->setCellValue('A1', 'No');
        $sheet5->setCellValue('B1', 'Tgl Serah Terima');
        $sheet5->setCellValue('C1', 'Outlet');
        $sheet5->setCellValue('D1', 'Jam Datang');
        $sheet5->setCellValue('E1', 'Bubur');
        $sheet5->setCellValue('F1', 'Nasi Tim');
        $sheet5->setCellValue('G1', 'Cup');
        $sheet5->setCellValue('H1', 'Puding');
        $sheet5->setCellValue('I1', 'Oatmeal');
        $sheet5->setCellValue('J1', 'Sayur');

        $sheet5->getColumnDimension('A')->setWidth(5);
        $sheet5->getColumnDimension('B')->setWidth(20);
        $sheet5->getColumnDimension('C')->setWidth(15);
        $sheet5->getColumnDimension('D')->setWidth(12);
        $sheet5->getColumnDimension('E')->setWidth(12);
        $sheet5->getColumnDimension('F')->setWidth(12);
        $sheet5->getColumnDimension('G')->setWidth(12);
        $sheet5->getColumnDimension('H')->setWidth(12);
        $sheet5->getColumnDimension('I')->setWidth(12);
        $sheet5->getColumnDimension('J')->setWidth(12);

        $sheet5->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet5->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet5->getStyle('A1:J1')->getFont()->setBold(true);

        $serta = $this->db->select('tanggal, tglserahterima, jamdatang, user_id, dapur_id, sisanasitim, sisabubur, no_bukti')->from('sales_laporan')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1, 'dapur_id !=' => 0])->group_by(['tanggal', 'tglserahterima', 'jamdatang', 'user_id', 'dapur_id', 'sisanasitim', 'sisabubur', 'no_bukti'])->get()->result_array();
        $no3 = 1;
        $x3 = 2;
        foreach ($serta as $row) {
            $sheet5->setCellValue('A'.$x3, $no3++);
            $sheet5->setCellValue('B'.$x3, $row['tglserahterima']);
            $sheet5->setCellValue('C'.$x3, getOutlet3($row['user_id']));
            $sheet5->setCellValue('D'.$x3, $row['jamdatang']);
            $sheet5->setCellValue('E'.$x3, $row['sisabubur']);
            $sheet5->setCellValue('F'.$x3, $row['sisanasitim']);
            $cupserta = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 1])->row_array();
            $sheet5->setCellValue('G'.$x3, $cupserta['qty_akhir'] - $cupserta['qty_selisih']);
            $cupserta1 = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 2])->row_array();
            $sheet5->setCellValue('H'.$x3, $cupserta1['qty_akhir'] - $cupserta1['qty_selisih']);
            $cupserta2 = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 3])->row_array();
            $sheet5->setCellValue('I'.$x3, $cupserta2['qty_akhir'] - $cupserta2['qty_selisih']);
            $cupserta3 = $this->db->get_where('sediaan_laporan', ['user_id' => $row['user_id'], 'no_bukti' => $row['no_bukti'], 'sediaan_id' => 4])->row_array();
            $sheet5->setCellValue('J'.$x3, $cupserta3['qty_akhir'] - $cupserta3['qty_selisih']);
            $sheet5->getStyle('A'.$x3.':J'.$x3)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet5->getStyle('A'.$x3.':B'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            ++$x3;
        }

        $sheet5->mergeCells('A'.$x3.':D'.$x3);
        $sheet5->setCellValue('A'.$x3, 'Total');
        $sheet5->setCellValue('E'.$x3, '=SUM(E2:E'.($x3 - 1).')');
        $sheet5->setCellValue('F'.$x3, '=SUM(F2:F'.($x3 - 1).')');
        $sheet5->setCellValue('G'.$x3, '=SUM(G2:G'.($x3 - 1).')');
        $sheet5->setCellValue('H'.$x3, '=SUM(H2:H'.($x3 - 1).')');
        $sheet5->setCellValue('I'.$x3, '=SUM(I2:I'.($x3 - 1).')');
        $sheet5->setCellValue('J'.$x3, '=SUM(J2:J'.($x3 - 1).')');
        $sheet5->getStyle('A'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet5->getStyle('A'.$x3.':J'.$x3)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet5->getStyle('A'.$x3.':J'.$x3)->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Sales'.Tglindo('-'.$bulan.'-').$tahun;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel1($bulan, $tahun)
    {
        $spreadsheet = new Spreadsheet();
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Laporan Pengeluaran Rutin');

        $sheet1->setCellValue('A1', 'No');
        $sheet1->setCellValue('B1', 'No Dok');
        $sheet1->setCellValue('C1', 'Tanggal');
        $sheet1->setCellValue('D1', 'Kode');
        $sheet1->setCellValue('E1', 'Nama');
        $sheet1->setCellValue('F1', 'Dapur');
        $sheet1->setCellValue('G1', 'Keterangan');
        $sheet1->setCellValue('H1', 'Status Rolling');
        $sheet1->setCellValue('I1', 'Jumlah');
        $sheet1->setCellValue('J1', 'Nominal');

        $sheet1->getColumnDimension('A')->setWidth(5);
        $sheet1->getColumnDimension('B')->setWidth(20);
        $sheet1->getColumnDimension('C')->setWidth(12);
        $sheet1->getColumnDimension('D')->setWidth(10);
        $sheet1->getColumnDimension('E')->setWidth(30);
        $sheet1->getColumnDimension('F')->setWidth(15);
        $sheet1->getColumnDimension('G')->setWidth(30);
        $sheet1->getColumnDimension('H')->setWidth(15);
        $sheet1->getColumnDimension('I')->setWidth(10);
        $sheet1->getColumnDimension('J')->setWidth(20);

        $sheet1->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet1->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle('A1:J1')->getFont()->setBold(true);

        $this->db->order_by('tanggal');
        $pr = $this->db->get_where('dapur_pengeluaran', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1, 'pengeluaran' => 1])->result_array();
        $no = 1;
        $x = 2;
        foreach ($pr as $row) {
            $sheet1->setCellValue('A'.$x, $no++);
            $sheet1->setCellValue('B'.$x, $row['no_dok']);
            $sheet1->setCellValue('C'.$x, $row['tanggal']);
            $akun = $this->db->get_where('master_biaya', ['id_biaya' => $row['biaya_id']])->row_array();
            $sheet1->setCellValue('D'.$x, $akun['kode_biaya']);
            $sheet1->setCellValue('E'.$x, $akun['nama_biaya']);
            $sheet1->setCellValue('F'.$x, getUser($row['user_id']));
            $sheet1->setCellValue('G'.$x, $row['keterangan']);
            $sheet1->setCellValue('H'.$x, getRolling($row['rolling']));
            $sheet1->setCellValue('I'.$x, $row['jumlah']);
            $sheet1->setCellValue('J'.$x, $row['nilai']);
            $sheet1->getStyle('J'.$x)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet1->getStyle('A'.$x.':J'.$x)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet1->getStyle('A'.$x.':D'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet1->getStyle('E'.$x.':H'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet1->getStyle('I'.$x.':J'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            ++$x;
        }
        $sheet1->mergeCells('A'.$x.':I'.$x);
        $sheet1->setCellValue('A'.$x, 'Total Pengeluaran Rutin');
        $sheet1->setCellValue('J'.$x, '=SUM(J2:J'.($x - 1).')');
        $sheet1->getStyle('J'.$x)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
        $sheet1->getStyle('A'.$x.':I'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle('A'.$x.':J'.$x)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet1->getStyle('A'.$x.':J'.$x)->getFont()->setBold(true);

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Laporan Pengeluaran Lain');

        $sheet2->setCellValue('A1', 'No');
        $sheet2->setCellValue('B1', 'No Dok');
        $sheet2->setCellValue('C1', 'Tanggal');
        $sheet2->setCellValue('D1', 'Kode');
        $sheet2->setCellValue('E1', 'Nama');
        $sheet2->setCellValue('F1', 'Dapur');
        $sheet2->setCellValue('G1', 'Keterangan');
        $sheet2->setCellValue('H1', 'Status Rolling');
        $sheet2->setCellValue('I1', 'Jumlah');
        $sheet2->setCellValue('J1', 'Nominal');

        $sheet2->getColumnDimension('A')->setWidth(5);
        $sheet2->getColumnDimension('B')->setWidth(20);
        $sheet2->getColumnDimension('C')->setWidth(12);
        $sheet2->getColumnDimension('D')->setWidth(10);
        $sheet2->getColumnDimension('E')->setWidth(30);
        $sheet2->getColumnDimension('F')->setWidth(15);
        $sheet2->getColumnDimension('G')->setWidth(30);
        $sheet2->getColumnDimension('H')->setWidth(15);
        $sheet2->getColumnDimension('I')->setWidth(10);
        $sheet2->getColumnDimension('J')->setWidth(20);

        $sheet2->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet2->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A1:J1')->getFont()->setBold(true);

        $this->db->order_by('tanggal');
        $pl = $this->db->get_where('dapur_pengeluaran', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1, 'pengeluaran' => 2])->result_array();
        $no2 = 1;
        $x2 = 2;
        foreach ($pl as $row) {
            $sheet2->setCellValue('A'.$x2, $no2++);
            $sheet2->setCellValue('B'.$x2, $row['no_dok']);
            $sheet2->setCellValue('C'.$x2, $row['tanggal']);
            $akun = $this->db->get_where('master_biaya', ['id_biaya' => $row['biaya_id']])->row_array();
            $sheet2->setCellValue('D'.$x2, $akun['kode_biaya']);
            $sheet2->setCellValue('E'.$x2, $akun['nama_biaya']);
            $sheet2->setCellValue('F'.$x2, getUser($row['user_id']));
            $sheet2->setCellValue('G'.$x2, $row['keterangan']);
            $sheet2->setCellValue('H'.$x2, getRolling($row['rolling']));
            $sheet2->setCellValue('I'.$x2, $row['jumlah']);
            $sheet2->setCellValue('J'.$x2, $row['nilai']);
            $sheet2->getStyle('J'.$x2)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet2->getStyle('A'.$x2.':J'.$x2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet2->getStyle('A'.$x2.':D'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('E'.$x2.':H'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet2->getStyle('I'.$x2.':J'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            ++$x2;
        }
        $sheet2->mergeCells('A'.$x2.':I'.$x2);
        $sheet2->setCellValue('A'.$x2, 'Total Pengeluaran Lain');
        $sheet2->setCellValue('J'.$x2, '=SUM(J2:J'.($x2 - 1).')');
        $sheet2->getStyle('J'.$x2)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
        $sheet2->getStyle('A'.$x2.':I'.$x2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A'.$x2.':J'.$x2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet2->getStyle('A'.$x2.':J'.$x2)->getFont()->setBold(true);

        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Laporan Pembelian Barang');

        $sheet3->setCellValue('A1', 'No');
        $sheet3->setCellValue('B1', 'No Dok');
        $sheet3->setCellValue('C1', 'Tanggal');
        $sheet3->setCellValue('D1', 'Kode');
        $sheet3->setCellValue('E1', 'Nama');
        $sheet3->setCellValue('F1', 'Dapur');
        $sheet3->setCellValue('G1', 'Status Rolling');
        $sheet3->setCellValue('H1', 'Satuan');
        $sheet3->setCellValue('I1', 'Qty');
        $sheet3->setCellValue('J1', 'Harga');
        $sheet3->setCellValue('K1', 'Nominal');

        $sheet3->getColumnDimension('A')->setWidth(5);
        $sheet3->getColumnDimension('B')->setWidth(20);
        $sheet3->getColumnDimension('C')->setWidth(12);
        $sheet3->getColumnDimension('D')->setWidth(10);
        $sheet3->getColumnDimension('E')->setWidth(30);
        $sheet3->getColumnDimension('F')->setWidth(15);
        $sheet3->getColumnDimension('G')->setWidth(15);
        $sheet3->getColumnDimension('H')->setWidth(10);
        $sheet3->getColumnDimension('I')->setWidth(10);
        $sheet3->getColumnDimension('J')->setWidth(15);
        $sheet3->getColumnDimension('K')->setWidth(20);

        $sheet3->getStyle('A1:K1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet3->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet3->getStyle('A1:K1')->getFont()->setBold(true);

        $this->db->order_by('tanggal');
        $pbb = $this->db->get_where('dapur_pembelian', ['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1])->result_array();
        $no3 = 1;
        $x3 = 2;
        foreach ($pbb as $row) {
            $sheet3->setCellValue('A'.$x3, $no3++);
            $sheet3->setCellValue('B'.$x3, $row['no_dok']);
            $sheet3->setCellValue('C'.$x3, $row['tanggal']);
            $brg = $this->db->get_where('master_barang', ['id' => $row['barang_id']])->row_array();
            $sheet3->setCellValue('D'.$x3, $brg['kode_barang']);
            $sheet3->setCellValue('E'.$x3, $brg['nama_barang']);
            $sheet3->setCellValue('F'.$x3, getUser($row['user_id']));
            $sheet3->setCellValue('G'.$x3, getRolling($row['rolling']));
            $sheet3->setCellValue('H'.$x3, $row['satuan']);
            $sheet3->setCellValue('I'.$x3, $row['qty']);
            $sheet3->setCellValue('J'.$x3, $row['harga']);
            $sheet3->setCellValue('K'.$x3, '=I'.$x3.'*J'.$x3);
            $sheet3->getStyle('J'.$x3)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet3->getStyle('K'.$x3)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet3->getStyle('A'.$x3.':K'.$x3)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet3->getStyle('A'.$x3.':D'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet3->getStyle('E'.$x3.':H'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet3->getStyle('I'.$x3.':K'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            ++$x3;
        }
        $sheet3->mergeCells('A'.$x3.':J'.$x3);
        $sheet3->setCellValue('A'.$x3, 'Total Pembelian Barang');
        $sheet3->setCellValue('K'.$x3, '=SUM(K2:K'.($x3 - 1).')');
        $sheet3->getStyle('K'.$x3)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
        $sheet3->getStyle('A'.$x3.':J'.$x3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet3->getStyle('A'.$x3.':K'.$x3)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet3->getStyle('A'.$x3.':K'.$x3)->getFont()->setBold(true);

        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Laporan Dapur');

        $sheet4->setCellValue('A1', 'No');
        $sheet4->setCellValue('B1', 'No Dok');
        $sheet4->setCellValue('C1', 'Tanggal');
        $sheet4->setCellValue('D1', 'Dapur');
        $sheet4->setCellValue('E1', 'Status Rolling');
        $sheet4->setCellValue('F1', 'Total Pengeluaran');
        $sheet4->setCellValue('G1', 'Total Pembelian');
        $sheet4->setCellValue('H1', 'Nominal');

        $sheet4->getColumnDimension('A')->setWidth(5);
        $sheet4->getColumnDimension('B')->setWidth(20);
        $sheet4->getColumnDimension('C')->setWidth(12);
        $sheet4->getColumnDimension('D')->setWidth(15);
        $sheet4->getColumnDimension('E')->setWidth(15);
        $sheet4->getColumnDimension('F')->setWidth(20);
        $sheet4->getColumnDimension('G')->setWidth(20);
        $sheet4->getColumnDimension('H')->setWidth(20);

        $sheet4->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet4->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet4->getStyle('A1:H1')->getFont()->setBold(true);

        $totalsales = $this->db->select('tanggal, rolling,  no_dok, user_id, SUM(nilai) as total_nilai')->from('dapur_pengeluaran')->where(['MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun, 'status' => 1])->order_by('tanggal')->group_by('user_id')->group_by('no_dok')->group_by('tanggal')->group_by('rolling')->get()->result_array();
        $no4 = 1;
        $x4 = 2;
        foreach ($totalsales as $row) {
            $sheet4->setCellValue('A'.$x4, $no4++);
            $sheet4->setCellValue('B'.$x4, $row['no_dok']);
            $sheet4->setCellValue('C'.$x4, $row['tanggal']);
            $sheet4->setCellValue('D'.$x4, getUser($row['user_id']));
            $sheet4->setCellValue('E'.$x4, getRolling($row['rolling']));
            $sheet4->setCellValue('F'.$x4, $row['total_nilai']);
            $sheet4->setCellValue('G'.$x4, getTotalPembelian($row['no_dok']));
            $sheet4->setCellValue('H'.$x4, '=F'.$x4.'+G'.$x4);
            $sheet4->getStyle('F'.$x4.':H'.$x4)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
            $sheet4->getStyle('A'.$x4.':H'.$x4)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet4->getStyle('A'.$x4.':C'.$x4)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet4->getStyle('D'.$x4.':E'.$x4)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet4->getStyle('F'.$x4.':H'.$x4)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            ++$x4;
        }
        $sheet4->mergeCells('A'.$x4.':G'.$x4);
        $sheet4->setCellValue('A'.$x4, 'Total Laporan Dapur');
        $sheet4->setCellValue('H'.$x4, '=SUM(H2:H'.($x4 - 1).')');
        $sheet4->getStyle('H'.$x4)->getNumberFormat()->setFormatCode('[$Rp. ]#,##0.00');
        $sheet4->getStyle('A'.$x4.':F'.$x4)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet4->getStyle('A'.$x4.':H'.$x4)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet4->getStyle('A'.$x4.':H'.$x4)->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Dapur'.Tglindo('-'.$bulan.'-').$tahun;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function hapus($no_dok)
    {
        $this->db->delete('dapur_pengeluaran', ['no_dok' => $no_dok]);
        $this->db->delete('dapur_pembelian', ['no_dok' => $no_dok]);
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Dapur Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/dashboard');
    }

    public function hapus2($no_bukti)
    {
        $this->db->delete('sales_laporan', ['no_bukti' => $no_bukti]);
        $this->db->delete('sediaan_laporan', ['no_bukti' => $no_bukti]);
        $this->db->delete('lap_pengeluaran', ['no_bukti' => $no_bukti]);
        $this->session->set_flashdata('pesan', '
		<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
			<div class="text-white">Berhasil Menghapus Data Dapur Menu</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('admin/dashboard');
    }
}
