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
                        <div class="d-flex justify-content-between">
                            <div class="mt-1"><?php echo $title; ?></div>
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
                                    <th>Kode Biaya</th>
                                    <th>Nama Biaya</th>
                                    <th>Jenis Biaya</th>
                                    <th>Tipe Pengeluaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                        foreach ($akuntansi as $a) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $a['kode_biaya']; ?></td>
                                    <td><?php echo $a['nama_biaya']; ?></td>
                                    <td>
                                        <?php if ($a['jenis_biaya'] == 1) { ?>
                                            <div class="badge bg-primary">Rutin</div>
                                        <?php } else { ?>
                                            <div class="badge bg-secondary">Lain lain</div>
                                        <?php }?>
                                    </td>
                                    <td><?php echo getAkun($a['akun_id']); ?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $a['id_biaya']; ?>"> 
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <div class="modal fade" id="edit<?php echo $a['id_biaya']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/dapur_biaya/edit'); ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $a['id_biaya']; ?>">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_biaya1" class="form-label">Kode Biaya</label>
                                                                <input type="text" class="form-control" name="kode_biaya1" id="kode_biaya1" value="<?php echo $a['kode_biaya']; ?>" required>
                                                                <?php echo form_error('kode_biaya1', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_biaya1" class="form-label">Nama Biaya</label>
                                                                <input type="text" class="form-control" name="nama_biaya1" id="nama_biaya1" value="<?php echo $a['nama_biaya']; ?>" required>
                                                                <?php echo form_error('nama_biaya1', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="jenis_biaya1" class="form-label">Jenis Biaya</label>
                                                                <select name="jenis_biaya1" class="form-control" id="jenis_biaya1">
                                                                    <?php foreach ($jenis as $j) { ?>
                                                                        <?php if ($j['no'] == $a['jenis_biaya']) { ?>
                                                                            <option value="<?php echo $j['no']; ?>" selected><?php echo $j['jenis']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $j['no']; ?>"><?php echo $j['jenis']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                                <?php echo form_error('jenis_biaya1', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tipe_akun1" class="form-label">Tipe Pengeluaran</label>
                                                                <select name="tipe_akun1" class="form-control" id="tipe_akun1" required>
                                                                    <?php foreach ($tipe as $t) { ?>
                                                                        <?php if ($t['id'] == $a['akun_id']) { ?>
                                                                            <option value="<?php echo $t['id']; ?>" selected><?php echo $t['kode_akun']; ?> - <?php echo $t['nama_akun']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $t['id']; ?>"><?php echo $t['kode_akun']; ?> - <?php echo $t['nama_akun']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                                <?php echo form_error('tipe_akun1', '<small class="text-danger">', '</small>'); ?>
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
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $a['id_biaya']; ?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $a['id_biaya']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/dapur_biaya/delete/').$a['id_biaya']; ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_biaya" class="form-label">Kode Akun</label>
                                                                <input type="text" class="form-control" name="kode_biaya" id="kode_biaya" value="<?php echo $a['kode_biaya']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_biaya" class="form-label">Nama Akun</label>
                                                                <input type="text" class="form-control" name="nama_biaya" id="nama_biaya" value="<?php echo $a['nama_biaya']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="jenis_biaya" class="form-label">Jenis Biaya</label>
                                                                <select name="jenis_biaya" class="form-control" id="jenis_biaya" readonly>
                                                                    <?php foreach ($jenis as $j) { ?>
                                                                        <?php if ($j['no'] == $a['jenis_biaya']) { ?>
                                                                            <option value="<?php echo $j['no']; ?>" selected><?php echo $j['jenis']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tipe_akun" class="form-label">Tipe Akun</label>
                                                                <select name="tipe_akun" class="form-control" id="tipe_akun" readonly>
                                                                    <?php foreach ($tipe as $t) { ?>
                                                                        <?php if ($t['id'] == $a['akun_id']) { ?>
                                                                            <option value="<?php echo $t['id']; ?>" selected><?php echo $t['kode_akun']; ?> - <?php echo $t['nama_akun']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
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
                                <?php }?>
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
                                    <label for="kode_biaya" class="form-label">Kode Biaya</label>
                                    <input type="text" class="form-control" name="kode_biaya" id="kode_biaya" value="<?php echo set_value('kode_biaya'); ?>" required>
                                    <?php echo form_error('kode_biaya', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nama_biaya" class="form-label">Nama Biaya</label>
                                    <input type="text" class="form-control" name="nama_biaya" id="nama_biaya" value="<?php echo set_value('nama_biaya'); ?>" required>
                                    <?php echo form_error('nama_biaya', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_biaya" class="form-label">Jenis Biaya</label>
                                    <select name="jenis_biaya" class="form-control" id="jenis_biaya" required>
                                        <option value="">Pilih...</option>
                                        <?php foreach ($jenis as $j) { ?>
                                            <option value="<?php echo $j['no']; ?>"><?php echo $j['jenis']; ?></option>
                                        <?php }?>
                                    </select>
                                    <?php echo form_error('jenis_biaya', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="tipe_akun" class="form-label">Tipe Biaya</label>
                                    <select name="tipe_akun" class="form-control" id="tipe_akun" required>
                                        <option value="">Pilih...</option>
                                        <?php foreach ($tipe as $t) { ?>
                                            <option value="<?php echo $t['id']; ?>"><?php echo $t['kode_akun']; ?> - <?php echo $t['nama_akun']; ?></option>
                                        <?php }?>
                                    </select>
                                    <?php echo form_error('tipe_akun', '<small class="text-danger">', '</small>'); ?>
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