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
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Tipe Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($akuntansi as $a):?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $a["kode_akun"];?></td>
                                    <td><?= $a["nama_akun"];?></td>
                                    <td><?= $a["tipe_akun"];?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $a["id"];?>"> 
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <div class="modal fade" id="edit<?= $a["id"];?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?= base_url("admin/master_akuntansi/edit");?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?= $a["id"];?>">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_akun1" class="form-label">Kode Akun</label>
                                                                <input type="text" class="form-control" name="kode_akun1" id="kode_akun1" value="<?= $a["kode_akun"];?>" required>
                                                                <?= form_error("kode_akun1", '<small class="text-danger">', '</small>');?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_akun1" class="form-label">Nama Akun</label>
                                                                <input type="text" class="form-control" name="nama_akun1" id="nama_akun1" value="<?= $a["nama_akun"];?>" required>
                                                                <?= form_error("nama_akun1", '<small class="text-danger">', '</small>');?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tipe_akun1" class="form-label">Tipe Akun</label>
                                                                <select name="tipe_akun1" class="form-control" id="tipe_akun1" required>
                                                                    <?php foreach($tipe as $t):?>
                                                                        <?php if($t == $a["tipe_akun"]):?>
                                                                            <option value="<?= $t;?>" selected><?= $t;?></option>
                                                                        <?php else:?>
                                                                            <option value="<?= $t;?>"><?= $t;?></option>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                                </select>
                                                                <?= form_error("tipe_akun1", '<small class="text-danger">', '</small>');?>
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
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?= $a["id"];?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?= $a["id"];?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?= base_url("admin/master_akuntansi/delete/").$a["id"];?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_akun" class="form-label">Kode Akun</label>
                                                                <input type="text" class="form-control" name="kode_akun" id="kode_akun" value="<?= $a["kode_akun"];?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_akun" class="form-label">Nama Akun</label>
                                                                <input type="text" class="form-control" name="nama_akun" id="nama_akun" value="<?= $a["nama_akun"];?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tipe_akun" class="form-label">Tipe Akun</label>
                                                                <select name="tipe_akun" class="form-control" id="tipe_akun" readonly>
                                                                    <?php foreach($tipe as $t):?>
                                                                        <?php if($t == $a["tipe_akun"]):?>
                                                                            <option value="<?= $t;?>" selected><?= $t;?></option>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                                </select>
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
                                    <label for="kode_akun" class="form-label">Kode Akun</label>
                                    <input type="text" class="form-control" name="kode_akun" id="kode_akun" value="<?= set_value("kode_akun");?>" required>
                                    <?= form_error("kode_akun", '<small class="text-danger">', '</small>');?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nama_akun" class="form-label">Nama Akun</label>
                                    <input type="text" class="form-control" name="nama_akun" id="nama_akun" value="<?= set_value("nama_akun");?>" required>
                                    <?= form_error("nama_akun", '<small class="text-danger">', '</small>');?>
                                </div>
                                <div class="form-group">
                                    <label for="tipe_akun" class="form-label">Tipe Akun</label>
                                    <select name="tipe_akun" class="form-control" id="tipe_akun" required>
                                        <option value="">Pilih...</option>
                                        <?php foreach($tipe as $t):?>
                                            <option value="<?= $t;?>"><?= $t;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?= form_error("tipe_akun", '<small class="text-danger">', '</small>');?>
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