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
                    <form action="<?php echo base_url('admin/serah_terima/cari'); ?>" method="post">
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
                        <div class="d-flex justify-content-between">
                            <div class="mt-1"><?php echo $title; ?></div>
                            <div>
                                <a href="<?php echo base_url('admin/serah_terima/filter'); ?>"
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
                        foreach ($ds as $row) { ?>
                                <?php if ($row['dapur_id'] != 0) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['no_bukti']; ?></td>
                                    <td><?php echo tglindo($row['tglserahterima']); ?></td>
                                    <td><?php echo $row['jamdatang']; ?></td>
                                    <td><?php echo getOutlet2($row['user_id']); ?></td>
                                    <td><?php echo getUser($row['user_id']); ?></td>
                                    <td><?php echo getUser($row['dapur_id']); ?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm"
                                            href="<?php echo base_url('admin/serah_terima/filter?tanggal=').$row['tanggal'].'&sales='.$row['user_id']; ?>"><i
                                                class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } else { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['no_bukti']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo getOutlet2($row['user_id']); ?></td>
                                    <td><?php echo getUser($row['user_id']); ?></td>
                                    <td></td>
                                    <td>
                                        <a type="button" class="btn btn-primary btn-sm"
                                            href="<?php echo base_url('admin/serah_terima/filter?tanggal=').$row['tanggal'].'&sales='.$row['user_id']; ?>"><i
                                                class="bx bx-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>