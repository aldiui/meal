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
                        <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
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
                        <?php echo $title; ?> Sales
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('admin/sales_menu/rolling_sales'); ?>" method="get">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input class="result form-control" type="text" id="date" required
                                        placeholder="Tanggal..." name="tanggal" value="<?php echo @$date; ?>">
                                    <input type="hidden" value="<?php echo @$username['id']; ?>" name="id">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="date" class="form-label">Outlet</label>
                                    <input class="result form-control" type="text"
                                        value="<?php echo getOutlet(@$username['outlet_id']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="date" class="form-label">Sales</label>
                                    <input class="result form-control" type="text" value="<?php echo @$username['nama']; ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Mulai</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <?php if ($olah == 'input') { ?>
            <form action="<?php echo base_url('admin/sales_menu/tambah_rs/').@$date.'/'.@$username['id']; ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Persediaan</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Qty Awal</th>
                                        <th>Qty Pemakaian</th>
                                        <th>Qty Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($this->input->get('tanggal') != null) { ?>
                                    <input type="hidden" name="no_bukti" value="<?php echo $no_bukti; ?>">
                                    <?php
                                    $no = 1;
                                        foreach ($sediaan as $s) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $s['kode_barang']; ?></td>
                                        <td><?php echo $s['nama_barang']; ?></td>
                                        <td width="15%">
                                            <?php $barang = $this->db->get_where('barang_sediaan', ['barang_id' => $s['id']])->row_array(); ?>
                                            <input type="hidden" value="<?php echo $barang['id']; ?>" name="sediaan[]">
                                            <input type="number"
                                                oninput="updateQtyAkhir(this.value, <?php echo $barang['id']; ?>)"
                                                class="form-control" id="qty_awal<?php echo $barang['id']; ?>" min="0"
                                                name="qtyawl[]">
                                        </td>
                                        <td width="15%" class="text-end">
                                            <input type="number" class="form-control"
                                                id="qty_pemakaian<?php echo $barang['id']; ?>" name="qtypki[]" readonly>
                                        </td>
                                        <td width=" 15%" class="text-end">
                                            <input type="number" class="form-control" id="qty_akhir<?php echo $barang['id']; ?>"
                                                readonly>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Penjualan</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th width="15%">Qty</th>
                                        <th width="20%">Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($this->input->get('tanggal') != null) { ?>
                                    <?php
                                        $no = 1;
                                        foreach ($penjualan as $pj) {
                                            ?>
                                    <?php if ($pj['sediaan_id'] > 0) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $pj['kode_barang']; ?></td>
                                        <td><?php echo $pj['nama_barang']; ?></td>
                                        <td>
                                            <input type="hidden" name="sediaan_id[]" class="form-control"
                                                value="<?php echo $pj['sediaan_id']; ?>" readonly>
                                            <input type="hidden" name="barang_id[]" class="form-control"
                                                value="<?php echo $pj['id']; ?>" readonly>
                                            <input type="hidden" name="qty_awal[]"
                                                class="form-control awalan<?php echo $pj['sediaan_id']; ?>"
                                                id="awalan<?php echo $no; ?>" readonly>
                                            <input type="number" name="qty_pemakaian[]"
                                                oninput="HitungPenjualan(this.value, <?php echo $no; ?>); HitungSisaStok(<?php echo $pj['sediaan_id']; ?>);HitungTotalPenjualan();"
                                                class="form-control pemakaian<?php echo $pj['sediaan_id']; ?>" min="0">
                                            <input type="hidden" name="qty_akhir[]" class="form-control"
                                                id="akhiran<?php echo $no; ?>" readonly>
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" value="<?php echo $pj['harga']; ?>" class="form-control"
                                                id="harga<?php echo $no; ?>" readonly>
                                            <?php echo Uang($pj['harga']); ?>
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" name="total[]" class="form-control grandpenjualan"
                                                readonly id="totalx<?php echo $no; ?>">
                                            <span id="totaly<?php echo $no; ?>">Rp. 0,00</span>
                                        </td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $pj['kode_barang']; ?></td>
                                        <td><?php echo $pj['nama_barang']; ?></td>
                                        <td>
                                            <input type="hidden" name="sediaan_id[]" class="form-control"
                                                value="<?php echo $pj['sediaan_id']; ?>" readonly>
                                            <input type="hidden" name="barang_id[]" class="form-control"
                                                value="<?php echo $pj['id']; ?>" readonly>
                                            <input type="number" name="qty_pemakaian[]"
                                                oninput="HitungPenjualan(this.value, <?php echo $no; ?>); HitungPaket(this.value, <?php echo $pj['id']; ?>); HitungSisaStok(<?php echo $pj['sediaan2']; ?>); HitungSisaStok(<?php echo $pj['sediaan3']; ?>); HitungSisaStok(<?php echo $pj['sediaan4']; ?>); HitungSisaStok(<?php echo $pj['sediaan5']; ?>); HitungSisaStok(<?php echo $pj['sediaan6']; ?>); HitungSisaStok(<?php echo $pj['sediaan7']; ?>); HitungTotalPenjualan(); "
                                                class="form-control pemakaian<?php echo $pj['sediaan_id']; ?>" min="0">
                                            <?php for ($i = 2; $i <= 7; ++$i) { ?>
                                            <?php if ($pj["sediaan{$i}"] > 0) { ?>
                                            <input type="hidden" value="<?php echo $pj["qty{$i}"]; ?>"
                                                id="qtyp<?php echo $i.$pj['id']; ?>">
                                            <input type="hidden" class="pemakaian<?php echo $pj["sediaan{$i}"]; ?>"
                                                id="sediaanp<?php echo $i.$pj['id']; ?>">
                                            <?php }?>
                                            <?php } ?>
                                        </td>
                                        <td class=" text-end">
                                            <input type="hidden" value="<?php echo $pj['harga']; ?>" class="form-control"
                                                id="harga<?php echo $no; ?>" readonly>
                                            <?php echo Uang($pj['harga']); ?>
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" name="total[]" class="form-control grandpenjualan"
                                                readonly id="totalx<?php echo $no; ?>">
                                            <span id="totaly<?php echo $no; ?>">Rp. 0,00</span>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php }?>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total Penjualan</th>
                                        <th width="20%" class="text-end" id="totalpenjualan2">Rp. 0,00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pengeluaran</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="10%">Kode</th>
                                        <th width="25%">Nama</th>
                                        <th width="25%">Keterangan</th>
                                        <th width="20%">Jumlah</th>
                                        <th width="20%">Nilai</th>
                                    </tr>
                                </thead>
                                <?php if ($this->input->get('tanggal') != null) { ?>
                                <?php
                                            $no = 1;
                                    foreach ($akun as $ak) {
                                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $ak['kode_biaya']; ?></td>
                                    <td><?php echo $ak['nama_biaya']; ?></td>
                                    <td>
                                        <input type="hidden" class="form-control" name="akun_id[]" readonly
                                            value="<?php echo $ak['id_biaya']; ?>">
                                        <input type="text" class="form-control" name="keterangan[]">
                                    </td>
                                    <td><input type="number" class="form-control" name="jumlah[]"></td>
                                    <td><input type="number" class="form-control grandpengeluaran" name="nilai[]"
                                            oninput="hitungTotalPengeluaran()"></td>
                                </tr>
                                <?php }?>
                                <?php }?>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total Pengeluaran</th>
                                        <th width="20%" class="text-end" id="totalpengeluaran">Rp. 0,00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Total Penjualan</td>
                                        <td width="20%" class="text-end" id="totalpenjualanakhir">Rp. 0,00</td>
                                        <input type="hidden" id="totalpenjualanakhir2">
                                    </tr>
                                    <tr>
                                        <td>Total Biaya</td>
                                        <td width="20%" class="text-end" id="totalpengeluaranakhir">Rp. 0,00</td>
                                        <input type="hidden" id="totalpengeluaranakhir2">
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Uang di Terima</th>
                                        <th width="20%" class="text-end" id="uangditerima">Rp. 0,00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="inputtotal" type="submit">Submit</button>
                </div>
            </form>
            <script>
            function updateQtyAkhir(value, counter) {
                var qtyPemakaian = $("#qty_pemakaian" + counter).val();
                $("#qty_akhir" + counter).val(value - qtyPemakaian);
            }

            function HitungPaket(value, id) {
                for (var i = 2; i <= 7; i++) {
                    $("#sediaanp" + i + id).val(value * $("#qtyp" + i + id).val());
                }
            }

            function HitungSisaStok(sediaan) {
                var totalPemakaian = 0;
                $(".pemakaian" + sediaan).each(function() {
                    if ($(this).val() && !isNaN(parseInt($(this).val()))) {
                        totalPemakaian += parseInt($(this).val());
                    }
                });
                $('#qty_pemakaian' + sediaan).val(totalPemakaian);
                var qtyAwal = $("#qty_awal" + sediaan).val();
                var qtyPemakaian = $("#qty_pemakaian" + sediaan).val();
                $("#qty_akhir" + sediaan).val(qtyAwal - qtyPemakaian);
            }

            function HitungPenjualan(value, counter) {
                var awal = $('#awalan' + counter).val();
                var harga = $('#harga' + counter).val();
                var total = $('#totalx' + counter).val();
                var totaljual = harga * value;
                var akhiran = awal - value
                $('#totalx' + counter).val(totaljual);
                $('#totaly' + counter).text(FormatRupiah(totaljual));
                $('#akhiran' + counter).val(akhiran);
            }

            function HitungTotalPenjualan() {
                var totalPenjualan = 0;
                var penjualanElements = $('.grandpenjualan');
                penjualanElements.each(function() {
                    if ($(this).val() != '' && $(this).val() != null) {
                        totalPenjualan += parseInt($(this).val());
                    }
                });
                $('#totalpenjualan2').text(FormatRupiah(totalPenjualan));
                $('#totalpenjualanakhir').text(FormatRupiah(totalPenjualan));
                $('#totalpenjualanakhir2').val(totalPenjualan);
                var totalPengeluaran = $('#totalpengeluaranakhir2').val();
                var totalPengurangan = totalPenjualan - totalPengeluaran;
                $('#uangditerima').text(FormatRupiah(totalPengurangan));
            }

            function hitungTotalPengeluaran() {
                var totalPengeluaran = 0;
                var pengeluaranElements = $('.grandpengeluaran');
                pengeluaranElements.each(function() {
                    if ($(this).val() != '' && $(this).val() != null) {
                        totalPengeluaran += parseInt($(this).val());
                    }
                });
                $('#totalpengeluaran').text(FormatRupiah(totalPengeluaran))
                $('#totalpengeluaranakhir').text(FormatRupiah(totalPengeluaran))
                $('#totalpengeluaranakhir2').val(totalPengeluaran)
                var totalPenjualan = $('#totalpenjualanakhir2').val();
                var totalPengurangan = totalPenjualan - totalPengeluaran;
                $('#uangditerima').text(FormatRupiah(totalPengurangan));
            }
            </script>
            <?php } elseif ($olah == 'edit') { ?>
            <form action="<?php echo base_url('admin/sales_menu/edit_rs/').@$date.'/'.@$username['id']; ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Persediaan</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Qty Awal</th>
                                        <th>Qty Pemakaian</th>
                                        <th>Qty Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($this->input->get('tanggal') != null) { ?>
                                    <?php
                                    $no = 1;
                                        foreach ($sediaan as $s) { ?>
                                    <?php $barang = $this->db->get_where('barang_sediaan', ['id' => $s['sediaan_id']])->row_array(); ?>
                                    <?php $br = $this->db->get_where('master_barang', ['id' => $barang['barang_id']])->row_array(); ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $br['kode_barang']; ?></td>
                                        <td><?php echo $br['nama_barang']; ?></td>
                                        <td width="15%">
                                            <input type="hidden" value="<?php echo $s['id_sad']; ?>" name="sediaan[]">
                                            <input type="number"
                                                oninput="updateQtyAkhir(this.value, <?php echo $barang['id']; ?>)"
                                                class="form-control" id="qty_awal<?php echo $barang['id']; ?>" min="0"
                                                name="qtyawl[]" value="<?php echo $s['qty_awal']; ?>">
                                        </td>
                                        <td width="15%" class="text-end">
                                            <input type="number" class="form-control"
                                                id="qty_pemakaian<?php echo $barang['id']; ?>" name="qtypki[]" readonly
                                                value="<?php echo $s['qty_pemakaian']; ?>">
                                        </td>
                                        <td width=" 15%" class="text-end">
                                            <input type="number" class="form-control" id="qty_akhir<?php echo $barang['id']; ?>"
                                                readonly value="<?php echo $s['qty_akhir']; ?>">
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Penjualan</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th width="15%">Qty</th>
                                        <th width="20%">Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($this->input->get('tanggal') != null) { ?>
                                    <?php
                                        $no = 1;
                                        foreach ($penjualan as $pj) {
                                            $barang = $this->db->get_where('master_barang', ['id' => $pj['barang_id']])->row_array();
                                            ?>
                                    <?php if ($pj['sediaan_id'] > 0) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $barang['kode_barang']; ?></td>
                                        <td><?php echo $barang['nama_barang']; ?></td>
                                        <td>
                                            <input type="hidden" name="barang_id[]" class="form-control"
                                                value="<?php echo $pj['barang_id']; ?>" readonly>
                                            <input type="number" name="qty_pemakaian[]"
                                                value="<?php echo $pj['qty_pemakaian']; ?>"
                                                oninput="HitungPenjualan(this.value, <?php echo $no; ?>); HitungSisaStok(<?php echo $pj['sediaan_id']; ?>); HitungTotalPenjualan();"
                                                class="form-control pemakaian<?php echo $pj['sediaan_id']; ?>" min="0">
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" value="<?php echo $barang['harga']; ?>" class="form-control"
                                                id="harga<?php echo $no; ?>" readonly>
                                            <?php echo Uang($barang['harga']); ?>
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" name="total[]" value="<?php echo $pj['total']; ?>"
                                                class="form-control grandpenjualan" readonly id="totalx<?php echo $no; ?>">
                                            <span id="totaly<?php echo $no; ?>"><?php echo Uang($pj['total']); ?></span>
                                        </td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr>
                                        <?php $br = $this->db->get_where('sales_penjualan', ['barang_id' => $barang['id']])->row_array(); ?>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $barang['kode_barang']; ?></td>
                                        <td><?php echo $barang['nama_barang']; ?></td>
                                        <td>
                                            <input type="hidden" name="barang_id[]" class="form-control"
                                                value="<?php echo $pj['barang_id']; ?>" readonly>
                                            <input type="number" name="qty_pemakaian[]"
                                                value="<?php echo $pj['qty_pemakaian']; ?>"
                                                oninput="HitungPenjualan(this.value, <?php echo $no; ?>);  HitungPaket(this.value, <?php echo $pj['id']; ?>); HitungSisaStok(<?php echo $br['sediaan2']; ?>); HitungSisaStok(<?php echo $br['sediaan3']; ?>); HitungSisaStok(<?php echo $br['sediaan4']; ?>); HitungSisaStok(<?php echo $br['sediaan5']; ?>); HitungSisaStok(<?php echo $br['sediaan6']; ?>); HitungSisaStok(<?php echo $br['sediaan7']; ?>); HitungTotalPenjualan();"
                                                class="form-control" min="0">
                                            <?php for ($i = 2; $i <= 7; ++$i) { ?>
                                            <?php if ($br["sediaan{$i}"] > 0) { ?> <input type="hidden"
                                                value="<?php echo $br["qty{$i}"]; ?>" id="qtyp<?php echo $i.$pj['id']; ?>">
                                            <input type="hidden" class="pemakaian<?php echo $br["sediaan{$i}"]; ?>"
                                                id="sediaanp<?php echo $i.$pj['id']; ?>"
                                                value="<?php echo $pj['qty_pemakaian'] * $br["qty{$i}"]; ?>">
                                            <?php }?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" value="<?php echo $barang['harga']; ?>" class="form-control"
                                                id="harga<?php echo $no; ?>" readonly>
                                            <?php echo Uang($barang['harga']); ?>
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" name="total[]" value="<?php echo $pj['total']; ?>"
                                                class="form-control grandpenjualan" readonly id="totalx<?php echo $no; ?>">
                                            <span id="totaly<?php echo $no; ?>"><?php echo Uang($pj['total']); ?></span>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php }?>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total Penjualan</th>
                                        <th width="20%" class="text-end" id="totalpenjualan2">
                                            <?php echo Uang($totalpenjualan); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pengeluaran</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="10%">Kode</th>
                                        <th width="25%">Nama</th>
                                        <th width="25%">Keterangan</th>
                                        <th width="20%">Jumlah</th>
                                        <th width="20%">Nilai</th>
                                    </tr>
                                </thead>
                                <?php if ($this->input->get('tanggal') != null) { ?>
                                <?php
                                            $no = 1;
                                    foreach ($pengeluaran as $ak) {
                                        $akun = $this->db->get_where('master_biaya', ['id_biaya' => $ak['akun_id']])->row_array();
                                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $akun['kode_biaya']; ?></td>
                                    <td><?php echo $akun['nama_biaya']; ?></td>
                                    <td>
                                        <input type="hidden" class="form-control" name="akun_id[]" readonly
                                            value="<?php echo $ak['id_pengeluaran']; ?>">
                                        <input type="text" class="form-control" name="keterangan[]"
                                            value="<?php echo $ak['keterangan']; ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="jumlah[]"
                                            value="<?php echo $ak['jumlah']; ?>">
                                    </td>
                                    <td><input type="number" class="form-control grandpengeluaran" name="nilai[]"
                                            oninput="hitungTotalPengeluaran()" value="<?php echo $ak['nilai']; ?>"></td>
                                </tr>
                                <?php }?>
                                <?php }?>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total Pengeluaran</th>
                                        <th width="20%" class="text-end" id="totalpengeluaran">
                                            <?php echo Uang($totalpengeluaran); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Total Penjualan</td>
                                        <td width="20%" class="text-end" id="totalpenjualanakhir">
                                            <?php echo Uang($totalpenjualan); ?></td>
                                        <input type="hidden" id="totalpenjualanakhir2" value="<?php echo $totalpenjualan; ?>">
                                    </tr>
                                    <tr>
                                        <td>Total Biaya</td>
                                        <td width="20%" class="text-end" id="totalpengeluaranakhir">
                                            <?php echo Uang($totalpengeluaran); ?></td>
                                        <input type="hidden" id="totalpengeluaranakhir2"
                                            value="<?php echo $totalpengeluaran; ?>">
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Uang di Terima</th>
                                        <th width="20%" class="text-end" id="uangditerima">
                                            <?php echo Uang($totalpenjualan - $totalpengeluaran); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Edit</button>
                </div>
            </form>
            <script>
            function updateQtyAkhir(value, counter) {
                var qtyPemakaian = $("#qty_pemakaian" + counter).val();
                var qtyAkhir = value - qtyPemakaian;
                $("#qty_akhir" + counter).val(qtyAkhir);
            }

            function HitungPaket(value, id) {
                for (var i = 2; i <= 7; i++) {
                    $("#sediaanp" + i + id).val(value * $("#qtyp" + i + id).val());
                }
            }

            function HitungSisaStok(sediaan) {
                var totalPemakaian = 0;
                $(".pemakaian" + sediaan).each(function() {
                    if ($(this).val() && !isNaN(parseInt($(this).val()))) {
                        totalPemakaian += parseInt($(this).val());
                    }
                });
                $('#qty_pemakaian' + sediaan).val(totalPemakaian);
                var qtyAwal = $("#qty_awal" + sediaan).val();
                var qtyPemakaian = $("#qty_pemakaian" + sediaan).val();
                $("#qty_akhir" + sediaan).val(qtyAwal - qtyPemakaian);
            }


            function HitungPenjualan(value, counter) {
                var awal = $('#awalan' + counter).val();
                var harga = $('#harga' + counter).val();
                var total = $('#totalx' + counter).val();
                var totaljual = harga * value;
                var akhiran = awal - value
                $('#totalx' + counter).val(totaljual);
                $('#totaly' + counter).text(FormatRupiah(totaljual));
                $('#akhiran' + counter).val(akhiran);
            }

            function HitungTotalPenjualan() {
                var totalPenjualan = 0;
                var penjualanElements = $('.grandpenjualan');
                penjualanElements.each(function() {
                    if ($(this).val() != '' && $(this).val() != null) {
                        totalPenjualan += parseInt($(this).val());
                    }
                });
                $('#totalpenjualan2').text(FormatRupiah(totalPenjualan));
                $('#totalpenjualanakhir').text(FormatRupiah(totalPenjualan));
                $('#totalpenjualanakhir2').val(totalPenjualan);
                var totalPengeluaran = $('#totalpengeluaranakhir2').val();
                var totalPengurangan = totalPenjualan - totalPengeluaran;
                $('#uangditerima').text(FormatRupiah(totalPengurangan));
            }

            function hitungTotalPengeluaran() {
                var totalPengeluaran = 0;
                var pengeluaranElements = $('.grandpengeluaran');
                pengeluaranElements.each(function() {
                    if ($(this).val() != '' && $(this).val() != null) {
                        totalPengeluaran += parseInt($(this).val());
                    }
                });
                $('#totalpengeluaran').text(FormatRupiah(totalPengeluaran))
                $('#totalpengeluaranakhir').text(FormatRupiah(totalPengeluaran))
                $('#totalpengeluaranakhir2').val(totalPengeluaran)
                var totalPenjualan = $('#totalpenjualanakhir2').val();
                var totalPengurangan = totalPenjualan - totalPengeluaran;
                $('#uangditerima').text(FormatRupiah(totalPengurangan));
            }
            </script>
            <?php }?>
        </div>
    </div>
</div>