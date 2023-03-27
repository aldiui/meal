<style>
    input[type=number] {
        text-align: right;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url("dapur/dashboard");?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title;?></li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
        <?= $this->session->flashdata('pesan'); ?>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Cek Data Dapur
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input class="form-control" type="text" value="<?= @$date ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="dapr" class="form-label">Dapur</label>
                                    <input class="form-control" type="text" value="<?= $username["username"] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <form action="<?= base_url("admin/dapur_menu/edit_data/").$date."/".$username["id"] ;?>" method="post">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div>Pengeluaran Rutin</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th width="10%">Kode</th>
                                    <th width="25%">Nama</th>
                                    <th>Keterangan</th>
                                    <th width="20%">Jumlah</th>
                                    <th width="20%">Nilai</th>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($biaya_rutin as $br):
                                    $br2 = $this->db->get_where("master_akuntansi", ["id" => $br["akun_id"]])->row_array();
                                    ?>
                                    <tr>
                                        <td><?= $br2["kode_akun"];?></td>
                                        <td><?= $br2["nama_akun"];?></td>
                                        <td width="25%">
                                            <input type="hidden" class="form-control" name="akun_br[]" readonly value="<?= $br["akun_id"];?>">
                                            <input type="text" class="form-control" name="ket_br[]" value="<?= $br["keterangan"];?>">
                                        </td>
                                        <td width="20%"><input type="number" class="form-control" name="jumlah_br[]" value="<?= $br["jumlah"];?>"></td>
                                        <td width="20%"><input type="number" class="form-control grandbr" oninput="HitungTotalBr()" name="nilai_br[]" value="<?= $br["nilai"];?>"></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total Pengeluaran Rutin</th>
                                        <th>
                                            <div id="grandbr" class="text-end"><?= Uang($total_br);?></div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div>Pengeluaran Lain Lain</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">Kode</th>
                                        <th width="25%">Nama</th>
                                        <th>Keterangan</th>
                                        <th width="20%">Jumlah</th>
                                        <th width="20%">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($biaya_lain as $bl):
                                    $bl2 = $this->db->get_where("master_akuntansi", ["id" => $bl["akun_id"]])->row_array();
                                    ?>
                                    <tr>
                                        <td><?= $bl2["kode_akun"];?></td>
                                        <td><?= $bl2["nama_akun"];?></td>
                                        <td width="25%">
                                            <input type="hidden" class="form-control" name="akun_bl[]" readonly value="<?= $bl["akun_id"];?>">
                                            <input type="text" class="form-control" name="ket_bl[]" value="<?= $bl["keterangan"];?>">
                                        </td>
                                        <td width="20%"><input type="number" class="form-control" name="jumlah_bl[]" value="<?= $bl["jumlah"];?>"></td>
                                        <td width="20%"><input type="number" class="form-control grandbl" oninput="HitungTotalBl()" name="nilai_bl[]" value="<?= $bl["nilai"];?>"></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total Pengeluaran Lain Lain</th>
                                        <th><div id="grandbl" class="text-end"><?= Uang($total_bl);?></div></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div>Pembelian Barang</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">Kode</th>
                                        <th width="30%">Nama</th>
                                        <th width="10%">Satuan</th>
                                        <th width="10%">Qty</th>
                                        <th width="20%">Harga</th>
                                        <th width="20%">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($pembelian as $pb):
                                    $pb2 = $this->db->get_where("master_barang", ["id" => $pb["barang_id"]])->row_array();
                                    ?>
                                    <tr>
                                        <td><?= $pb2["kode_barang"];?></td>
                                        <td><?= $pb2["nama_barang"];?></td>
                                        <td>
                                            <select name="satuan[]" class="form-control input_pb<?= $pb['barang_id']; ?>">
                                                <option <?php if($pb["satuan"] == $pb2["satuan_utama"]){ echo "selected"; };?> value="<?= $pb2["satuan_utama"];?>"><?= $pb2["satuan_utama"];?></option>
                                                <?php if($pb2["satuan_kedua"] != ""):?>
                                                    <option <?php if($pb["satuan"] == $pb2["satuan_kedua"]){ echo "selected"; };?> value="<?= $pb2["satuan_kedua"];?>"><?= $pb2["satuan_kedua"];?></option>
                                                <?php endif;?>
                                                <?php if($pb2["satuan_ketiga"] != ""):?>
                                                    <option <?php if($pb["satuan"] == $pb2["satuan_ketiga"]){ echo "selected"; };?> value="<?= $pb2["satuan_ketiga"];?>"><?= $pb2["satuan_ketiga"];?></option>
                                                <?php endif;?>
                                                <?php if($pb2["satuan_keempat"] != ""):?>
                                                    <option <?php if($pb["satuan"] == $pb2["satuan_keempat"]){ echo "selected"; };?> value="<?= $pb2["satuan_keempat"];?>"><?= $pb2["satuan_keempat"];?></option>
                                                <?php endif;?>
                                                <?php if($pb2["satuan_kelima"] != ""):?>
                                                    <option <?php if($pb["satuan"] == $pb2["satuan_kelima"]){ echo "selected"; };?> value="<?= $pb2["satuan_kelima"];?>"><?= $pb2["satuan_kelima"];?></option>
                                                <?php endif;?>
                                            </select>
                                        </td>
                                        <td >
                                            <input type="number" class="form-control input_pb<?= $pb['barang_id']; ?>" id="qty<?= $pb['barang_id']; ?>" oninput="hargaPb(<?= $pb['barang_id'];?>)" name="qty[]" value="<?= $pb["qty"];?>">
                                        </td>
                                        <td class="text-end">
                                            <div id="hrg<?= $pb['barang_id']; ?>"><?= Uang($pb["harga"]);?></div>
                                            <input type="hidden" class="form-control" name="barang_bp[]" readonly value="<?= $pb["barang_id"];?>">
                                            <input type="hidden" class="form-control" name="harga[]" value="<?= $pb["harga"];?>" id="harga<?= $pb["barang_id"];?>">
                                        </td>
                                        <td><input type="number" class="form-control input_pb<?= $pb['barang_id']; ?> grandpb" id="nilai<?= $pb['barang_id']; ?>" oninput="HitungTotalPb(); hargaPb(<?= $pb['barang_id'];?>)" value="<?= $pb["nilai"];?>" name="nilai[]"></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total Pembelian Barang</th>
                                        <th class="text-end" id="grandpb"><?= Uang($total_pb);?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Edit</button>
                </div>
            </div>
            <script>
                function hargaPb(value){
                    const nilai = $(`#nilai${value}`).val();
                    const qty = $(`#qty${value}`).val();
                    const harga = nilai / qty;
                    $(`#harga${value}`).val(harga);
                    $(`#hrg${value}`).text(FormatRupiah(harga));
                }

                function HitungTotalBr() {
                    var totalPengeluaranBr = 0;
                    var pengeluaranBrElements = $('.grandbr');
                    pengeluaranBrElements.each(function(){
                        if($(this).val() !='' && $(this).val() != null){
                            totalPengeluaranBr += parseInt($(this).val());
                        }
                    });
                    $('#grandbr').text(FormatRupiah(totalPengeluaranBr));
                }

                function HitungTotalBl() {
                    var totalPengeluaranBl = 0;
                    var pengeluaranBlElements = $('.grandbl');
                    pengeluaranBlElements.each(function(){
                        if($(this).val() !='' && $(this).val() != null){
                            totalPengeluaranBl += parseInt($(this).val());
                        }
                    });
                    $('#grandbl').text(FormatRupiah(totalPengeluaranBl));
                }

                function HitungTotalPb() {
                    var totalPengeluaranBl = 0;
                    var pengeluaranBlElements = $('.grandpb');
                    pengeluaranBlElements.each(function(){
                        if($(this).val() !='' && $(this).val() != null){
                            totalPengeluaranBl += parseInt($(this).val());
                        }
                    });
                    $('#grandpb').text(FormatRupiah(totalPengeluaranBl));
                }

            </script>
        </form>
    </div>
</div>