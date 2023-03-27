<div class="wrapper">
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div class="">
                <img src="<?= base_url();?>assets/images/logo.webp" class="rounded" width="40" alt="" />
            </div>
            <div>
                <h4 class="logo-text fw-bold">Little Meal</h4>
            </div>
            <a href="javascript:;" class="toggle-btn ms-auto"> <i class="bx bx-menu"></i>
            </a>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="<?= base_url('admin/dashboard/') ?>">
                    <div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="menu-label">Master</li>
            <li>
                <a href="<?= base_url('admin/master_outlet') ?>">
                    <div class="parent-icon icon-color-3"><i class="bx bx-id-card"></i>
                    </div>
                    <div class="menu-title">Master Outlet</div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/master_user') ?>">
                    <div class="parent-icon icon-color-2"><i class="bx bx-user"></i>
                    </div>
                    <div class="menu-title">Master User</div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/master_akuntansi') ?>">
                    <div class="parent-icon icon-color-4"><i class="bx bx-credit-card"></i>
                    </div>
                    <div class="menu-title">Master Akuntansi</div>
                </a>
            </li>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon icon-color-6"><i class='bx bx-store'></i>
                    </div>
                    <div class="menu-title">Master Barang</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('admin/master_kategori') ?>"><i
                                class="bx bx-right-arrow-alt"></i>Kategori Barang</a>
                    </li>
                    <li> <a href="<?= base_url('admin/master_barang') ?>"><i
                                class="bx bx-right-arrow-alt"></i>Barang</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon icon-color-7"><i class='bx bxs-user-badge'></i>
                    </div>
                    <div class="menu-title">Master Template</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('admin/master_template') ?>"><i class="bx bx-right-arrow-alt"></i>Sales -
                            Sediaan</a>
                    </li>
                    <li> <a href="<?= base_url('admin/sales_penjualan') ?>"><i class="bx bx-right-arrow-alt"></i>Sales -
                            Penjualan</a>
                    </li>
                    <li> <a href="<?= base_url('admin/sales_pengeluaran') ?>"><i class="bx bx-right-arrow-alt"></i>Sales
                            - Pengeluaran</a>
                    </li>
                    <li> <a href="<?= base_url('admin/dapur_biaya') ?>"><i class="bx bx-right-arrow-alt"></i>Dapur -
                            Biaya</a>
                    </li>
                </ul>
            </li>
            <li class="menu-label">Main Menu</li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon icon-color-3"><i class="bx bx-cart-alt"></i>
                    </div>
                    <div class="menu-title">Sales Menu</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('admin/sales_menu') ?>"><i class="bx bx-right-arrow-alt"></i>Input
                            Penjualan</a>
                    </li>
                    <li> <a href="<?= base_url('admin/validasi_data/data') ?>"><i class="bx bx-right-arrow-alt"></i>Lap
                            Input Data</a>
                    </li>
                    <li> <a href="<?= base_url('admin/validasi_data') ?>"><i class="bx bx-right-arrow-alt"></i>Validasi
                            Data</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon icon-color-2"><i class="bx bx-bookmark-alt"></i>
                    </div>
                    <div class="menu-title">Dapur Menu</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('admin/dapur_menu') ?>"><i class="bx bx-right-arrow-alt"></i>Input
                            Pengeluaran</a>
                    </li>
                    <li> <a href="<?= base_url('admin/validasi_data/dapur') ?>"><i
                                class="bx bx-right-arrow-alt"></i>Validasi Data</a>
                    </li>
                    <li> <a href="<?= base_url('admin/serah_terima') ?>"><i class="bx bx-right-arrow-alt"></i>Serah
                            Terima</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>