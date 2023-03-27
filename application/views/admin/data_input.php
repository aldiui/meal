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
                        <div class="text-center"><?= $title;?> Periode <?= TglIndo($year."-".$month."-");?></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url("admin/validasi_data/caridata");?>" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" class="form-control" id="bulan" required>
                                        <option value="">Pilih Bulan ...</option>
                                        <?php foreach($bulan as $b):?>
                                            <option value="<?= $b["no"];?>"><?= $b["nama"];?></option>
                                        <?php  endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" class="form-control" required>
                                        <option value="">Pilih Tahun ...</option>
                                        <?php foreach($tahun as $t):?>
                                            <option value="<?= $t;?>"><?= $t;?></option>
                                        <?php  endforeach;?>
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
                        <div><?= $title;?></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>Outlet</th>
                                    <th>Sales</th>
                                    <?php for ($i=1; $i <= $tanggal; $i++): ?>
                                        <th width="4%" class="text-center"><?php echo $i; ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    foreach ($user as $row) :
                                ?>  
                                    <?php if($row["outlet_id"]):?>
                                        <tr>
                                            <td style="width: 5% !important;"><?= $no++ ?></td>
                                            <td><?= getOutlet($row["outlet_id"]);?></td>
                                            <td><?= $row["nama"];?></td>
                                            <?php for ($i=1; $i <= $tanggal; $i++): ?>
                                                <?php 
                                                    $tanggal2 = date($year."-".$month."-".$i);
                                                    $cekdata = $this->db->get_where("sales_laporan", ["tanggal" => $tanggal2, "user_id" => $row["id"] ])->num_rows();
                                                ;?>
                                                <td>
                                                    <?php if(!$cekdata):?>
                                                        <div class="badge pt-1 bg-secondary"><i class="bx bx-radio-circle"></i></div>
                                                    <?php else:?>
                                                        <?php  
                                                            $cekdata2 = $this->db->get_where("sales_laporan", ["tanggal" => $tanggal2, "user_id" => $row["id"], "status" => 1 ])->num_rows();
                                                            if(!$cekdata2):
                                                        ?>
                                                            <div class="badge pt-1 bg-danger"><i class="bx bx-x"></i></div>
                                                        <?php else:?>
                                                            <div class="badge pt-1 bg-success"><i class="bx bx-check"></i></div>
                                                        <?php endif;?>
                                                    <?php endif;?>
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endif;?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>