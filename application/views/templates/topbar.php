<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="left-topbar d-flex align-items-center">
            <a href="javascript:;" class="toggle-btn">	<i class="bx bx-menu"></i>
            </a>
        </div>
        <div class="right-topbar ms-auto">
            <ul class="navbar-nav">
                <li class="nav-item dropdown dropdown-user-profile">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                        <div class="d-flex user-box align-items-center">
                            <div class="user-info">
                                <?php if($nickname["role"] == "Admin"):?>
                                    <p class="designattion mb-0 text-dark"><?= $nickname["nama"];?></p>
                                    <p class="designattion mb-0"><?= $nickname["role"];?></p>
                                <?php elseif($nickname["role"] == "Dapur"):?>
                                    <p class="designattion mb-0 text-dark"><?= $nickname["nama"];?></p>
                                    <p class="designattion mb-0"><?= $nickname["role"];?></p>
                                <?php elseif($nickname["role"] == "Sales"):?>
                                    <p class="designattion mb-0 text-dark"><?= $nickname["nama"];?></p>
                                    <p class="designattion mb-0"><?= getOutlet($nickname["outlet_id"]);?></p>
                                <?php endif;?>
                            </div>
                            <div class="py-1 px-2 rounded bg-primary bg-opacity-50"><i class="bx text-white bx-user"></i></div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <?php if($nickname["role"] == "Admin"):?>
                        <?php elseif($nickname["role"] == "Dapur"):?>
                            <a class="dropdown-item" href="<?= base_url("dapur/profil");?>"><i class="bx bx-user"></i><span>Profile</span></a>
                        <?php elseif($nickname["role"] == "Sales"):?>
                            <a class="dropdown-item" href="<?= base_url("sales/profil");?>"><i class="bx bx-user"></i><span>Profile</span></a>
                        <?php endif;?>	
                        <a class="dropdown-item" href="<?= base_url("auth/logout");?>">
                            <i class="bx bx-power-off"></i><span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
