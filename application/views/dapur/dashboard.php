<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php echo $this->session->flashdata('pesan'); ?>
        </div>
        <?php if ($nickname['dapur'] == 0) { ?>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="text-center">History Pengeluaran Dapur Periode <?php echo TglIndo($year.'-'.$month.'-'); ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('dapur/dashboard/cari'); ?>" method="post">
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
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="mb-0 mt-1">History Data Pengeluaran Dapur</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 5% !important;">No</th>
                                    <th>No Dokumen</th>
                                    <th>Tanggal</th>
                                    <th>Dapur</th>
                                    <th>Pengeluaran</th>
                                    <th>Pembelian</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
            foreach ($dapur as $dp) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $dp['no_dok']; ?></td>
                                    <td><?php echo Tglindo($dp['tanggal']); ?></td>
                                    <?php $userdp = $this->db->get_where('master_user', ['id' => $dp['user_id']])->row_array(); ?>
                                    <?php if ($dp['rolling'] >= 1) { ?>
                                    <td><?php echo getUser($dp['rolling']); ?></td>
                                    <?php } else { ?>
                                    <td><?php echo $userdp['nama']; ?></td>
                                    <?php }?>
                                    <td class="text-end"><?php echo Uang($dp['total_nilai']); ?></td>
                                    <td class="text-end"><?php echo Uang(getTotalPembelian($dp['no_dok'])); ?></td>
                                    <td class="text-end">
                                        <?php echo Uang($dp['total_nilai'] + getTotalPembelian($dp['no_dok'])); ?>
                                    </td>
                                    <td>
                                        <?php if ($dp['status'] == 0) { ?>
                                        <div class="badge bg-danger">Belum</div>
                                        <?php } else { ?>
                                        <div class="badge bg-success">Cek</div>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('dapur/dapur_menu?tanggal=').$dp['tanggal'].'&trx='.$dp['transaksi']; ?>"
                                            class="btn btn-warning btn-sm"><i class="bx bx-edit"></i></a>
                                        <?php if ($dp['status'] == 0) { ?>
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hapus<?php echo $dp['no_dok']; ?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $dp['no_dok']; ?>" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="<?php echo base_url('dapur/dashboard/hapus/').$dp['no_dok']; ?>"
                                                        method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="no_dok" class="form-label">No
                                                                    Dokumentasi</label>
                                                                <input type="text" class="form-control" name="no_dok"
                                                                    id="no_dok" value="<?php echo $dp['no_dok']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal" value="<?php echo Tglindo($dp['tanggal']); ?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="username" class="form-label">Dapur</label>
                                                                <input type="text" class="form-control" name="username"
                                                                    id="username" value="<?php echo $userdp['username']; ?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal" class="form-label">Total</label>
                                                                <input type="text" class="form-control" name="tanggal"
                                                                    id="tanggal"
                                                                    value="<?php echo Uang($dp['total_nilai'] + getTotalPembelian($dp['tanggal'], $dp['user_id'])); ?>"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </td>

                                </tr>
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