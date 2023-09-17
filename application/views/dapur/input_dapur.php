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
                        <a href="<?php echo base_url('dapur/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
            <?php echo $this->session->flashdata('pesan'); ?>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <?php echo $title; ?> Dapur
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <form action="<?php echo base_url('dapur/dapur_menu/rolling_dapur'); ?>" method="get">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-2">
                                        <label for="date" class="form-label">Tanggal</label>
                                        <input class="result form-control" type="text" value="<?php echo @$date; ?>" id="date"
                                            placeholder="Tanggal..." name="tanggal"
                                            <?php if ($olah != 'kosong') {
                                                echo 'readonly';
                                            } ?>>
                                        <input type="hidden" value="<?php echo $username['id']; ?>" name="id">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-2">
                                        <label for="trx" class="form-label">Transaksi</label>
                                        <input class="form-control" type="number" id="trx" style="text-align: left"
                                            value="<?php if ($olah != 'kosong') {
                                                echo $trx;
                                            } ?>" name="trx" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-2">
                                        <label for="dpr" class="form-label">Dapur</label>
                                        <input class="form-control" type="text" value="<?php echo $username['username']; ?>"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <?php if ($olah == 'kosong') { ?>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Mulai</button>
                            </div>
                            <?php }?>
                        </form>
                    </div>
                </div>
            </div>
            <?php if ($olah == 'input') { ?>
            <form action="<?php echo base_url('dapur/dapur_menu/tambah_dp/').@$date.'/'.$username['id'].'/'.$trx; ?>"
                method="post">
                <input type="hidden" name="no_dok" value="<?php echo $no_dok; ?>">
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
                                        foreach ($biaya_rutin as $br) { ?>
                                        <tr>
                                            <td><?php echo $br['kode_biaya']; ?></td>
                                            <td><?php echo $br['nama_biaya']; ?></td>
                                            <td width="25%">
                                                <input type="hidden" class="form-control" name="biaya_br[]" readonly
                                                    value="<?php echo $br['id_biaya']; ?>">
                                                <input type="text" class="form-control" name="ket_br[]">
                                            </td>
                                            <td width="20%"><input type="number" class="form-control"
                                                    name="jumlah_br[]">
                                            </td>
                                            <td width="20%"><input type="number" class="form-control grandbr"
                                                    oninput="HitungTotalBr()" name="nilai_br[]"></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total Pengeluaran Rutin</th>
                                            <th>
                                                <div id="grandbr" class="text-end">Rp. 0,00</div>
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
                                <div class="d-flex justify-content-between">
                                    <div class="mt-1">Pengeluaran Lain Lain</div>
                                    <div>
                                        <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#tambahbl">Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table pb-0 mb-0  table-bordered" style="width: 100%;">
                                    <thead style="border-bottom: 2px solid #000">
                                        <tr>
                                            <th width="10%">Kode</th>
                                            <th width="25%">Nama</th>
                                            <th width="25%">Keterangan</th>
                                            <th width="20%">Jumlah</th>
                                            <th width="20%">Nilai</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered table-striped my-0 pt-0 w-100" style="width: 100%;">
                                    <tbody style="width: 100%;">
                                        <?php
                                        foreach ($biaya_lain as $bl) { ?>
                                        <tr class="d-none w-100" id="trbl<?php echo $bl['id_biaya']; ?>" style="width: 100%;">
                                            <td width="10%">
                                                <span class="d-none"><input type="checkbox"
                                                        id="cb_bl<?php echo $bl['id_biaya']; ?>" name="biaya_bl[]"
                                                        value="<?php echo $bl['id_biaya']; ?>"></span>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hpsbl(<?php echo $bl['id_biaya']; ?>)"><i
                                                        class="bx bx-trash"></i></button>
                                                <?php echo $bl['kode_biaya']; ?>
                                            </td>
                                            <td width="25%"><?php echo $bl['nama_biaya']; ?></td>
                                            <td width="25%">
                                                <input type="text" class="form-control input_bl<?php echo $bl['id_biaya']; ?>"
                                                    name="ket_bl<?php echo $bl['id_biaya']; ?>">
                                            </td>
                                            <td width="20%"><input type="number"
                                                    class="form-control input_bl<?php echo $bl['id_biaya']; ?>"
                                                    name="jumlah_bl<?php echo $bl['id_biaya']; ?>"></td>
                                            <td width="20%"><input type="number"
                                                    class="form-control input_bl<?php echo $bl['id_biaya']; ?> grandbl"
                                                    oninput="HitungTotalBl()" name="nilai_bl<?php echo $bl['id_biaya']; ?>">
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" style="width: 100%;">
                                    <tfoot style="border-top: 2px solid #000">
                                        <tr>
                                            <th width="80%" colspan="4">Total Pengeluaran Lain Lain</th>
                                            <th width="20%">
                                                <div id="grandbl" class="text-end">Rp. 0,00</div>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="tambahbl" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th>Pilih</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($biaya_lain as $bl) { ?>
                                            <tr>
                                                <td style="width: 10%"><input type="checkbox" class="form-check-input"
                                                        id="tbbl<?php echo $bl['id_biaya']; ?>"
                                                        onclick="tambahbl(<?php echo $bl['id_biaya']; ?>)"></td>
                                                <td><?php echo $bl['kode_biaya']; ?></td>
                                                <td><?php echo $bl['nama_biaya']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="d-flex justify-content-between">
                                    <div class="mt-1">Pembelian Barang</div>
                                    <div>
                                        <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#tambahpb">Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table pb-0 mb-0  table-bordered" style="width: 100%;">
                                    <thead style="border-bottom: 2px solid #000">
                                        <tr>
                                            <th width="10%">Kode</th>
                                            <th width="30%">Nama</th>
                                            <th width="10%">Satuan</th>
                                            <th width="10%">Qty</th>
                                            <th width="20%">Harga</th>
                                            <th width="20%">Nilai</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered table-striped my-0 pt-0 w-100" style="width: 100%;">
                                    <tbody>
                                    <tbody>
                                        <?php
                                            foreach ($pembelian as $pb) { ?>
                                        <tr class="d-none w-100" id="trpb<?php echo $pb['id']; ?>" style="width: 100%;">
                                            <td width="10%">
                                                <span class="d-none"><input type="checkbox" class="form-check-input "
                                                        id="cb_pb<?php echo $pb['id']; ?>" name="barang_bp[]"
                                                        value="<?php echo $pb['id']; ?>"></span>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hpspb(<?php echo $pb['id']; ?>)"><i
                                                        class="bx bx-trash"></i></button>
                                                <?php echo $pb['kode_barang']; ?>
                                            </td>
                                            <td width="30%"><?php echo $pb['nama_barang']; ?></td>
                                            <td width="10%">
                                                <select name="satuan<?php echo $pb['id']; ?>"
                                                    class="form-control input_pb<?php echo $pb['id']; ?>">
                                                    <option value="<?php echo $pb['satuan_utama']; ?>">
                                                        <?php echo $pb['satuan_utama']; ?>
                                                    </option>
                                                    <?php if ($pb['satuan_kedua'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_kedua']; ?>">
                                                        <?php echo $pb['satuan_kedua']; ?>
                                                    </option>
                                                    <?php }?>
                                                    <?php if ($pb['satuan_ketiga'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_ketiga']; ?>">
                                                        <?php echo $pb['satuan_ketiga']; ?>
                                                    </option>
                                                    <?php }?>
                                                    <?php if ($pb['satuan_keempat'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_keempat']; ?>">
                                                        <?php echo $pb['satuan_keempat']; ?></option>
                                                    <?php }?>
                                                    <?php if ($pb['satuan_kelima'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_kelima']; ?>">
                                                        <?php echo $pb['satuan_kelima']; ?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td width="10%">
                                                <input type="number" class="form-control input_pb<?php echo $pb['id']; ?>"
                                                    id="qty<?php echo $pb['id']; ?>" oninput="hargaPb(<?php echo $pb['id']; ?>)"
                                                    name="qty<?php echo $pb['id']; ?>">
                                            </td>
                                            <td width="20%" class="text-end">
                                                <div id="hrg<?php echo $pb['id']; ?>">Rp. 0,00</div>
                                                <input type="hidden" class="form-control" name="harga<?php echo $pb['id']; ?>"
                                                    id="harga<?php echo $pb['id']; ?>">
                                            </td>
                                            <td width="20%"><input type="number"
                                                    class="form-control input_pb<?php echo $pb['id']; ?> grandpb"
                                                    id="nilai<?php echo $pb['id']; ?>"
                                                    oninput="HitungTotalPb(); hargaPb(<?php echo $pb['id']; ?>)"
                                                    name="nilai<?php echo $pb['id']; ?>"></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" style="width: 100%;">
                                    <tfoot style="border-top: 2px solid #000">
                                        <tr>
                                            <th colspan="5">Total Pembelian Barang</th>
                                            <th width="20%" class="text-end" id="grandpb">Rp. 0,00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="tambahpb" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped" id="example4">
                                        <thead>
                                            <tr>
                                                <th>Pilih</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($pembelian as $pb) { ?>
                                            <tr>
                                                <td style="width: 10%"><input type="checkbox" class="form-check-input"
                                                        id="tbpb<?php echo $pb['id']; ?>" onclick="tambahpb(<?php echo $pb['id']; ?>)">
                                                </td>
                                                <td style="width: 20%"><?php echo $pb['kode_barang']; ?></td>
                                                <td><?php echo $pb['nama_barang']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-resposive">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Total Pengeluaran Rutin</td>
                                            <input type="hidden" value="0" id="grandbr1">
                                            <td width="20%" class="text-end" id="grandbr2">Rp. 0,00</td>
                                        </tr>
                                        <tr>
                                            <td>Total Pengeluaran Lain Lain</td>
                                            <input type="hidden" value="0" id="grandbl1">
                                            <td width="20%" class="text-end" id="grandbl2">Rp. 0,00</td>
                                        </tr>
                                        <tr>
                                            <td>Total Pembelian Barang</td>
                                            <input type="hidden" value="0" id="grandpb1">
                                            <td width="20%" class="text-end" id="grandpb2">Rp. 0,00</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Grand Total Pengeluran Dapur</th>
                                            <th width="20%" class="text-end" id="maxpengeluaran">Rp. 0,00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" id="inputtotal">Submit</button>
                    </div>
                </div>
                <script>
                function tambahbl(value) {
                    const checkbox = $(`input#tbbl${value}`);
                    const checkbox2 = $(`input#cb_bl${value}`);
                    const tr = $(`#trbl${value}`);
                    if (checkbox.prop("checked")) {
                        checkbox2.prop("checked", true);
                        tr.addClass("d-block").removeClass("d-none");
                    } else {
                        checkbox2.prop("checked", false);
                        tr.addClass("d-none").removeClass("d-block");
                    }
                }

                function tambahpb(value) {
                    const checkbox = $(`input#tbpb${value}`);
                    const checkbox2 = $(`input#cb_pb${value}`);
                    const tr = $(`#trpb${value}`);
                    if (checkbox.prop("checked")) {
                        checkbox2.prop("checked", true);
                        tr.addClass("d-block").removeClass("d-none");
                    } else {
                        checkbox2.prop("checked", false);
                        tr.addClass("d-none").removeClass("d-block");
                    }
                }

                function hpsbl(value) {
                    const checkbox = $(`input#tbbl${value}`);
                    const checkbox2 = $(`input#cb_bl${value}`);
                    const tr = $(`#trbl${value}`);
                    checkbox.prop("checked", false);
                    checkbox2.prop("checked", false);
                    tr.addClass("d-none").removeClass("d-block");
                }

                function hpspb(value) {
                    const checkbox = $(`input#tbpb${value}`);
                    const checkbox2 = $(`input#cb_pb${value}`);
                    const tr = $(`#trpb${value}`);
                    checkbox.prop("checked", false);
                    checkbox2.prop("checked", false);
                    tr.addClass("d-none").removeClass("d-block");
                }

                function hargaPb(value) {
                    const nilai = $(`#nilai${value}`).val();
                    const qty = $(`#qty${value}`).val();
                    const harga = nilai / qty;
                    $(`#harga${value}`).val(harga);
                    $(`#hrg${value}`).text(FormatRupiah(harga));
                }


                function HitungTotalBr() {
                    var totalPengeluaranBr = 0;
                    var pengeluaranBrElements = $('.grandbr');
                    pengeluaranBrElements.each(function() {
                        if ($(this).val() != '' && $(this).val() != null) {
                            totalPengeluaranBr += parseInt($(this).val());
                        }
                    });
                    $('#grandbr').text(FormatRupiah(totalPengeluaranBr));
                    $('#grandbr1').val(totalPengeluaranBr);
                    $('#grandbr2').text(FormatRupiah(totalPengeluaranBr));
                    var a = parseInt($('#grandbl1').val());
                    var b = parseInt($('#grandpb1').val());
                    var total = a + b + totalPengeluaranBr;
                    $('#maxpengeluaran').text(FormatRupiah(total));
                    if (total > 0) {
                        $("#inputtotal").attr("type", "submit");
                    } else {
                        $("#inputtotal").attr("type", "button");
                    }
                }

                function HitungTotalBl() {
                    var totalPengeluaranBl = 0;
                    var pengeluaranBlElements = $('.grandbl');
                    pengeluaranBlElements.each(function() {
                        if ($(this).val() != '' && $(this).val() != null) {
                            totalPengeluaranBl += parseInt($(this).val());
                        }
                    });
                    $('#grandbl').text(FormatRupiah(totalPengeluaranBl));
                    $('#grandbl1').val(totalPengeluaranBl);
                    $('#grandbl2').text(FormatRupiah(totalPengeluaranBl));
                    var a = parseInt($('#grandbr1').val());
                    var b = parseInt($('#grandpb1').val());
                    var total = a + b + totalPengeluaranBl;
                    $('#maxpengeluaran').text(FormatRupiah(total));
                    if (total > 0) {
                        $("#inputtotal").attr("type", "submit");
                    } else {
                        $("#inputtotal").attr("type", "button");
                    }
                }

                function HitungTotalPb() {
                    var totalPengeluaranBl = 0;
                    var pengeluaranBlElements = $('.grandpb');
                    pengeluaranBlElements.each(function() {
                        if ($(this).val() != '' && $(this).val() != null) {
                            totalPengeluaranBl += parseInt($(this).val());
                        }
                    });
                    $('#grandpb').text(FormatRupiah(totalPengeluaranBl));
                    $('#grandpb1').val(totalPengeluaranBl);
                    $('#grandpb2').text(FormatRupiah(totalPengeluaranBl));
                    var a = parseInt($('#grandbr1').val());
                    var b = parseInt($('#grandbl1').val());
                    var total = a + b + totalPengeluaranBl;
                    $('#maxpengeluaran').text(FormatRupiah(total));
                    if (total > 0) {
                        $("#inputtotal").attr("type", "submit");
                    } else {
                        $("#inputtotal").attr("type", "button");
                    }
                }
                </script>
            </form>
            <?php } elseif ($olah == 'edit') { ?>
            <form action="<?php echo base_url('dapur/dapur_menu/edit_dp/').@$date.'/'.$username['id'].'/'.$trx; ?>"
                method="post">
                <input type="hidden" name="no_dok" value="<?php echo $no_dok; ?>">
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
                                        foreach ($biaya_rutin as $br) {
                                            $br2 = $this->db->get_where('master_biaya', ['id_biaya' => $br['biaya_id']])->row_array();
                                            ?>
                                        <tr>
                                            <td><?php echo $br2['kode_biaya']; ?></td>
                                            <td><?php echo $br2['nama_biaya']; ?></td>
                                            <td width="25%">
                                                <input type="hidden" class="form-control" name="biaya_br[]" readonly
                                                    value="<?php echo $br['biaya_id']; ?>">
                                                <input type="text" class="form-control" name="ket_br[]"
                                                    value="<?php echo $br['keterangan']; ?>">
                                            </td>
                                            <td width="20%"><input type="number" class="form-control" name="jumlah_br[]"
                                                    value="<?php echo $br['jumlah']; ?>"></td>
                                            <td width="20%"><input type="number" class="form-control grandbr"
                                                    oninput="HitungTotalBr()" name="nilai_br[]"
                                                    value="<?php echo $br['nilai']; ?>">
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total Pengeluaran Rutin</th>
                                            <th>
                                                <div id="grandbr" class="text-end"><?php echo Uang($total_br); ?></div>
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
                                <div class="d-flex justify-content-between">
                                    <div class="mt-1">Pengeluaran Lain Lain</div>
                                    <div>
                                        <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#tambahbl">Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
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
                                            foreach ($biaya_lain as $bl) {
                                                $bl2 = $this->db->get_where('master_biaya', ['id_biaya' => $bl['biaya_id']])->row_array();
                                                ?>
                                        <tr>
                                            <td width="10%"><?php echo $bl2['kode_biaya']; ?></td>
                                            <td width="25%"><?php echo $bl2['nama_biaya']; ?></td>
                                            <td width="25%">
                                                <input type="hidden" class="form-control" name="akun_bl[]" readonly
                                                    value="<?php echo $bl['biaya_id']; ?>">
                                                <input type="text" class="form-control" name="ket_bl[]"
                                                    value="<?php echo $bl['keterangan']; ?>">
                                                <input type="hidden" class="form-control" name="id_dp[]"
                                                    value="<?php echo $bl['id_dp']; ?>">
                                            </td>
                                            <td width="20%"><input type="number" class="form-control" name="jumlah_bl[]"
                                                    value="<?php echo $bl['jumlah']; ?>"></td>
                                            <td width="20%"><input type="number" class="form-control grandbl"
                                                    oninput="HitungTotalBl()" name="nilai_bl[]"
                                                    value="<?php echo $bl['nilai']; ?>">
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <table class="table table-bordered table-striped my-0 pt-0 w-100" style="width: 100%;">
                                    <tbody style="width: 100%;">
                                        <?php
                                                foreach ($master_biaya as $bl) { ?>
                                        <tr class="d-none w-100" id="trbl1<?php echo $bl['id_biaya']; ?>" style="width: 100%;">
                                            <td width="10%">
                                                <span class="d-none"><input type="checkbox"
                                                        id="cb_bl1<?php echo $bl['id_biaya']; ?>" name="biaya_bl1[]"
                                                        value="<?php echo $bl['id_biaya']; ?>"></span>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hpsbl1(<?php echo $bl['id_biaya']; ?>)"><i
                                                        class="bx bx-trash"></i></button>
                                                <?php echo $bl['kode_biaya']; ?>
                                            </td>
                                            <td width="25%"><?php echo $bl['nama_biaya']; ?></td>
                                            <td width="25%">
                                                <input type="text" class="form-control input_bl1<?php echo $bl['id_biaya']; ?>"
                                                    name="ket_bl1<?php echo $bl['id_biaya']; ?>">
                                            </td>
                                            <td width="20%"><input type="number"
                                                    class="form-control input_bl1<?php echo $bl['id_biaya']; ?>"
                                                    name="jumlah_bl1<?php echo $bl['id_biaya']; ?>"></td>
                                            <td width="20%"><input type="number"
                                                    class="form-control input_bl1<?php echo $bl['id_biaya']; ?> grandbl"
                                                    oninput="HitungTotalBl()" name="nilai_bl1<?php echo $bl['id_biaya']; ?>">
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" style="width: 100%;">
                                    <tfoot style="border-top: 2px solid #000">
                                        <tr>
                                            <th width="80%" colspan="4">Total Pengeluaran Lain Lain</th>
                                            <th width="20%">
                                                <div id="grandbl" class="text-end"><?php echo Uang($total_bl); ?></div>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="tambahbl" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th>Pilih</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                    foreach ($master_biaya as $bl) { ?>
                                            <tr>
                                                <td style="width: 10%"><input type="checkbox" class="form-check-input"
                                                        id="tbbl1<?php echo $bl['id_biaya']; ?>"
                                                        onclick="tambahbl1(<?php echo $bl['id_biaya']; ?>)"></td>
                                                <td><?php echo $bl['kode_biaya']; ?></td>
                                                <td><?php echo $bl['nama_biaya']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="d-flex justify-content-between">
                                    <div class="mt-1">Pembelian Barang</div>
                                    <div>
                                        <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#tambahpb">Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
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
                                                foreach ($pembelian as $pb) {
                                                    $pb2 = $this->db->get_where('master_barang', ['id' => $pb['barang_id']])->row_array();
                                                    ?>
                                        <tr>
                                            <td><?php echo $pb2['kode_barang']; ?></td>
                                            <td><?php echo $pb2['nama_barang']; ?></td>
                                            <td>
                                                <select name="satuan[]"
                                                    class="form-control input_pb<?php echo $pb['barang_id']; ?>">
                                                    <option
                                                        <?php if ($pb['satuan'] == $pb2['satuan_utama']) {
                                                            echo 'selected';
                                                        }?>
                                                        value="<?php echo $pb2['satuan_utama']; ?>"><?php echo $pb2['satuan_utama']; ?>
                                                    </option>
                                                    <?php if ($pb2['satuan_kedua'] != '') { ?>
                                                    <option
                                                        <?php if ($pb['satuan'] == $pb2['satuan_kedua']) {
                                                            echo 'selected';
                                                        }?>
                                                        value="<?php echo $pb2['satuan_kedua']; ?>"><?php echo $pb2['satuan_kedua']; ?>
                                                    </option>
                                                    <?php }?>
                                                    <?php if ($pb2['satuan_ketiga'] != '') { ?>
                                                    <option
                                                        <?php if ($pb['satuan'] == $pb2['satuan_ketiga']) {
                                                            echo 'selected';
                                                        }?>
                                                        value="<?php echo $pb2['satuan_ketiga']; ?>">
                                                        <?php echo $pb2['satuan_ketiga']; ?>
                                                    </option>
                                                    <?php }?>
                                                    <?php if ($pb2['satuan_keempat'] != '') { ?>
                                                    <option
                                                        <?php if ($pb['satuan'] == $pb2['satuan_keempat']) {
                                                            echo 'selected';
                                                        }?>
                                                        value="<?php echo $pb2['satuan_keempat']; ?>">
                                                        <?php echo $pb2['satuan_keempat']; ?>
                                                    </option>
                                                    <?php }?>
                                                    <?php if ($pb2['satuan_kelima'] != '') { ?>
                                                    <option
                                                        <?php if ($pb['satuan'] == $pb2['satuan_kelima']) {
                                                            echo 'selected';
                                                        }?>
                                                        value="<?php echo $pb2['satuan_kelima']; ?>">
                                                        <?php echo $pb2['satuan_kelima']; ?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control input_pb<?php echo $pb['barang_id']; ?>"
                                                    id="qty<?php echo $pb['barang_id']; ?>"
                                                    oninput="hargaPb(<?php echo $pb['barang_id']; ?>)" name="qty[]"
                                                    value="<?php echo $pb['qty']; ?>">
                                            </td>
                                            <td class="text-end">
                                                <div id="hrg<?php echo $pb['barang_id']; ?>"><?php echo Uang($pb['harga']); ?></div>
                                                <input type="hidden" class="form-control" name="barang_bp[]" readonly
                                                    value="<?php echo $pb['barang_id']; ?>">
                                                <input type="hidden" class="form-control" name="harga[]"
                                                    value="<?php echo $pb['harga']; ?>" id="harga<?php echo $pb['barang_id']; ?>">
                                                <input type="hidden" class="form-control" name="id_pem[]"
                                                    value="<?php echo $pb['id_pb']; ?>">
                                            </td>
                                            <td><input type="number"
                                                    class="form-control input_pb<?php echo $pb['barang_id']; ?> grandpb"
                                                    id="nilai<?php echo $pb['barang_id']; ?>"
                                                    oninput="HitungTotalPb(); hargaPb(<?php echo $pb['barang_id']; ?>)"
                                                    value="<?php echo $pb['nilai']; ?>" name="nilai[]"></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <table class="table table-bordered table-striped my-0 pt-0 w-100" style="width: 100%;">
                                    <tbody>
                                        <?php
                                        foreach ($beli as $pb) { ?>
                                        <?php
                                            $cek = $this->db->get_where('dapur_pembelian', ['tanggal' => $date, 'user_id' => $username['id'], 'barang_id' => $pb['id']])->num_rows();
                                            if ($cek == 0) { ?>
                                        <tr class="d-none w-100" id="trpb1<?php echo $pb['id']; ?>" style="width: 100%;">
                                            <td width="10%">
                                                <span class="d-none"><input type="checkbox" class="form-check-input"
                                                        id="cb_pb1<?php echo $pb['id']; ?>" name="barang_bp1[]"
                                                        value="<?php echo $pb['id']; ?>"></span>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hpspb1(<?php echo $pb['id']; ?>)"><i
                                                        class="bx bx-trash"></i></button>
                                                <?php echo $pb['kode_barang']; ?>
                                            </td>
                                            <td width="30%"><?php echo $pb['nama_barang']; ?></td>
                                            <td width="10%">
                                                <select name="satuan1<?php echo $pb['id']; ?>"
                                                    class="form-control input_pb1<?php echo $pb['id']; ?>">
                                                    <option value="<?php echo $pb['satuan_utama']; ?>">
                                                        <?php echo $pb['satuan_utama']; ?>
                                                    </option>
                                                    <?php if ($pb['satuan_kedua'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_kedua']; ?>">
                                                        <?php echo $pb['satuan_kedua']; ?>
                                                    </option>
                                                    <?php }?>
                                                    <?php if ($pb['satuan_ketiga'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_ketiga']; ?>">
                                                        <?php echo $pb['satuan_ketiga']; ?>
                                                    </option>
                                                    <?php }?>
                                                    <?php if ($pb['satuan_keempat'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_keempat']; ?>">
                                                        <?php echo $pb['satuan_keempat']; ?></option>
                                                    <?php }?>
                                                    <?php if ($pb['satuan_kelima'] != '') { ?>
                                                    <option value="<?php echo $pb['satuan_kelima']; ?>">
                                                        <?php echo $pb['satuan_kelima']; ?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td width="10%">
                                                <input type="number" class="form-control input_pb1<?php echo $pb['id']; ?>"
                                                    id="qty1<?php echo $pb['id']; ?>" oninput="hargaPb1(<?php echo $pb['id']; ?>)"
                                                    name="qty1<?php echo $pb['id']; ?>">
                                            </td>
                                            <td width="20%" class="text-end">
                                                <div id="hrg1<?php echo $pb['id']; ?>">Rp. 0,00</div>
                                                <input type="hidden" class="form-control" name="harga1<?php echo $pb['id']; ?>"
                                                    id="harga1<?php echo $pb['id']; ?>">
                                            </td>
                                            <td width="20%"><input type="number"
                                                    class="form-control input_pb1<?php echo $pb['id']; ?> grandpb"
                                                    id="nilai1<?php echo $pb['id']; ?>"
                                                    oninput="HitungTotalPb(); hargaPb1(<?php echo $pb['id']; ?>)"
                                                    name="nilai1<?php echo $pb['id']; ?>"></td>
                                        </tr>
                                        <?php }?>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" style="width: 100%;">
                                    <tfoot style="border-top: 2px solid #000">
                                        <tr>
                                            <th colspan="5">Total Pembelian Barang</th>
                                            <th class="text-end" id="grandpb" width="20%"><?php echo Uang($total_pb); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="tambahpb" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped" id="example4">
                                        <thead>
                                            <tr>
                                                <th>Pilih</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($beli as $pb) { ?>
                                            <?php
                                                $cek = $this->db->get_where('dapur_pembelian', ['tanggal' => $date, 'user_id' => $username['id'], 'barang_id' => $pb['id']])->num_rows();
                                                if ($cek == 0) {
                                                    ?>
                                            <tr>
                                                <td style="width: 10%"><input type="checkbox" class="form-check-input"
                                                        id="tbpb1<?php echo $pb['id']; ?>"
                                                        onclick="tambahpb1(<?php echo $pb['id']; ?>)">
                                                </td>
                                                <td style="width: 20%"><?php echo $pb['kode_barang']; ?></td>
                                                <td><?php echo $pb['nama_barang']; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-resposive">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Total Pengeluaran Rutin</td>
                                            <input type="hidden" value="<?php echo $total_br; ?>" id="grandbr1">
                                            <td width="20%" class="text-end" id="grandbr2"><?php echo Uang($total_br); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Pengeluaran Lain Lain</td>
                                            <input type="hidden" value="<?php echo $total_bl; ?>" id="grandbl1">
                                            <td width="20%" class="text-end" id="grandbl2"><?php echo Uang($total_bl); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Pembelian Barang</td>
                                            <input type="hidden" value="<?php echo $total_pb; ?>" id="grandpb1">
                                            <td width="20%" class="text-end" id="grandpb2"><?php echo Uang($total_pb); ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Grand Total Pengeluran Dapur</th>
                                            <th width="20%" class="text-end" id="maxpengeluaran">
                                                <?php echo Uang($total_br + $total_bl + $total_pb); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <?php
                    $cek = $this->db->get_where('dapur_pengeluaran', ['tanggal' => $date, 'user_id' => $nickname['id'], 'transaksi' => $trx, 'status' => 1])->num_rows();
                if ($cek > 0) {
                    ?>
                    <div class="form-group">
                        <a class="btn btn-primary" href="<?php echo base_url('dapur/dapur_menu'); ?>">Kembali</a>
                    </div>
                    <?php } else { ?>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Edit</button>
                    </div>
                    <?php }?>
                </div>
                <script>
                function tambahbl1(value) {
                    const checkbox = $(`input#tbbl1${value}`);
                    const checkbox2 = $(`input#cb_bl1${value}`);
                    const tr = $(`#trbl1${value}`);
                    if (checkbox.prop("checked")) {
                        checkbox2.prop("checked", true);
                        tr.addClass("d-block").removeClass("d-none");
                    } else {
                        checkbox2.prop("checked", false);
                        tr.addClass("d-none").removeClass("d-block");
                    }
                }


                function hpsbl1(value) {
                    const checkbox = $(`input#tbbl1${value}`);
                    const checkbox2 = $(`input#cb_bl1${value}`);
                    const tr = $(`#trbl1${value}`);
                    checkbox.prop("checked", false);
                    checkbox2.prop("checked", false);
                    tr.addClass("d-none").removeClass("d-block");
                }

                function hargaPb(value) {
                    const nilai = $(`#nilai${value}`).val();
                    const qty = $(`#qty${value}`).val();
                    const harga = nilai / qty;
                    $(`#harga${value}`).val(harga);
                    $(`#hrg${value}`).text(FormatRupiah(harga));
                }

                function tambahpb1(value) {
                    const checkbox = $(`input#tbpb1${value}`);
                    const checkbox2 = $(`input#cb_pb1${value}`);
                    const tr = $(`#trpb1${value}`);
                    if (checkbox.prop("checked")) {
                        checkbox2.prop("checked", true);
                        tr.addClass("d-block").removeClass("d-none");
                    } else {
                        checkbox2.prop("checked", false);
                        tr.addClass("d-none").removeClass("d-block");
                    }
                }

                function hargaPb1(value) {
                    const nilai = $(`#nilai1${value}`).val();
                    const qty = $(`#qty1${value}`).val();
                    const harga = nilai / qty;
                    $(`#harga1${value}`).val(harga);
                    $(`#hrg1${value}`).text(FormatRupiah(harga));
                }

                function hpspb1(value) {
                    const checkbox = $(`input#tbpb1${value}`);
                    const checkbox2 = $(`input#cb_pb1${value}`);
                    const tr = $(`#trpb1${value}`);
                    checkbox.prop("checked", false);
                    checkbox2.prop("checked", false);
                    tr.addClass("d-none").removeClass("d-block");
                }

                function HitungTotalBr() {
                    var totalPengeluaranBr = 0;
                    var pengeluaranBrElements = $('.grandbr');
                    pengeluaranBrElements.each(function() {
                        if ($(this).val() != '' && $(this).val() != null) {
                            totalPengeluaranBr += parseInt($(this).val());
                        }
                    });
                    $('#grandbr').text(FormatRupiah(totalPengeluaranBr));
                    $('#grandbr1').val(totalPengeluaranBr);
                    $('#grandbr2').text(FormatRupiah(totalPengeluaranBr));
                    var a = parseInt($('#grandbl1').val());
                    var b = parseInt($('#grandpb1').val());
                    var total = a + b + totalPengeluaranBr;
                    $('#maxpengeluaran').text(FormatRupiah(total));
                }

                function HitungTotalBl() {
                    var totalPengeluaranBl = 0;
                    var pengeluaranBlElements = $('.grandbl');
                    pengeluaranBlElements.each(function() {
                        if ($(this).val() != '' && $(this).val() != null) {
                            totalPengeluaranBl += parseInt($(this).val());
                        }
                    });
                    $('#grandbl').text(FormatRupiah(totalPengeluaranBl));
                    $('#grandbl1').val(totalPengeluaranBl);
                    $('#grandbl2').text(FormatRupiah(totalPengeluaranBl));
                    var a = parseInt($('#grandbr1').val());
                    var b = parseInt($('#grandpb1').val());
                    var total = a + b + totalPengeluaranBl;
                    $('#maxpengeluaran').text(FormatRupiah(total));
                }

                function HitungTotalPb() {
                    var totalPengeluaranBl = 0;
                    var pengeluaranBlElements = $('.grandpb');
                    pengeluaranBlElements.each(function() {
                        if ($(this).val() != '' && $(this).val() != null) {
                            totalPengeluaranBl += parseInt($(this).val());
                        }
                    });
                    $('#grandpb').text(FormatRupiah(totalPengeluaranBl));
                    $('#grandpb1').val(totalPengeluaranBl);
                    $('#grandpb2').text(FormatRupiah(totalPengeluaranBl));
                    var a = parseInt($('#grandbr1').val());
                    var b = parseInt($('#grandbl1').val());
                    var total = a + b + totalPengeluaranBl;
                    $('#maxpengeluaran').text(FormatRupiah(total));
                }
                </script>
            </form>
            <?php }?>
        </div>
    </div>
</div>