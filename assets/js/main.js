$(".datepicker").pickadate({
	selectMonths: true,
	selectYears: true,
}),
	$(".timepicker").pickatime();
$(function () {
	$("#date-time").bootstrapMaterialDatePicker({
		format: "YYYY-MM-DD HH:mm",
	});
	$("#date").bootstrapMaterialDatePicker({
		time: false,
	});
	$("#date2").bootstrapMaterialDatePicker({
		time: false,
	});
	$("#time").bootstrapMaterialDatePicker({
		date: false,
		format: "HH:mm",
	});
});

function satuana(value) {
	$("#aqty2").html(value);
	$("#aqty3").html(value);
	$("#aqty4").html(value);
	$("#aqty5").html(value);
}

function satuanu(value, data) {
	$("#uqty2" + data).html(value);
	$("#uqty3" + data).html(value);
	$("#uqty4" + data).html(value);
	$("#uqty5" + data).html(value);
}

function FormatRupiah(nilai) {
	return new Intl.NumberFormat("id-ID", {
		style: "currency",
		currency: "IDR",
	}).format(nilai);
}


