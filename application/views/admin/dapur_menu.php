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
                        <?php echo $title; ?> Dapur
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('admin/dapur_menu/filter'); ?>" method="post">
                        <div class="form-group mb-2">
                            <label for="dapur" class="form-label">Dapur</label>
                            <select name="dapur" class="form-control" id="akun_hpp" required>
                                <option value="">Pilih...</option>
                                <?php foreach ($dapur_admin as $dp) { ?>
                                    <option value="<?php echo $dp['id']; ?>"><?php echo $dp['username']; ?> - <?php echo $dp['nama']; ?></option>
                                <?php }?>
                            </select>
                            <?php echo form_error('akun_hpp', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Mulai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>