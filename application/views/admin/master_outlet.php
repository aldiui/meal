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
                        <div class="d-flex justify-content-between">
                            <div class="mt-1"><?= $title;?></div>
                            <div>
                                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</a>
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
                                    <th>Kode Outlet</th>
                                    <th>Nama Outlet</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($outlet as $o):?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $o["kode_outlet"];?></td>
                                    <td><?= $o["nama_outlet"];?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $o["id"];?>"> 
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <div class="modal fade" id="edit<?= $o["id"];?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?= base_url("admin/master_outlet/edit");?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?= $o["id"];?>">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_outlet1" class="form-label">Kode Outlet</label>
                                                                <input type="text" class="form-control" name="kode_outlet1" id="kode_outlet1" value="<?= $o["kode_outlet"];?>" required>
                                                                <?= form_error("kode_outlet1", '<small class="text-danger">', '</small>');?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_outlet1" class="form-label">Nama Outlet</label>
                                                                <input type="text" class="form-control" name="nama_outlet1" id="nama_outlet1" value="<?= $o["nama_outlet"];?>" required>
                                                                <?= form_error("nama_outlet1", '<small class="text-danger">', '</small>');?>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?= $o["id"];?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?= $o["id"];?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?= base_url("admin/master_outlet/delete/").$o["id"];?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_outlet" class="form-label">Kode Outlet</label>
                                                                <input type="text" class="form-control" name="kode_outlet" id="kode_outlet" value="<?= $o["kode_outlet"];?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_outlet" class="form-label">Nama Outlet</label>
                                                                <input type="text" class="form-control" name="nama_outlet" id="nama_outlet" value="<?= $o["nama_outlet"];?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
            <div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label for="kode_outlet" class="form-label">Kode Outlet</label>
                                    <input type="text" class="form-control" name="kode_outlet" id="kode_outlet" value="<?= set_value("kode_outlet");?>" required>
                                    <?= form_error("kode_outlet", '<small class="text-danger">', '</small>');?>
                                </div>
                                <div class="form-group">
                                    <label for="nama_outlet" class="form-label">Nama Outlet</label>
                                    <input type="text" class="form-control" name="nama_outlet" id="nama_outlet" value="<?= set_value("nama_outlet");?>" required>
                                    <?= form_error("nama_outlet", '<small class="text-danger">', '</small>');?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
