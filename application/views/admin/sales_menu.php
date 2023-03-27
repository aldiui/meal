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
                        <?= $title;?> Sales
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url("admin/sales_menu/filter");?>" method="post">
                        <div class="form-group mb-2">
                            <label for="sales" class="form-label">Outlet</label>
                            <select name="sales" class="form-control" id="sales" required>
                                <option value="">Pilih...</option>
                                <?php foreach($sales as $s):?>
                                    <?php if($s["outlet_id"]):?>
                                        <option value="<?= $s["id"];?>"><?= getOutlet($s["outlet_id"]);?> - <?= $s["nama"];?> </option>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>