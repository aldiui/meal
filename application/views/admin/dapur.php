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
                    <form action="<?php echo base_url('admin/validasi_data/caridpr'); ?>" method="post">
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
            <form action="<?php echo base_url('admin/validasi_data/validasidpr'); ?>" method="post">
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
                                        <th>Dapur</th>
                                        <th>Pengeluaran</th>
                                        <th>Pembelian</th>
                                        <th>Total</th>
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
                        foreach ($dapur as $row) {
                            ?>
                                    <tr>
                                        <td style="width: 5% !important;"><?php echo $no++; ?></td>
                                        <td><?php echo $row['no_dok']; ?></td>
                                        <td><?php echo TglIndo($row['tanggal']); ?></td>
                                        <td><?php echo getUser($row['user_id']); ?></td>
                                        <td class="text-end"><?php echo Uang($row['total_nilai']); ?></td>
                                        <td class="text-end"><?php echo Uang(getTotalPembelian($row['no_dok'])); ?></td>
                                        <td class="text-end">
                                            <?php echo Uang($row['total_nilai'] + getTotalPembelian($row['no_dok'])); ?></td>
                                        <td style="width: 10% !important;"><a type="button"
                                                class="btn btn-warning btn-sm"
                                                href="<?php echo base_url('admin/dapur_menu/rolling_dapur?tanggal=').$row['tanggal'].'&id='.$row['user_id'].'&trx='.$row['transaksi']; ?>"><i
                                                    class="bx bx-detail"></i></td>
                                        <td><input type="checkbox" class="form-check-input" name="checkbox[]"
                                                value="<?php echo $row['no_dok']; ?>"></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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