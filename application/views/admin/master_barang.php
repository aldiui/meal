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
                                    <th>Kategori Barang</th>
                                    <th>Satuan Utama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                        foreach ($barang as $b) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $b['kode_barang']; ?></td>
                                    <td><?php echo $b['nama_barang']; ?></td>
                                    <td><?php echo getKategori($b['kategori_id']); ?></td>
                                    <td><?php echo $b['satuan_utama']; ?></td>
                                    <td>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $b['id']; ?>"> 
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <div class="modal fade" id="edit<?php echo $b['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/master_barang/edit'); ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_barang1" class="form-label">Kode Barang</label>
                                                                <input type="text" class="form-control" name="kode_barang1" id="kode_barang1" value="<?php echo $b['kode_barang']; ?>" required>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_barang1" class="form-label">Nama Barang</label>
                                                                <input type="text" class="form-control" name="nama_barang1" id="nama_barang1" value="<?php echo $b['nama_barang']; ?>" required>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="kategori_barang1" class="form-label">Kategori Barang</label>
                                                                <select name="kategori_barang1" class="form-control" id="kategori_barang1" required>
                                                                    <?php foreach ($kategori as $k) { ?>
                                                                        <?php if ($k['id'] == $b['kategori_id']) { ?>
                                                                            <option value="<?php echo $k['id']; ?>" selected><?php echo $k['kode_kategori']; ?> - <?php echo $k['nama_kategori']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $k['id']; ?>"><?php echo $k['kode_kategori']; ?> - <?php echo $k['nama_kategori']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="satuan_utama1" class="form-label">Satuan Utama</label>
                                                                <input type="text" placeholder="pcs" class="form-control" oninput="satuanu(this.value, <?php echo $b['id']; ?>)" name="satuan_utama1" id="satuan_utama1" value="<?php echo $b['satuan_utama']; ?>" required>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_kedua1" class="form-label">Satuan Kedua</label>
                                                                        <input type="text" placeholder="Lusin" class="form-control" name="satuan_kedua1" value="<?php echo $b['satuan_kedua']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_kedua1" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_kedua1" class="form-control" value="<?php echo $b['qty_kedua']; ?>">
                                                                            <span class="input-group-text" id="uqty2<?php echo $b['id']; ?>"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_ketiga1" class="form-label">Satuan Ketiga</label>
                                                                        <input type="text" placeholder="Dos" class="form-control" name="satuan_ketiga1" value="<?php echo $b['satuan_ketiga']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_ketiga1" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_ketiga1" class="form-control" value="<?php echo $b['qty_ketiga']; ?>">
                                                                            <span class="input-group-text" id="uqty3<?php echo $b['id']; ?>"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_keempat1" class="form-label">Satuan Keempat</label>
                                                                        <input type="text" placeholder="" class="form-control" name="satuan_keempat1" value="<?php echo $b['satuan_keempat']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_keempat1" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_keempat1"  class="form-control" value="<?php echo $b['qty_keempat']; ?>">
                                                                            <span class="input-group-text" id="uqty4<?php echo $b['id']; ?>"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_kelima1" class="form-label">Satuan Kelima</label>
                                                                        <input type="text" placeholder="" class="form-control" name="satuan_kelima1" value="<?php echo $b['satuan_kelima']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_kelima1" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_kelima1" class="form-control" id="qty_kelima1" value="<?php echo $b['qty_kelima']; ?>">
                                                                            <span class="input-group-text" id="uqty5<?php echo $b['id']; ?>"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="harga1" class="form-label">Input Harga</label>
                                                                        <input type="number" class="form-control" id="harga1" min="1" name="harga1" value="<?php echo $b['harga']; ?>">
                                                                    </div>
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
                                        <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $b['id']; ?>"><i class="bx bx-trash"></i></a>
                                        <div class="modal fade" id="hapus<?php echo $b['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url('admin/master_barang/delete/').$b['id']; ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" value="<?php echo $b['kode_barang']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                                                <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="<?php echo $b['nama_barang']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="kategori_barang" class="form-label">Kategori Barang</label>
                                                                <select name="kategori_barang" class="form-control" id="kategori_barang" readonly>
                                                                    <?php foreach ($kategori as $k) { ?>
                                                                        <?php if ($k['id'] == $b['kategori_id']) { ?>
                                                                            <option value="<?php echo $k['id']; ?>" selected><?php echo $k['kode_kategori']; ?> - <?php echo $k['nama_kategori']; ?></option>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="satuan_utama" class="form-label">Satuan Utama</label>
                                                                <input type="text" placeholder="pcs" class="form-control" name="satuan_utama" id="satuan_utama" value="<?php echo $b['satuan_utama']; ?>" readonly>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_kedua" class="form-label">Satuan Kedua</label>
                                                                        <input type="text" placeholder="Lusin" class="form-control" name="satuan_kedua" id="satuan_kedua" value="<?php echo $b['satuan_kedua']; ?>" readonly>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_kedua" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_kedua" class="form-control" value="<?php echo $b['qty_kedua']; ?>" readonly>
                                                                            <span class="input-group-text"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_ketiga" class="form-label">Satuan Ketiga</label>
                                                                        <input type="text" placeholder="Dos" class="form-control" name="satuan_ketiga" id="satuan_ketiga" value="<?php echo $b['satuan_ketiga']; ?>" readonly>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_ketiga" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_ketiga" class="form-control" value="<?php echo $b['qty_ketiga']; ?>" readonly>
                                                                            <span class="input-group-text"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_keempat" class="form-label">Satuan Keempat</label>
                                                                        <input type="text" placeholder="" class="form-control" name="satuan_keempat" id="satuan_keempat" value="<?php echo $b['satuan_keempat']; ?>" readonly>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_keempat" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_keempat" class="form-control" value="<?php echo $b['qty_keempat']; ?>" readonly>
                                                                            <span class="input-group-text"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="satuan_kelima" class="form-label">Satuan Kelima</label>
                                                                        <input type="text" placeholder="" class="form-control" name="satuan_kelima" id="satuan_kelima" value="<?php echo $b['satuan_kelima']; ?>" readonly>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <label for="qty_kelima" class="form-label">Qty</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="qty_kelima" class="form-control" value="<?php echo $b['qty_kelima']; ?>" readonly>
                                                                            <span class="input-group-text"><?php echo $b['satuan_utama']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="harga" class="form-label">Input Harga</label>
                                                                        <input type="number" class="form-control" id="harga" min="1" name="harga" value="<?php echo $b['harga']; ?>" readonly/>
                                                                    </div>
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
                                <h5 class="modal-title" id="modal-title">Tambah Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label for="kode_barang" class="form-label">Kode Barang</label>
                                    <input type="text" class="form-control" name="kode_barang" required id="kode_barang" value="<?php echo set_value('kode_barang'); ?>">
                                    <?php echo form_error('kode_barang', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang" required id="nama_barang" value="<?php echo set_value('nama_barang'); ?>">
                                    <?php echo form_error('nama_barang', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="kategori_barang" class="form-label">Kategori Barang</label>
                                    <select name="kategori_barang" required class="form-control" id="kategori_barang">
                                        <option value="">Pilih...</option>
                                        <?php foreach ($kategori as $k) { ?>
                                            <option value="<?php echo $k['id']; ?>"><?php echo $k['kode_kategori']; ?> - <?php echo $k['nama_kategori']; ?></option>
                                        <?php }?>
                                    </select>
                                    <?php echo form_error('kategori_barang', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="satuan_utama" class="form-label">Satuan Utama</label>
                                    <input type="text" placeholder="pcs" class="form-control" oninput="satuana(this.value)" name="satuan_utama" id="satuan_utama" required value="<?php echo set_value('satuan_utama'); ?>">
                                    <?php echo form_error('satuan_utama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="satuan_kedua" class="form-label">Satuan Kedua</label>
                                            <input type="text" placeholder="Lusin" class="form-control" name="satuan_kedua" id="satuan_kedua" value="<?php echo set_value('satuan_kedua'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="qty_kedua" class="form-label">Qty</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_kedua" class="form-control" value="<?php echo set_value('qty_kedua'); ?>">
                                                <span class="input-group-text" id="aqty2"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="satuan_ketiga" class="form-label">Satuan Ketiga</label>
                                            <input type="text" placeholder="Dos" class="form-control" name="satuan_ketiga" id="satuan_ketiga" value="<?php echo set_value('satuan_ketiga'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="qty_ketiga" class="form-label">Qty</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_ketiga" class="form-control" value="<?php echo set_value('qty_ketiga'); ?>">
                                                <span class="input-group-text" id="aqty3"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="satuan_keempat" class="form-label">Satuan Keempat</label>
                                            <input type="text" placeholder="" class="form-control" name="satuan_keempat" id="satuan_keempat" value="<?php echo set_value('satuan_keempat'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="qty_keempat" class="form-label">Qty</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_keempat" class="form-control" value="<?php echo set_value('qty_keempat'); ?>">
                                                <span class="input-group-text" id="aqty4"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="satuan_kelima" class="form-label">Satuan Kelima</label>
                                            <input type="text" placeholder="" class="form-control" name="satuan_kelima" id="satuan_kelima" value="<?php echo set_value('satuan_kelima'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="qty_kelima" class="form-label">Qty</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_kelima" class="form-control" value="<?php echo set_value('qty_kelima'); ?>">
                                                <span class="input-group-text" id="aqty5"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="harga" class="form-label">Input Harga</label>
                                            <input type="number" class="form-control" id="harga" min="1" name="harga" value="<?php echo set_value('harga'); ?>" required/>
                                            <?php echo form_error('harga', '<small class="text-danger">', '</small>'); ?>
                                        </div>
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