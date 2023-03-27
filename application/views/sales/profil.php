<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url("sales/dashboard");?>"><i class="bx bx-home-alt"></i></a>
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
                        <div class="mt-1"><?= $title;?></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url("sales/profil/edit");?>" method="post">
                        <input type="hidden" name="id" value="<?= $nickname["id"];?>">
                        <div class="form-group mb-2">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $nickname["nama"];?>" required>
                            <?= form_error("nama", '<small class="text-danger">', '</small>');?>
                        </div>
                        <div class="form-group mb-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= $nickname["username"];?>" required>
                            <?= form_error("username", '<small class="text-danger">', '</small>');?>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" value="<?= set_value("password");?>" placeholder="Kosongkan Jika Tidak Ingin Merubah Password ...">
                            <?= form_error("password", '<small class="text-danger">', '</small>');?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>