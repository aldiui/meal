<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php echo $this->session->flashdata('pesan'); ?>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="text-center"><?php echo $title; ?> Periode <?php echo TglIndo($year.'-'.$month.'-'); ?></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('admin/dashboard/caridata'); ?>" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" class="form-control" id="bulan" required>
                                        <option value="">Pilih Bulan ...</option>
                                        <?php foreach ($bulan as $b) { ?>
                                        <option value="<?php echo $b['no']; ?>"><?php echo $b['nama']; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" class="form-control" required>
                                        <option value="">Pilih Tahun ...</option>
                                        <?php foreach ($tahun as $t) { ?>
                                        <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card radius-10 bg-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="text-white">Total Penjualan</p>
                            <h2 class="mb-0 text-white">
                                <?php echo Uang($totalPenjualan); ?>
                            </h2>
                        </div>
                        <div class="ms-auto font-60 text-white">
                            <i class="bx bx-cart-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card radius-10 bg-primary-blue">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="text-white">Rata - Rata Penjualan Perhari</p>
                            <h2 class="mb-0 text-white">
                                <?php echo Uang($rataRata); ?>
                            </h2>
                        </div>
                        <div class="ms-auto font-60 text-white">
                            <i class="bx bx-tachometer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($outlet != 0) { ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="diagram1"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="diagram2"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="diagram3"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="diagram4"></div>
                </div>
            </div>
        </div>
        <?php }?>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Total Penjualan Perhari
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width: 100%;" id="totalexample">
                            <thead>
                                <tr>
                                    <th style="width: 5% !important;">No</th>
                                    <th>Tanggal</th>
                                    <th>Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($totalpenjualanhari != 0) { ?>
                                <?php
                                    $no = 1;
                                    foreach ($totalpenjualanhari as $row) {
                                        ?>
                                <tr>
                                    <td style="width: 5% !important;"><?php echo $no++; ?></td>
                                    <td><?php echo TglIndo($row['tanggal']); ?></td>
                                    <td class="text-end"><?php echo Uang($row['total_sales']); ?></td>
                                </tr>
                                <?php } ?>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Total Penjualan Barang
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width: 100%;" id="totalPenjualan">
                            <thead>
                                <tr>
                                    <th style="width: 5% !important;">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tp != 0) { ?>
                                <?php
                                                $no = 1;
                                    foreach ($tp as $row) {
                                        $brg = $this->db->get_where('master_barang', ['id' => $row['barang_id']])->row_array();
                                        ?>
                                <tr>
                                    <td style="width: 5% !important;"><?php echo $no++; ?></td>
                                    <td><?php echo $brg['kode_barang']; ?></td>
                                    <td><?php echo getBarang($row['barang_id']); ?></td>
                                    <td><?php echo $row['pemakaian']; ?></td>
                                    <td class="text-end"><?php echo Uang($row['total_harga']); ?></td>
                                </tr>
                                <?php } ?>
                                <?php }?>
                            </tbody>
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
                            <div class="mb-0 mt-1">History Data Penjualan</div>
                            <div>
                                <a href="<?php echo base_url('admin/dashboard/excel/'.$month.'/'.$year); ?>"
                                    class="btn btn-primary btn-sm">Cetak Laporan</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width: 100%;" id="example4">
                            <thead>
                                <tr>
                                    <th style="width: 5% !important;">No</th>
                                    <th>No Bukti</th>
                                    <th>Tanggal</th>
                                    <th>Outlet</th>
                                    <th>Sales</th>
                                    <th>Nominal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($pj != 0) { ?>
                                <?php
                                            $no = 1;
                                    foreach ($pj as $row) {
                                        ?>
                                <tr>
                                    <td style="width: 5% !important;"><?php echo $no++; ?></td>
                                    <td><?php echo $row['no_bukti']; ?></td>
                                    <td><?php echo TglIndo($row['tanggal']); ?></td>
                                    <td><?php echo getOutlet2($row['user_id']); ?></td>
                                    <?php if ($row['rolling'] >= 1) { ?>
                                    <td><?php echo getUser($row['rolling']); ?></td>
                                    <?php } else { ?>
                                    <td><?php echo getUser($row['user_id']); ?></td>
                                    <?php }?>
                                    <td class="text-end"><?php echo Uang($row['total_harga']); ?></td>
                                    <td style="width: 10% !important;">
                                        <a type="button" class="btn btn-warning btn-sm"
                                            href="<?php echo base_url('admin/sales_menu/rolling_sales?tanggal=').$row['tanggal'].'&id='.$row['user_id']; ?>"><i
                                                class="bx bx-edit"></i>
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hapus<?php echo $row['no_bukti']; ?>"><i
                                                class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $row['no_bukti']; ?>" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="<?php echo base_url('admin/dashboard/hapus2/').$row['no_bukti']; ?>"
                                                        method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="no_dok" class="form-label">No Bukti
                                                                </label>
                                                                <input type="text" class="form-control" name="no_dok"
                                                                    id="no_dok" value="<?php echo $row['no_bukti']; ?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal" value="<?php echo Tglindo($row['tanggal']); ?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Nominal</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal"
                                                                    value="<?php echo Uang($row['total_harga']); ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        History Data Penjualan Detail
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="example" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5% !important;">No</th>
                                    <th>No Bukti</th>
                                    <th>Tanggal</th>
                                    <th>Outlet</th>
                                    <th>Sales</th>
                                    <th>Nama Barang</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($pd != 0) { ?>
                                <?php
                                        $no = 1;
                                    foreach ($pd as $row) {
                                        ?>
                                <tr>
                                    <td style="width: 5% !important;"><?php echo $no++; ?></td>
                                    <td><?php echo $row['no_bukti']; ?></td>
                                    <td><?php echo TglIndo($row['tanggal']); ?></td>
                                    <td><?php echo getOutlet2($row['user_id']); ?></td>
                                    <?php if ($row['rolling'] >= 1) { ?>
                                    <td><?php echo getUser($row['rolling']); ?></td>
                                    <?php } else { ?>
                                    <td><?php echo getUser($row['user_id']); ?></td>
                                    <?php }?>
                                    <td><?php echo getBarang($row['barang_id']); ?></td>
                                    <td class="text-end"><?php echo Uang($row['total']); ?></td>
                                </tr>
                                <?php } ?>
                                <?php }?>
                            </tbody>
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
                            <div class="mb-0 mt-1">History Data Pengeluaran Dapur</div>
                            <div>
                                <a href="<?php echo base_url('admin/dashboard/excel1/'.$month.'/'.$year); ?>"
                                    class="btn btn-primary btn-sm">Cetak Laporan</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dapurexample" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 5% !important;">No</th>
                                    <th>No Dokumen</th>
                                    <th>Tanggal</th>
                                    <th>Dapur</th>
                                    <th>Pengeluaran</th>
                                    <th>Pembelian</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
            foreach ($dapur as $dp) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $dp['no_dok']; ?></td>
                                    <td><?php echo Tglindo($dp['tanggal']); ?></td>
                                    <?php $userdp = $this->db->get_where('master_user', ['id' => $dp['user_id']])->row_array(); ?>
                                    <?php if ($dp['rolling'] >= 1) { ?>
                                    <td><?php echo getUser($dp['rolling']); ?></td>
                                    <?php } else { ?>
                                    <td><?php echo $userdp['nama']; ?></td>
                                    <?php }?>
                                    <td class="text-end"><?php echo Uang($dp['total_nilai']); ?></td>
                                    <td class="text-end"><?php echo Uang(getTotalPembelian($dp['no_dok'])); ?></td>
                                    <td class="text-end">
                                        <?php echo Uang($dp['total_nilai'] + getTotalPembelian($dp['no_dok'])); ?>
                                    </td>
                                    <td>
                                        <?php if ($dp['status'] == 0) { ?>
                                        <div class="badge bg-danger">Belum</div>
                                        <?php } else { ?>
                                        <div class="badge bg-success">Cek</div>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('admin/dapur_menu/rolling_dapur?tanggal=').$dp['tanggal'].'&id='.$dp['user_id'].'&trx='.$dp['transaksi']; ?>"
                                            class="btn btn-warning btn-sm"><i class="bx bx-edit"></i></a>
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hapus<?php echo $dp['no_dok']; ?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $dp['no_dok']; ?>" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="<?php echo base_url('admin/dashboard/hapus/').$dp['no_dok']; ?>"
                                                        method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="no_dok" class="form-label">No
                                                                    Dokumentasi</label>
                                                                <input type="text" class="form-control" name="no_dok"
                                                                    id="no_dok" value="<?php echo $dp['no_dok']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal" value="<?php echo Tglindo($dp['tanggal']); ?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="username" class="form-label">Dapur</label>
                                                                <input type="text" class="form-control" name="username"
                                                                    id="username" value="<?php echo $userdp['username']; ?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Total</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal"
                                                                    value="<?php echo Uang($dp['total_nilai'] + getTotalPembelian($dp['tanggal'], $dp['user_id'])); ?>"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>