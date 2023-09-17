<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php echo $this->session->flashdata('pesan'); ?>
        </div>
        <?php if ($nickname['outlet_id']) { ?>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="text-center"><?php echo $title; ?> Periode <?php echo TglIndo($year.'-'.$month.'-'); ?></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('sales/dashboard/caridata'); ?>" method="post">
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
                    <div id="cocoba"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="cocolong"></div>
                </div>
            </div>
        </div>
        <?php }?>
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
                        History Data Penjualan
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
                                    <th>Action</th>
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
                                    <td><?php echo getOutlet($nickname['outlet_id']); ?></td>
                                    <?php if ($row['rolling'] >= 1) { ?>
                                    <td><?php echo getUser($row['rolling']); ?></td>
                                    <?php } else { ?>
                                    <td><?php echo getUser($row['user_id']); ?></td>
                                    <?php }?>
                                    <td class="text-end"><?php echo Uang($row['total_harga']); ?></td>
                                    <td style="width: 10% !important;"><a type="button" class="btn btn-warning btn-sm"
                                            href="<?php echo base_url('sales/sales_menu?tanggal=').$row['tanggal']; ?>"><i
                                                class="bx bx-edit"></i></td>
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
                                    <td><?php echo getOutlet($nickname['outlet_id']); ?></td>
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
        <?php }?>
    </div>
</div>