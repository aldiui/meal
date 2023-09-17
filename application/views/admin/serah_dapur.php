<style>
input[type=number] {
    text-align: right;
}
</style>
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
                        <?php echo $title; ?>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('admin/serah_terima/filter'); ?>" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input class="result form-control" type="text" id="date" required
                                        placeholder="Tanggal..." name="tanggal" value="<?php echo $date; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class=" form-group mb-2">
                                    <label for="sales" class="form-label">Outlet</label>
                                    <select name="sales" class="form-control" id="sales" required>
                                        <option value="">Pilih...</option>
                                        <?php foreach ($sales as $s) { ?>
                                        <?php if ($s['outlet_id']) { ?>
                                        <?php if ($sales2 == $s['id']) { ?>
                                        <option value="<?php echo $s['id']; ?>" selected><?php echo getOutlet($s['outlet_id']); ?>
                                        </option>
                                        <?php } else { ?>
                                        <option value="<?php echo $s['id']; ?>"><?php echo getOutlet($s['outlet_id']); ?> -
                                            <?php echo $s['nama']; ?>
                                        </option>
                                        <?php }?>
                                        <?php }?>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Mulai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <?php if ($olah == 'null') { ?>
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                <div class="text-white">Maaf Data Serah Terima Yang Anda Cari Belum Terinput Di Sales Penjualan !!!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            <?php } elseif ($olah == 'input') { ?>
            <form action="<?php echo base_url('admin/serah_terima/tambah/'.$date.'/'.$sales2); ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Data <?php echo $title; ?></div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="tglserah" class="form-label">Tanggal Serah Terima</label>
                                    <input type="text" name="tglserah" id="date2" class="result form-control"
                                        value="<?php echo $date; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="outlet" class="form-label">Outlet</label>
                                    <input type="text" name="outlet" id="outlet" class="form-control"
                                        value="<?php echo getOutlet2($sales2); ?>" readonly>
                                </div>
                            </div>
                            <div class=" col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="jamdatang" class="form-label">Jam Datang</label>
                                    <input type="text" name="jamdatang" id="time" class="result form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="text" class="form-label">Sisa Bubur</label>
                                    <input type="text" style="text-align: right;" name="sisabubur" id="sisabubur"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="sisanasi" class="form-label">Sisa Nasi Tim</label>
                                    <input type="text" style="text-align: right;" name="sisanasi" id="sisanasi"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive mb-3">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="3%">#</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Qty Sisa</th>
                                                <th>Qty Cek</th>
                                                <th>Qty Selisih</th>
                                                <th>Qty Rusak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($this->input->get('tanggal') != null) { ?>
                                            <?php
                                    $no = 1;
                                                foreach ($sediaan as $s) { ?>
                                            <?php $barang = $this->db->get_where('barang_sediaan', ['id' => $s['sediaan_id']])->row_array(); ?>
                                            <?php $br = $this->db->get_where('master_barang', ['id' => $barang['barang_id']])->row_array(); ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $br['kode_barang']; ?></td>
                                                <td><?php echo $br['nama_barang']; ?></td>
                                                <td width="10%">
                                                    <input type="hidden" value="<?php echo $s['id_sad']; ?>" name="sediaan[]">
                                                    <input type="number" class="form-control"
                                                        id="qty_akhir<?php echo $barang['id']; ?>" readonly
                                                        value="<?php echo $s['qty_akhir']; ?>">
                                                </td>
                                                <td width="10%" class="text-end">
                                                    <input type="number" class="form-control" name="qty_cek[]"
                                                        id="qty_cek<?php echo $barang['id']; ?>" ,
                                                        oninput="hitungselisih(this.value, <?php echo $barang['id']; ?>)"
                                                        value="<?php echo $s['qty_akhir']; ?>">
                                                </td>
                                                <td width="10%" class="text-end">
                                                    <input type="number" class="form-control" name="qty_selisih[]"
                                                        id="qty_selisih<?php echo $barang['id']; ?>" readonly value="0">
                                                </td>
                                                <td width="10%" class="text-end">
                                                    <input type="number" class="form-control" name="qty_rusak[]">
                                                </td>
                                            </tr>
                                            <?php }?>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan"
                                        placeholder="Masukan Catatan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <script>
            function hitungselisih(value, id) {
                var qtysisa = $('#qty_akhir' + id).val();
                var selisih = qtysisa - value;
                $('#qty_selisih' + id).val(selisih);
            }
            </script>
            <?php } elseif ($olah == 'edit') { ?>
            <form action="<?php echo base_url('admin/serah_terima/edit/'.$date.'/'.$sales2); ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Data <?php echo $title; ?></div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="tglserah" class="form-label">Tanggal Serah Terima</label>
                                    <input type="text" name="tglserah" id="date2" class="result form-control"
                                        value="<?php echo $ds['tglserahterima']; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="outlet" class="form-label">Outlet</label>
                                    <input type="text" name="outlet" id="outlet" class="form-control"
                                        value="<?php echo getOutlet2($sales2); ?>" readonly>
                                </div>
                            </div>
                            <div class=" col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="jamdatang" class="form-label">Jam Datang</label>
                                    <input type="text" name="jamdatang" id="time" class="result form-control"
                                        value="<?php echo $ds['jamdatang']; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="sisabubur" class="form-label">Sisa Bubur</label>
                                    <input type="text" style="text-align: right;" name="sisabubur" id="sisabubur"
                                        class="form-control" value="<?php echo $ds['sisabubur']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label for="sisanasi" class="form-label">Sisa Nasi Tim</label>
                                    <input type="text" style="text-align: right;" name="sisanasi" id="sisanasi"
                                        class="form-control" value="<?php echo $ds['sisanasitim']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive mb-3">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="3%">#</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Qty Sisa</th>
                                                <th>Qty Cek</th>
                                                <th>Qty Selisih</th>
                                                <th>Qty Rusak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($this->input->get('tanggal') != null) { ?>
                                            <?php
                                    $no = 1;
                                                foreach ($sediaan as $s) { ?>
                                            <?php $barang = $this->db->get_where('barang_sediaan', ['id' => $s['sediaan_id']])->row_array(); ?>
                                            <?php $br = $this->db->get_where('master_barang', ['id' => $barang['barang_id']])->row_array(); ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $br['kode_barang']; ?></td>
                                                <td><?php echo $br['nama_barang']; ?></td>
                                                <td width="10%">
                                                    <input type="hidden" value="<?php echo $s['id_sad']; ?>" name="sediaan[]">
                                                    <input type="number" class="form-control"
                                                        id="qty_akhir<?php echo $barang['id']; ?>" readonly
                                                        value="<?php echo $s['qty_akhir']; ?>">
                                                </td>
                                                <td width="10%" class="text-end">
                                                    <input type="number" class="form-control" name="qty_cek[]"
                                                        id="qty_cek<?php echo $barang['id']; ?>" ,
                                                        oninput="hitungselisih(this.value, <?php echo $barang['id']; ?>)"
                                                        value="<?php echo $s['qty_cek']; ?>">
                                                </td>
                                                <td width="10%" class="text-end">
                                                    <input type="number" class="form-control" name="qty_selisih[]"
                                                        id="qty_selisih<?php echo $barang['id']; ?>"
                                                        value="<?php echo $s['qty_akhir'] - $s['qty_cek']; ?>" readonly>
                                                </td>
                                                <td width="10%" class="text-end">
                                                    <input type="number" class="form-control" name="qty_rusak[]"
                                                        value="<?php echo $s['qty_rusak']; ?>">
                                                </td>
                                            </tr>
                                            <?php }?>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan"
                                        placeholder="Masukan Catatan" rows="3"><?php echo $ds['catatan']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
            <script>
            function hitungselisih(value, id) {
                var qtysisa = $('#qty_akhir' + id).val();
                var selisih = qtysisa - value;
                $('#qty_selisih' + id).val(selisih);
            }
            </script>
            <?php }?>
        </div>
    </div>
</div>