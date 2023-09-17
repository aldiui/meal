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
                        foreach ($sediaan as $s) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $s['kode_barang']; ?></td>
                                    <td><?php echo $s['nama_barang']; ?></td>
                                    <td>
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $s['id']; ?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $s['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/master_template/delete/').$s['barang_id']; ?>" method="post">
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
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="<?php echo base_url('admin/master_template/tambah'); ?>" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <table class="table table-bordered table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input" onclick="toggle(this);"></th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            $sediaan = $this->db->get('barang_sediaan')->result_array();
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
                                            <td><input type="checkbox" class="form-check-input" name="checkbox[]" value="<?php echo $row['id']; ?>"></td>
                                            <td><?php echo $row['kode_barang']; ?></td>
                                            <td><?php echo $row['nama_barang']; ?></td>
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