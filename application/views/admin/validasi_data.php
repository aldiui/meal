<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url("admin/dashboard");?>"><i class="bx bx-home-alt"></i></a>
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
                        <div class="text-center"><?= $title;?> Periode <?= TglIndo($year."-".$month."-");?></div>
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
        <div class="col-12">
            <form action="<?= base_url('admin/validasi_data/validasi')?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="d-flex justify-content-between">
                                <div class="mt-1"><?= $title;?></div>
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
                                            foreach ($penjualan as $row) :
                                        ?>
                                    <tr>
                                        <td style="width: 5% !important;"><?= $no++ ?></td>
                                        <td><?= $row["no_bukti"];?></td>
                                        <td><?= TglIndo($row["tanggal"]);?></td>
                                        <td><?= getOutlet2($row["user_id"]);?></td>
                                        <?php if($row["rolling"] > 1):?>
                                        <td><?= getUser($row["rolling"]);?></td>
                                        <?php else:?>
                                        <td><?= getUser($row["user_id"]);?></td>
                                        <?php endif?>
                                        <td class="text-end"><?= Uang($row["total_harga"]);?></td>
                                        <td class="text-end">
                                            <?= Uang(getTotalPembiayaan($row["tanggal"], $row["user_id"]));?></td>
                                        <td class="text-end">
                                            <?= Uang($row["total_harga"] - getTotalPembiayaan($row["tanggal"], $row["user_id"]));?>
                                        </td>
                                        <td style="width: 10% !important;">
                                            <a type="button" class="btn btn-warning btn-sm"
                                                href="<?= base_url("admin/sales_menu/rolling_sales?tanggal=").$row["tanggal"]."&id=".$row["user_id"];?>"><i
                                                    class="bx bx-detail"></i>
                                            </a>
                                        </td>
                                        <td><input type="checkbox" class="form-check-input" name="checkbox[]"
                                                value="<?= $row["no_bukti"];?>"></td>
                                    </tr>
                                    <?php endforeach; ?>
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