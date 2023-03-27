<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?= $this->session->flashdata('pesan'); ?>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="text-center"><?= $title;?> Periode <?= TglIndo($year."-".$month."-");?></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url("admin/dashboard/caridata");?>" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" class="form-control" id="bulan" required>
                                        <option value="">Pilih Bulan ...</option>
                                        <?php foreach($bulan as $b):?>
                                        <option value="<?= $b["no"];?>"><?= $b["nama"];?></option>
                                        <?php  endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" class="form-control" required>
                                        <option value="">Pilih Tahun ...</option>
                                        <?php foreach($tahun as $t):?>
                                        <option value="<?= $t;?>"><?= $t;?></option>
                                        <?php  endforeach;?>
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
                                <?= Uang($totalPenjualan);?>
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
                                <?= Uang($rataRata);?>
                            </h2>
                        </div>
                        <div class="ms-auto font-60 text-white">
                            <i class="bx bx-tachometer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($outlet != 0):?>
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
        <?php endif;?>
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
                                <?php if($totalpenjualanhari != 0):?>
                                <?php
                                    $no = 1;
                                    foreach ($totalpenjualanhari as $row) :
                                ?>
                                <tr>
                                    <td style="width: 5% !important;"><?= $no++ ?></td>
                                    <td><?= TglIndo($row["tanggal"]);?></td>
                                    <td class="text-end"><?= Uang($row["total_sales"]);?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
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
                                <?php if($tp != 0):?>
                                <?php
                                        $no = 1;
                                        foreach ($tp as $row) :
                                        $brg = $this->db->get_where("master_barang", ["id" => $row["barang_id"]])->row_array();
                                    ?>
                                <tr>
                                    <td style="width: 5% !important;"><?= $no++ ?></td>
                                    <td><?= $brg["kode_barang"];?></td>
                                    <td><?= getBarang($row["barang_id"]);?></td>
                                    <td><?= $row["pemakaian"];?></td>
                                    <td class="text-end"><?= Uang($row["total_harga"]);?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
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
                                <a href="<?= base_url("admin/dashboard/excel/".$month."/".$year);?>"
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
                                <?php if($pj != 0):?>
                                <?php
                                        $no = 1;
                                        foreach ($pj as $row) :
                                    ?>
                                <tr>
                                    <td style="width: 5% !important;"><?= $no++ ?></td>
                                    <td><?= $row["no_bukti"];?></td>
                                    <td><?= TglIndo($row["tanggal"]);?></td>
                                    <td><?= getOutlet2($row["user_id"]);?></td>
                                    <?php if($row["rolling"] >= 1):?>
                                    <td><?= getUser($row["rolling"]);?></td>
                                    <?php else:?>
                                    <td><?= getUser($row["user_id"]);?></td>
                                    <?php endif?>
                                    <td class="text-end"><?= Uang($row["total_harga"]);?></td>
                                    <td style="width: 10% !important;">
                                        <a type="button" class="btn btn-warning btn-sm"
                                            href="<?= base_url("admin/sales_menu/rolling_sales?tanggal=").$row["tanggal"]."&id=".$row["user_id"];?>"><i
                                                class="bx bx-edit"></i>
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hapus<?= $row["no_bukti"];?>"><i
                                                class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?= $row["no_bukti"];?>" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="<?= base_url("admin/dashboard/hapus2/").$row["no_bukti"];?>"
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
                                                                    id="no_dok" value="<?= $row["no_bukti"];?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal" value="<?= Tglindo($row["tanggal"]);?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Nominal</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal"
                                                                    value="<?= Uang($row["total_harga"]);?>" readonly>
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
                                <?php endforeach; ?>
                                <?php endif;?>
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
                                <?php if($pd != 0):?>
                                <?php
                                    $no = 1;
                                    foreach($pd as $row):
                                    ?>
                                <tr>
                                    <td style="width: 5% !important;"><?= $no++ ?></td>
                                    <td><?= $row["no_bukti"];?></td>
                                    <td><?= TglIndo($row["tanggal"]);?></td>
                                    <td><?= getOutlet2($row["user_id"]);?></td>
                                    <?php if($row["rolling"] >= 1):?>
                                    <td><?= getUser($row["rolling"]);?></td>
                                    <?php else:?>
                                    <td><?= getUser($row["user_id"]);?></td>
                                    <?php endif?>
                                    <td><?= getBarang($row["barang_id"]);?></td>
                                    <td class="text-end"><?= Uang($row["total"]);?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
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
                                <a href="<?= base_url("admin/dashboard/excel1/".$month."/".$year);?>"
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
                                foreach ($dapur as $dp):?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $dp["no_dok"];?></td>
                                    <td><?= Tglindo($dp["tanggal"]);?></td>
                                    <?php $userdp = $this->db->get_where("master_user", ["id" => $dp["user_id"]])->row_array();?>
                                    <?php if($dp["rolling"] >= 1):?>
                                    <td><?= getUser($dp["rolling"]);?></td>
                                    <?php else:?>
                                    <td><?= $userdp["nama"];?></td>
                                    <?php endif;?>
                                    <td class="text-end"><?= Uang($dp["total_nilai"]);?></td>
                                    <td class="text-end"><?= Uang(getTotalPembelian($dp["no_dok"]));?></td>
                                    <td class="text-end">
                                        <?= Uang($dp["total_nilai"] + getTotalPembelian($dp["no_dok"])) ;?>
                                    </td>
                                    <td>
                                        <?php if($dp["status"] == 0):?>
                                        <div class="badge bg-danger">Belum</div>
                                        <?php else:?>
                                        <div class="badge bg-success">Cek</div>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url("admin/dapur_menu/rolling_dapur?tanggal=").$dp["tanggal"]."&id=".$dp["user_id"]."&trx=".$dp["transaksi"];?>"
                                            class="btn btn-warning btn-sm"><i class="bx bx-edit"></i></a>
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hapus<?= $dp["no_dok"];?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?= $dp["no_dok"];?>" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="<?= base_url("admin/dashboard/hapus/").$dp["no_dok"];?>"
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
                                                                    id="no_dok" value="<?= $dp["no_dok"];?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal" value="<?= Tglindo($dp["tanggal"]);?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="username" class="form-label">Dapur</label>
                                                                <input type="text" class="form-control" name="username"
                                                                    id="username" value="<?= $userdp["username"];?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Total</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal"
                                                                    value="<?= Uang($dp["total_nilai"] + getTotalPembelian($dp["tanggal"], $dp["user_id"]));?>"
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
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>