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
                        <div class="text-center"><?= $title;?> Periode <?= TglIndo($year."-".$month."-");?></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url("dapur/serah_terima/cari");?>" method="post">
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
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="d-flex justify-content-between">
                            <div class="mt-1"><?= $title;?></div>
                            <div>
                                <a href="<?= base_url("dapur/serah_terima/excel/").$month."/".$year;?>"
                                    class="btn btn-primary btn-sm">Cetak Laporan</a>
                                <a href="<?= base_url("dapur/serah_terima/filter");?>"
                                    class="btn btn-primary btn-sm">Tambah</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example50" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>No Bukti</th>
                                    <th>Tangal Serah Terima</th>
                                    <th>Jam Datang</th>
                                    <th>Outlet</th>
                                    <th>Sales</th>
                                    <th>Dapur</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($ds as $row):?>
                                <?php if($row["dapur_id"] != 0):?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $row["no_bukti"];?></td>
                                    <td><?= tglindo($row["tglserahterima"]);?></td>
                                    <td><?= $row["jamdatang"];?></td>
                                    <td><?= getOutlet2($row["user_id"]);?></td>
                                    <td><?= getUser($row["user_id"]);?></td>
                                    <td><?= getUser($row["dapur_id"]);?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm"
                                            href="<?= base_url("dapur/serah_terima/filter?tanggal=").$row["tanggal"]."&sales=".$row["user_id"];?>"><i
                                                class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php else:?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $row["no_bukti"];?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= getOutlet2($row["user_id"]);?></td>
                                    <td><?= getUser($row["user_id"]);?></td>
                                    <td></td>
                                    <td>
                                        <a type="button" class="btn btn-primary btn-sm"
                                            href="<?= base_url("dapur/serah_terima/filter?tanggal=").$row["tanggal"]."&sales=".$row["user_id"];?>"><i
                                                class="bx bx-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endif;?>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>