$(function () {
	"use strict";
	var options = {
		series: [
			{
				name: "Total Penjualan",
				data: totalPenjualanAdmin,
			},
		],
		chart: {
			foreColor: "#9ba7b2",
			height: 500,
			type: "line",
			zoom: {
				enabled: false,
			},
			toolbar: {
				show: true,
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 14,
				blur: 4,
				opacity: 0.1,
			},
		},
		stroke: {
			width: 5,
			curve: "smooth",
		},
		xaxis: {
			type: "category",
			categories: totalPenjualanAdminHari,
			title: {
				text: "Data Pertanggal",
			},
		},
		title: {
			text: "Grafik Penjualan Global",
			align: "left",
			style: {
				fontSize: "16px",
				color: "#666",
			},
		},
		colors: [
			"#673ab7",
		],
		yaxis: {
			title: {
				text: "Total Penjualan Perhari",
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#diagram1"), options);
	chart.render();
	var optionsLine = {
		chart: {
			foreColor: "#9ba7b2",
			height: 500,
			type: "line",
			zoom: {
				enabled: false,
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 2,
				blur: 4,
				opacity: 0.1,
			},
		},
		stroke: {
			curve: "smooth",
			width: 3,
		},
		colors: [
			"#673ab7",
			"#f02769",
			"#32ab13",
			"#0d6efd",
			"#ffc107",
			" #20c997",
			"#343a40",
			"#198754",
			"#fffa0a",
		],
		series: performaSalesAdmin,
		title: {
			text: "Grafik Penjualan Semua Outlet",
			align: "left",
			style: {
				fontSize: "16px",
				color: "#666",
			},
		},
		markers: {
			size: 4,
			strokeWidth: 0,
			hover: {
				size: 7,
			},
		},
		grid: {
			show: true,
			padding: {
				bottom: 0,
			},
		},
		labels: totalPenjualanAdminHari,
		xaxis: {
			title: {
				text: "Data Pertanggal",
			},
		},
		legend: {
			position: "top",
		},
		yaxis: {
			title: {
				text: "Total Penjualan Barang",
			},
		},
	};
	var chartLine = new ApexCharts(
		document.querySelector("#diagram2"),
		optionsLine
	);
	chartLine.render();
	var optionsLine = {
		chart: {
			foreColor: "#9ba7b2",
			height: 500,
			type: "line",
			zoom: {
				enabled: false,
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 2,
				blur: 4,
				opacity: 0.1,
			},
		},
		stroke: {
			curve: "smooth",
			width: 3,
		},
		colors: [
			"#673ab7",
			"#f02769",
			"#32ab13",
			"#0d6efd",
			"#ffc107",
			" #20c997",
			"#343a40",
			"#198754",
			"#fffa0a",
		],
		series: performaBarangAdmin,
		title: {
			text: "Performa Penjualan Barang",
			align: "left",
			style: {
				fontSize: "16px",
				color: "#666",
			},
		},
		markers: {
			size: 4,
			strokeWidth: 0,
			hover: {
				size: 7,
			},
		},
		grid: {
			show: true,
			padding: {
				bottom: 0,
			},
		},
		labels: totalPenjualanAdminHari,
		xaxis: {
			title: {
				text: "Data Pertanggal",
			},
		},
		legend: {
			position: "top",
		},
		yaxis: {
			title: {
				text: "Total Penjualan Barang",
			},
		},
	};
	var chartLine = new ApexCharts(
		document.querySelector("#diagram3"),
		optionsLine
	);
	chartLine.render();

	var options = {
		chart: {
			width: '100%',
			height: '500',
			type: "pie",
		},
		title: {
			text: "Performa Penjualan Outlet",
			align: "left",
			style: {
				fontSize: "16px",
				color: "#666",
			},
		},
		colors: ["#673ab7", "#32ab13", "#f02769", "#ffc107", "#198fed"],
		series: pemakaianOutlet,
		labels: outlet,
		responsive: [
			{
				breakpoint: 480,
				options: {
					chart: {
						height: 360,
					},
					legend: {
						position: "bottom",
					},
				},
			},
		],
	};
	var chart = new ApexCharts(document.querySelector("#diagram4"), options);
	chart.render();
});
