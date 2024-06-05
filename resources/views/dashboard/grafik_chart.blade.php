@can('Grafik Chart Penjualan')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <div class="row">
                    <div class="col-lg-12">
                        <canvas id="dailyProfitChart" height="100px" style="height: 150px;"></canvas>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endcan
@can('Grafik Chart Penjualan')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <div class="row">
                    <div class="col-lg-12">
                        <canvas id="monthlyProfitChart" height="100px" style="height: 150px;"></canvas>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endcan
@push('scripts')
    <script>
        var dailyProfitData = @json($dailyProfits);
        var totalSalesData = @json($totalSalesPerDay);
        var monthlyProfitData = @json($monthlyProfits);
        var totalSalesPerMonthData = @json($totalSalesPerMonth);

        // Fungsi untuk mengonversi nomor bulan menjadi nama bulan
        function getNamaBulan(nomorBulan) {
            const namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            return namaBulan[nomorBulan - 1];
        }

        // Grafik Laba Harian
        var dailyProfitChart = new Chart(document.getElementById("dailyProfitChart"), {
            type: 'line',
            data: {
                labels: Object.keys(dailyProfitData),
                datasets: [{
                    label: 'Laba Harian',
                    data: Object.values(dailyProfitData),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }, {
                    label: 'Total Penjualan Harian',
                    data: Object.values(totalSalesData),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Rupiah'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    }
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                }
            }
        });

        // Grafik Laba Bulanan
        var monthlyProfitChart = new Chart(document.getElementById("monthlyProfitChart"), {
            type: 'line',
            data: {
                labels: Object.keys(monthlyProfitData).map(nomorBulan => getNamaBulan(parseInt(nomorBulan))),
                datasets: [{
                    label: 'Laba Bulanan',
                    data: Object.values(monthlyProfitData),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Total Penjualan Bulanan',
                    data: Object.values(totalSalesPerMonthData),
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                pointDot: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Rupiah'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                }
            }
        });
    </script>
@endpush
