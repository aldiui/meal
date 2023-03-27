<?php  
function layout($path, $data){
    $ci = get_instance();
    $ci->load->view('templates/header', $data);
    $ci->load->view('templates/sidebar');
    $ci->load->view('templates/topbar', $data);
    $ci->load->view($path, $data);
    $ci->load->view('templates/footer', $data);
}

function dashboardsales($path, $data){
    $ci = get_instance();
    $ci->load->view('templates/header', $data);
    $ci->load->view('templates/sidebar1');
    $ci->load->view('templates/topbar', $data);
    $ci->load->view($path, $data);
    $ci->load->view('templates/footersales', $data);
}

function dashboardadmin($path, $data){
    $ci = get_instance();
    $ci->load->view('templates/header', $data);
    $ci->load->view('templates/sidebar');
    $ci->load->view('templates/topbar', $data);
    $ci->load->view($path, $data);
    $ci->load->view('templates/footeradmin', $data);
}

function layout1($path, $data){
    $ci = get_instance();
    $ci->load->view('templates/header', $data);
    $ci->load->view('templates/sidebar1');
    $ci->load->view('templates/topbar', $data);
    $ci->load->view($path, $data);
    $ci->load->view('templates/footer', $data);
}

function layout2($path, $data){
    $ci = get_instance();
    $ci->load->view('templates/header', $data);
    $ci->load->view('templates/sidebar2');
    $ci->load->view('templates/topbar', $data);
    $ci->load->view($path, $data);
    $ci->load->view('templates/footer', $data);
}

function getOutlet2($id){
    $ci = get_instance();
    $user = $ci->db->get_where("master_user", ["id" => $id])->row_array();
    $outlet = $ci->db->get_where("master_outlet", ["id" => $user["outlet_id"]])->row_array();
    return $outlet["nama_outlet"];
}

function getOutlet3($id){
    $ci = get_instance();
    $user = $ci->db->get_where("master_user", ["id" => $id])->row_array();
    $outlet = $ci->db->get_where("master_outlet", ["id" => $user["outlet_id"]])->row_array();
    return $outlet["kode_outlet"];
}

function getTotalPembiayaan($tanggal, $id){
    $ci = get_instance();
    $totalPembiayaan = $ci->db->select_sum('nilai')->where(['tanggal' => $tanggal ,'user_id' => $id ])->get('lap_pengeluaran')->row()->nilai;
    return $totalPembiayaan;
}

function getTotalPembelian($no_dok){
    $ci = get_instance();
    $cek_pb = $ci->db->get_where("dapur_pembelian", ["no_dok" => $no_dok])->num_rows();
    if($cek_pb == 0){
        $totalPembelian = 0;
    } else {
        $totalPembelian = $ci->db->select_sum('nilai')->where(["no_dok" => $no_dok])->get('dapur_pembelian')->row()->nilai;
    }
    return $totalPembelian;
}

function getOutlet($id){
    $ci = get_instance();
    if($id == 0){
        return "-";
    } else {      
        $outlet = $ci->db->get_where("master_outlet", ["id" => $id])->row_array();
        return $outlet["nama_outlet"];
    }
}

function getUser($id){
    $ci = get_instance();
    $user = $ci->db->get_where("master_user", ["id" => $id])->row_array();
    return $user["nama"];
}

function getRolling($id){
    $ci = get_instance();
    if($id == 0){
        return "-";
    } else {
        $user = $ci->db->get_where("master_user", ["id" => $id])->row_array();
        return $user["nama"];
    }
}

function getAkun($id){
    $ci = get_instance();
    $akun = $ci->db->get_where("master_akuntansi", ["id" => $id])->row_array();
    return $akun["nama_akun"];
}

function getKodeAkun($id){
    $ci = get_instance();
    $akun = $ci->db->get_where("master_akuntansi", ["id" => $id])->row_array();
    return $akun["kode_akun"];
}

function getKategori($id){
    $ci = get_instance();
    $kategori = $ci->db->get_where("master_kategori", ["id" => $id])->row_array();
    return $kategori["nama_kategori"];
}

function getBarang($id){
    $ci = get_instance();
    $barang = $ci->db->get_where("master_barang", ["id" => $id])->row_array();
    return $barang["nama_barang"];
}

function getTotalPemakaian($tanggal, $user, $sediaan_id){
    $ci = get_instance();
    $barang = $ci->db->select_sum('qty_pemakaian')->where(["tanggal" => $tanggal, "user_id" => $user, "sediaan_id" => $sediaan_id ])->get('sales_laporan')->row()->qty_pemakaian;
    return $barang;
}

function Uang($uang){
    return "Rp " . number_format( $uang, 2, ",", ".");
}

function TglIndo($string){
    $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];

    $tanggal = explode("-", $string)[2];
    $bulan = explode("-", $string)[1];
    $tahun = explode("-", $string)[0];
    return $tanggal . " " . $bulanIndo[abs($bulan)] . " " . $tahun;
}

function generate_no_bukti($string, $id){
    $ci = get_instance();
    $user = $ci->db->get_where("master_user", ["id" => $id])->row_array();
    $outlet = $ci->db->get_where("master_outlet", ["id" => $user["outlet_id"]])->row_array();
    $tanggal = explode("-", $string)[2];
    $bulan = explode("-", $string)[1];
    $tahun1= strval(explode("-", $string)[0]);
    $tahun = substr($tahun1, -2);
    $id_user = str_pad($id, 2, "0", STR_PAD_LEFT);  
    $no_bukti =  $outlet["kode_outlet"]. $tahun. $bulan ."-" . $tanggal;
    return $no_bukti;
}

function generate_no_dok($string, $id, $trx){
    $tanggal = explode("-", $string)[2];
    $bulan = explode("-", $string)[1];
    $tahun1= strval(explode("-", $string)[0]);
    $tahun = substr($tahun1, -2);
    $id_user = str_pad($id, 2, "0", STR_PAD_LEFT);  
    $transaksi = str_pad($trx, 2, "0", STR_PAD_LEFT);  
    $no_bukti = "KDPR". $tahun. $bulan . $tanggal ."-". $id_user.$transaksi;
    return $no_bukti;
}