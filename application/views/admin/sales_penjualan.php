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
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                        foreach ($sp as $s) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $s['kode_barang']; ?></td>
                                    <td><?php echo $s['nama_barang']; ?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $s['id']; ?>"><i class="bx bx-edit"></i></a>
                                        <div class="modal fade" id="edit<?php echo $s['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/sales_penjualan/edit'); ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Edit Data <?php echo $title; ?> ?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" value="<?php echo $s['kode_barang']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                                                <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="<?php echo $s['nama_barang']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="sediann" class="form-label">Sales Sediaan</label>
                                                                <select name="sediaan" class="form-control" id="sediaan">
                                                                <option value="">Kosongkan ...</option>
                                                                    <?php foreach ($penjualan as $p) { ?>
                                                                        <?php if ($p['id'] == $s['sediaan_id']) { ?>
                                                                            <option value="<?php echo $p['id']; ?>" selected><?php echo getBarang($p['barang_id']); ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="sediaan2" class="form-label">Sediaan 2</label>
                                                                    <select name="sediaan2" class="form-control" id="sediaan2">
                                                                    <option value="">Kosongkan ...</option>
                                                                        <?php foreach ($penjualan as $p) { ?>
                                                                            <?php if ($p['id'] == $s['sediaan2']) { ?>
                                                                                <option value="<?php echo $p['id']; ?>" selected><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="qty2" class="form-label">Qty 2</label>
                                                                    <input type="number" name="qty2" class="form-control" value="<?php echo $s['qty2']; ?>">
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="sediaan3" class="form-label">Sediaan 3</label>
                                                                    <select name="sediaan3" class="form-control" id="sediaan3">
                                                                    <option value="">Kosongkan ...</option>
                                                                        <?php foreach ($penjualan as $p) { ?>
                                                                            <?php if ($p['id'] == $s['sediaan3']) { ?>
                                                                                <option value="<?php echo $p['id']; ?>" selected><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="qty3" class="form-label">Qty 3</label>
                                                                    <input type="number" name="qty3" class="form-control" value="<?php echo $s['qty3']; ?>">
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="sediaan4" class="form-label">Sediaan 4</label>
                                                                    <select name="sediaan4" class="form-control" id="sediaan4">
                                                                    <option value="">Kosongkan ...</option>
                                                                        <?php foreach ($penjualan as $p) { ?>
                                                                            <?php if ($p['id'] == $s['sediaan4']) { ?>
                                                                                <option value="<?php echo $p['id']; ?>" selected><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="qty4" class="form-label">Qty 4</label>
                                                                    <input type="number" name="qty4" class="form-control" value="<?php echo $s['qty4']; ?>">
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="sediaan5" class="form-label">Sediaan 5</label>
                                                                    <select name="sediaan5" class="form-control" id="sediaan5">
                                                                    <option value="">Kosongkan ...</option>
                                                                        <?php foreach ($penjualan as $p) { ?>
                                                                            <?php if ($p['id'] == $s['sediaan5']) { ?>
                                                                                <option value="<?php echo $p['id']; ?>" selected><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="qty5" class="form-label">Qty 5</label>
                                                                    <input type="number" name="qty5" class="form-control" value="<?php echo $s['qty5']; ?>">
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="sediaan6" class="form-label">Sediaan 6</label>
                                                                    <select name="sediaan6" class="form-control" id="sediaan6">
                                                                    <option value="">Kosongkan ...</option>
                                                                        <?php foreach ($penjualan as $p) { ?>
                                                                            <?php if ($p['id'] == $s['sediaan6']) { ?>
                                                                                <option value="<?php echo $p['id']; ?>" selected><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="qty6" class="form-label">Qty 6</label>
                                                                    <input type="number" name="qty6" class="form-control" value="<?php echo $s['qty6']; ?>">
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="sediaan7" class="form-label">Sediaan 7</label>
                                                                    <select name="sediaan7" class="form-control" id="sediaan7">
                                                                    <option value="">Kosongkan ...</option>
                                                                        <?php foreach ($penjualan as $p) { ?>
                                                                            <?php if ($p['id'] == $s['sediaan7']) { ?>
                                                                                <option value="<?php echo $p['id']; ?>" selected><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <label for="qty7" class="form-label">Qty 7</label>
                                                                    <input type="number" name="qty7" class="form-control" value="<?php echo $s['qty7']; ?>">
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
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $s['id']; ?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $s['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/sales_penjualan/delete/').$s['barang_id']; ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data <?php echo $title; ?> ?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" value="<?php echo $s['kode_barang']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                                                <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="<?php echo $s['nama_barang']; ?>" readonly>
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
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form action="<?php echo base_url('admin/sales_penjualan/tambah'); ?>" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <table class="table table-bordered table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" classa="form-check-input" onclick="toggle(this);"></th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Sales Sediaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            $sediaan = $this->db->get('sales_penjualan')->result_array();
                        $kode = [];
                        foreach ($sediaan as $row) {
                            array_push($kode, [
                                'barang_id' => $row['barang_id'],
                            ]);
                        }
                        foreach ($kode as $row) {
                            $this->db->where_not_in('id', $row);
                        }
                        $a = $this->db->get('master_barang')->result_array();
                        foreach ($a as $row) {
                            ?>
                                        <tr>
                                            <td><input type="checkbox" classa="form-check-input" name="checkbox[]" value="<?php echo $row['id']; ?>"></td>
                                            <td><?php echo $row['kode_barang']; ?></td>
                                            <td><?php echo $row['nama_barang']; ?></td>
                                            <td>
                                                <select name="sediaan[]" class="form-control">
                                                    <option value="">Kosongkan ...</option>
                                                    <?php foreach ($penjualan as $p) { ?>
                                                        <option value="<?php echo $p['id']; ?>"><?php echo getBarang($p['barang_id']); ?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
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
<script>
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
</script>