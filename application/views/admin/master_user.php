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
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Outlet</th>
                                    <th>Role</th>
                                    <th>Status Rolling</th>
                                    <th>Status Dapur</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                        foreach ($user as $u) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $u['nama']; ?></td>
                                    <td><?php echo $u['username']; ?></td>
                                    <td><?php echo getOutlet($u['outlet_id']); ?></td>
                                    <td><?php echo $u['role']; ?></td>
                                    <td>
                                        <?php if ($u['rolling'] == '1') { ?>
                                            <div class="badge bg-success">Aktif</div>
                                        <?php } elseif ($u['rolling'] == '0' or $u['rolling'] == null) { ?>
                                            <div class="badge bg-danger">Non Aktif</div>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($u['dapur'] == '1') { ?>
                                            <div class="badge bg-success">Aktif</div>
                                        <?php } elseif ($u['dapur'] == '0' or $u['dapur'] == null) { ?>
                                            <div class="badge bg-danger">Non Aktif</div>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $u['id']; ?>"> 
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <div class="modal fade" id="edit<?php echo $u['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/master_user/edit'); ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                                            <div class="form-group mb-2">
                                                                <label for="nama1" class="form-label">Nama</label>
                                                                <input type="text" class="form-control" name="nama1" id="nama1" value="<?php echo $u['nama']; ?>" required>
                                                                <?php echo form_error('nama1', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="username1" class="form-label">Username</label>
                                                                <input type="text" class="form-control" name="username1" id="username1" value="<?php echo $u['username']; ?>" required>
                                                                <?php echo form_error('username1', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="password1" class="form-label">Password</label>
                                                                <input type="password" class="form-control" name="password1" id="password1" value="<?php echo set_value('password'); ?>" placeholder="Kosongkan Jika Tidak Ingin Merubah Password ...">
                                                                <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="outlet1" class="form-label">Outlet</label>
                                                                <select name="outlet1" class="form-control" id="outlet1">
                                                                    <option value="">Kosongkan</option>
                                                                    <?php foreach ($outlet as $o) { ?>
                                                                        <?php if ($o['id'] == $u['outlet_id']) { ?>
                                                                            <option value="<?php echo $o['id']; ?>" selected><?php echo $o['kode_outlet']; ?> - <?php echo $o['nama_outlet']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $o['id']; ?>"><?php echo $o['kode_outlet']; ?> - <?php echo $o['nama_outlet']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                                <?php echo form_error('outlet1', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="role1" class="form-label">Role</label>
                                                                <select name="role1" class="form-control" id="role1" required>
                                                                    <?php foreach ($role as $r) { ?>
                                                                        <?php if ($r == $u['role']) { ?>
                                                                            <option value="<?php echo $r; ?>" selected><?php echo $r; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $r; ?>"><?php echo $r; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                                <?php echo form_error('role1', '<small class="text-danger">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="form-check">
                                                                    <?php if ($u['rolling'] == '1') { ?>
                                                                        <input class="form-check-input" name="rolling1" value="1" type="checkbox" id="rolling<?php echo $u['id']; ?>" checked>
                                                                    <?php } else { ?>
                                                                        <input class="form-check-input" name="rolling1" value="1" type="checkbox" id="rolling<?php echo $u['id']; ?>">
                                                                    <?php }?>
                                                                    <label class="form-check-label" for="rolling<?php echo $u['id']; ?>">Status Rolling</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <?php if ($u['dapur'] == '1') { ?>
                                                                        <input class="form-check-input" name="dapur1" value="1" type="checkbox" id="dapur<?php echo $u['id']; ?>" checked>
                                                                    <?php } else { ?>
                                                                        <input class="form-check-input" name="dapur1" value="1" type="checkbox" id="dapur<?php echo $u['id']; ?>">
                                                                    <?php }?>
                                                                    <label class="form-check-label" for="dapur<?php echo $u['id']; ?>">Status Dapur</label>
                                                                </div>
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
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $u['id']; ?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $u['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/master_user/delete/').$u['id']; ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Delete User</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="nama" class="form-label">Nama</label>
                                                                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $u['nama']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="username" class="form-label">Username</label>
                                                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $u['username']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="outlet" class="form-label">Outlet</label>
                                                                <select name="outlet" class="form-control" id="outlet" readonly>
                                                                    <?php foreach ($outlet as $o) { ?>
                                                                        <?php if ($o['id'] == $u['outlet_id']) { ?>
                                                                            <option value="<?php echo $o['id']; ?>" selected><?php echo $o['kode_outlet']; ?> - <?php echo $o['nama_outlet']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="role" class="form-label">Role</label>
                                                                <select name="role" class="form-control" id="role" readonly>
                                                                    <?php foreach ($role as $r) { ?>
                                                                        <?php if ($r == $u['role']) { ?>
                                                                            <option value="<?php echo $r; ?>" selected><?php echo $r; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="form-check">
                                                                    <?php if ($u['rolling'] == 1) { ?>
                                                                        <input class="form-check-input" name="rolling" type="checkbox" id="rolling" checked disabled>
                                                                    <?php } else { ?>
                                                                        <input class="form-check-input" name="rolling" type="checkbox" id="rolling" disabled>
                                                                    <?php }?>
                                                                    <label class="form-check-label" for="rolling">Status Rolling</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <?php if ($u['dapur'] == 1) { ?>
                                                                        <input class="form-check-input" name="dapur" type="checkbox" id="dapur" checked disabled>
                                                                    <?php } else { ?>
                                                                        <input class="form-check-input" name="dapur" type="checkbox" id="dapur" disabled>
                                                                    <?php }?>
                                                                    <label class="form-check-label" for="dapur">Status Dapur</label>
                                                                </div>
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
                                <h5 class="modal-title" id="modal-title">Tambah User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo set_value('nama'); ?>" required>
                                    <?php echo form_error('nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username'); ?>" required>
                                    <?php echo form_error('username', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>" required>
                                    <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="outlet" class="form-label">Outlet</label>
                                    <select name="outlet" class="form-control" id="outlet">
                                        <option value="">Kosongkan</option>
                                        <?php foreach ($outlet as $o) { ?>
                                            <option value="<?php echo $o['id']; ?>"><?php echo $o['kode_outlet']; ?> - <?php echo $o['nama_outlet']; ?></option>
                                        <?php }?>
                                    </select>
                                    <?php echo form_error('outlet', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" class="form-control" id="role" required>
                                        <option value="">Pilih...</option>
                                        <?php foreach ($role as $r) { ?>
                                            <option value="<?php echo $r; ?>"><?php echo $r; ?></option>
                                        <?php }?>
                                    </select>
                                    <?php echo form_error('role', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" name="rolling" type="checkbox" id="rolling" value="1">
                                        <label class="form-check-label" for="rolling">Status Rolling</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" name="dapur" type="checkbox" id="dapur" value="1">
                                        <label class="form-check-label" for="dapur">Status Dapur</label>
                                    </div>
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