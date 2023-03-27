                </div>
                </div>
                <div class="overlay toggle-btn-mobile"></div>
                <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
                <div class="footer">
                    <p class="mb-0">Ginslah @<?= date("Y");?></p>
                </div>
                <!-- end footer -->
                </div>
                <script src="<?= base_url();?>assets/js/bootstrap.bundle.min.js"></script>
                <script src="<?= base_url();?>assets/plugins/simplebar/js/simplebar.min.js"></script>
                <script src="<?= base_url();?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
                <script src="<?= base_url();?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
                <script src="<?= base_url();?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
                <script>
$(document).ready(function() {
    var table = $("#dapurexample").DataTable();
    var table = $("#totalexample").DataTable();
});
                </script>
                <script src="<?= base_url() ?>assets/js/table.js"></script>
                <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/legacy.js"></script>
                <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/picker.js"></script>
                <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/picker.time.js"></script>
                <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/picker.date.js"></script>
                <script src="<?= base_url() ?>assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js">
                </script>
                <script
                    src="<?= base_url() ?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js">
                </script>
                <script src="<?= base_url();?>assets/js/main.js"></script>
                <script src="<?= base_url();?>assets/js/app.js"></script>
                <?php if($outlet != 0):?>
                <script src="<?= base_url() ?>assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
                <script>
var totalPenjualanAdmin = <?= json_encode(array_column($outlet, 'total_sales'));?>;
var totalPenjualanAdminHari = <?= json_encode(array_column($outlet, 'day'));?>;
var performaBarangAdmin = <?= json_encode($performaBarang);?>;
var performaSalesAdmin = <?= json_encode($perSalesOutlet);?>;
<?php
                $outlet = array_map(function ($x) {
                    return getOutlet($x);
                }, array_column($pemakaian, 'outlet_id'));
                    ;?>
var outlet = <?= json_encode($outlet);?>;
var pemakaianOutlet = <?= json_encode(array_column($pemakaian, 'pakai'));?>;
pemakaianOutlet = pemakaianOutlet.map(x => parseInt(x));
                </script>
                <script src="<?= base_url();?>assets/js/chartaadmin.js"></script>
                <?php endif;?>
                </body>

                </html>