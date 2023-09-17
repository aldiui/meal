<div class="wrapper">
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div class="">
                <img src="<?php echo base_url(); ?>assets/images/logo.webp" class="rounded" width="40" alt="" />
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
                <a href="<?php echo base_url('dapur/dashboard/'); ?>">
                    <div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="menu-label">Main Menu</li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon icon-color-2"><i class="bx bx-bookmark-alt"></i>
                    </div>
                    <div class="menu-title">Dapur Menu</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('dapur/dapur_menu'); ?>"><i class="bx bx-right-arrow-alt"></i>Input
                            Pengeluaran</a>
                    </li>
                    <?php if ($nickname['dapur'] == 0) { ?>
                    <li> <a href="<?php echo base_url('dapur/serah_terima'); ?>"><i class="bx bx-right-arrow-alt"></i>Serah
                            Terima</a>
                    </li>
                    <?php }?>
                </ul>
            </li>
        </ul>
    </div>