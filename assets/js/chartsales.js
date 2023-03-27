$(function() {
	"use strict";
	var options = {
		series: [{
			name: 'Total Penjualan',
			data: totalPenjualanSale
		}],
		chart: {
			foreColor: '#9ba7b2',
			height: 500,
			type: 'line',
			zoom: {
				enabled: false
			},
			toolbar: {
				show: true
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 14,
				blur: 4,
				opacity: 0.10,
			}
		},
		stroke: {
			width: 5,
			curve: 'smooth'
		},
		xaxis: {
			type: 'category',
			categories: totalPenjualanSalesHari,
			title: {
				text: 'Data Pertanggal',
			},
		},
		title: {
			text: 'Grafik Penjualan Perhari',
			align: 'left',
			style: {
				fontSize: "16px",
				color: '#666'
			}
		},
		colors: [
			"#673ab7",
		],
		yaxis: {
			title: {
				text: 'Total Penjualan Perhari',
			},
		}
	};
	var chart = new ApexCharts(document.querySelector("#cocoba"), options);
	chart.render();
	var optionsLine = {
		chart: {
			foreColor: '#9ba7b2',
			height: 500,
			type: 'line',
			zoom: {
				enabled: false
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 2,
				blur: 4,
				opacity: 0.1,
			}
		},
		stroke: {
			curve: 'smooth',
			width: 3
		},
		colors: ["#673ab7", '#f02769', '#32ab13', '#0d6efd', '#ffc107',' #20c997', '#343a40',  '#198754', '#fffa0a'],
		series: performaBarangSales,
		title: {
			text: 'Performa Penjualan Barang',
			align: 'left',
			style: {
				fontSize: "16px",
				color: '#666'
			}
		},
		markers: {
			size: 4,
			strokeWidth: 0,
			hover: {
				size: 7
			}
		},
		grid: {
			show: true,
			padding: {
				bottom: 0
			}
		},
		labels: totalPenjualanSalesHari,
		xaxis: {
			title: {
				text: 'Data Pertanggal',
			},
		},
		legend: {
			position: 'top',
		},
		yaxis: {
			title: {
				text: 'Total Penjualan Barang',
			},
		}
	}
	var chartLine = new ApexCharts(document.querySelector('#cocolong'), optionsLine);
	chartLine.render();
});