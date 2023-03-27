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
                                    <th>Kode Kategori</th>
                                    <th>Nama Kategori</th>
                                    <th>Akun Sediaan</th>
                                    <th>Akun HPP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($kategori as $k):?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $k["kode_kategori"];?></td>
                                    <td><?= $k["nama_kategori"];?></td>
                                    <td><?= getAkun($k["akun_id"]);?></td>
                                    <td><?= getAkun($k["akun_hpp"]);?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $k["id"];?>"> 
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <div class="modal fade" id="edit<?= $k["id"];?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?= base_url("admin/master_kategori/edit");?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?= $k["id"];?>">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_kategori1" class="form-label">Kode Kategori</label>
                                                                <input type="text" class="form-control" name="kode_kategori1" id="kode_kategori1" value="<?= $k["kode_kategori"];?>" required>
                                                                <?= form_error("kode_kategori1", '<small class="text-danger">', '</small>');?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_kategori1" class="form-label">Nama Kategori</label>
                                                                <input type="text" class="form-control" name="nama_kategori1" id="nama_kategori1" value="<?= $k["nama_kategori"];?>" required>
                                                                <?= form_error("nama_kategori1", '<small class="text-danger">', '</small>');?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="akun1" class="form-label">Akun HPP</label>
                                                                <select name="akun1" class="form-control" id="akun1" required>
                                                                    <?php foreach($akun as $a):?>
                                                                        <?php if($a["id"] == $k["akun_id"]):?>
                                                                            <option value="<?= $a["id"];?>" selected><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                                                        <?php else: ?>
                                                                            <option value="<?= $a["id"];?>"><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach;?>
                                                                </select>
                                                                <?= form_error("akun1", '<small class="text-danger">', '</small>');?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="akun_hpp1" class="form-label">Akun HPP</label>
                                                                <select name="akun_hpp1" class="form-control" id="akun_hpp1" required>
                                                                    <?php foreach($akun as $a):?>
                                                                        <?php if($a["id"] == $k["akun_hpp"]):?>
                                                                            <option value="<?= $a["id"];?>" selected><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                                                        <?php else: ?>
                                                                            <option value="<?= $a["id"];?>"><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach;?>
                                                                </select>
                                                                <?= form_error("akun_hpp1", '<small class="text-danger">', '</small>');?>
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
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?= $k["id"];?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?= $k["id"];?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?= base_url("admin/master_kategori/delete/").$k["id"];?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_kategori" class="form-label">Kode Akun</label>
                                                                <input type="text" class="form-control" name="kode_kategori" id="kode_kategori" value="<?= $k["kode_kategori"];?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_kategori" class="form-label">Nama Akun</label>
                                                                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="<?= $k["nama_kategori"];?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="akun" class="form-label">Akun HPP</label>
                                                                <select name="akun" class="form-control" id="akun3" readonly>
                                                                    <?php foreach($akun as $a):?>
                                                                        <?php if($a["id"] == $k["akun_id"]):?>
                                                                            <option value="<?= $a["id"];?>" selected><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="akun_hpp" class="form-label">Akun HPP</label>
                                                                <select name="akun_hpp" class="form-control" id="akun_hpp" readonly>
                                                                    <?php foreach($akun as $a):?>
                                                                        <?php if($a["id"] == $k["akun_hpp"]):?>
                                                                            <option value="<?= $a["id"];?>" selected><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                                                        <?php endif; ?>
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
                                    <label for="kode_kategori" class="form-label">Kode Kategori</label>
                                    <input type="text" class="form-control" name="kode_kategori" id="kode_kategori" value="<?= set_value("kode_kategori");?>" required>
                                    <?= form_error("kode_kategori", '<small class="text-danger">', '</small>');?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="<?= set_value("nama_kategori");?>" required>
                                    <?= form_error("nama_kategori", '<small class="text-danger">', '</small>');?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="akun" class="form-label">Akun Sediaan</label>
                                    <select name="akun" class="form-control" id="akun" required>
                                        <option value="">Pilih...</option>
                                        <?php foreach($akun as $a):?>
                                            <option value="<?= $a["id"];?>"><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                        <?php endforeach;?>
                                    </select>
                                    <?= form_error("akun", '<small class="text-danger">', '</small>');?>
                                </div>
                                <div class="form-group">
                                    <label for="akun_hpp" class="form-label">Akun HPP</label>
                                    <select name="akun_hpp" class="form-control" id="akun_hpp" required>
                                        <option value="">Pilih...</option>
                                        <?php foreach($akun as $a):?>
                                            <option value="<?= $a["id"];?>"><?= $a["kode_akun"];?> - <?= $a["nama_akun"];?> </option>
                                        <?php endforeach;?>
                                    </select>
                                    <?= form_error("akun_hpp", '<small class="text-danger">', '</small>');?>
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