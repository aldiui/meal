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
    $('#example50').DataTable({
        lengthMenu: [
            [50, 100, -1],
            [50, 100, 'All'],
        ],
    });
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
                <script>
$(".datepicker").pickadate({
        selectMonths: true,
        selectYears: true,
    }),
    $(".timepicker").pickatime();
$(function() {
    $("#date2").bootstrapMaterialDatePicker({
        time: false,
    });
});
                </script>
                <script src="<?= base_url();?>assets/js/main.js"></script>
                <script src="<?= base_url();?>assets/js/app.js"></script>
                </body>

                </html>