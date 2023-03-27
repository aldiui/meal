$(document).ready(function () {
	$("#example").DataTable();
	var table = $("#example2").DataTable({
		lengthChange: false,
		buttons: ["copy", "excel", "pdf", "print", "colvis"],
	});
	table.buttons().container().appendTo("#example2_wrapper .col-md-6:eq(0)");
	var table = $("#totalPenjualan").DataTable();
	var table = $("#example4").DataTable();
	var table = $("#dapurexample").DataTable();
});
