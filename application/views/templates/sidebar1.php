<div class="wrapper">
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div class="">
                <img src="<?= base_url();?>assets/images/logo.webp" class="rounded" width="40" alt=""/>
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
                <a href="<?= base_url('sales/dashboard/') ?>">
                    <div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="menu-label">Main Menu</li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon icon-color-3"><i class="bx bx-cart-alt"></i>
                    </div>
                    <div class="menu-title">Sales Menu</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('sales/sales_menu') ?>"><i class="bx bx-right-arrow-alt"></i>Input Penjualan</a>
                    </li>
                    <li> <a href="<?= base_url('sales/validasi_data/data') ?>"><i class="bx bx-right-arrow-alt"></i>Lap Data Input</a>
                </ul>
            </li>
        </ul>
    </div>
		