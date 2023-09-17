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
                        <div class="text-center"><?php echo $title; ?> Periode <?php echo TglIndo($year.'-'.$month.'-'); ?></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="post">
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
        <div class="col-12">
            <form action="<?php echo base_url('admin/validasi_data/validasi'); ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="d-flex justify-content-between">
                                <div class="mt-1"><?php echo $title; ?></div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm">Validasi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="3%">No</th>
                                        <th>No Bukti</th>
                                        <th>Tanggal</th>
                                        <th>Outlet</th>
                                        <th>Sales</th>
                                        <th>Total Penjualan</th>
                                        <th>Total Biaya</th>
                                        <th>Total Nota</th>
                                        <th>Cek Data</th>
                                        <th>
                                            <div>
                                                <input type="checkbox" class="form-check-input mt-2 me-1"
                                                    onclick="validasi(this);">
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $no = 1;
                        foreach ($penjualan as $row) {
                            ?>
                                    <tr>
                                        <td style="width: 5% !important;"><?php echo $no++; ?></td>
                                        <td><?php echo $row['no_bukti']; ?></td>
                                        <td><?php echo TglIndo($row['tanggal']); ?></td>
                                        <td><?php echo getOutlet2($row['user_id']); ?></td>
                                        <?php if ($row['rolling'] > 1) { ?>
                                        <td><?php echo getUser($row['rolling']); ?></td>
                                        <?php } else { ?>
                                        <td><?php echo getUser($row['user_id']); ?></td>
                                        <?php }?>
                                        <td class="text-end"><?php echo Uang($row['total_harga']); ?></td>
                                        <td class="text-end">
                                            <?php echo Uang(getTotalPembiayaan($row['tanggal'], $row['user_id'])); ?></td>
                                        <td class="text-end">
                                            <?php echo Uang($row['total_harga'] - getTotalPembiayaan($row['tanggal'], $row['user_id'])); ?>
                                        </td>
                                        <td style="width: 10% !important;">
                                            <a type="button" class="btn btn-warning btn-sm"
                                                href="<?php echo base_url('admin/sales_menu/rolling_sales?tanggal=').$row['tanggal'].'&id='.$row['user_id']; ?>"><i
                                                    class="bx bx-detail"></i>
                                            </a>
                                        </td>
                                        <td><input type="checkbox" class="form-check-input" name="checkbox[]"
                                                value="<?php echo $row['no_bukti']; ?>"></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script>
function validasi(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
</script>