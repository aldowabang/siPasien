


        <div class="az-footer ht-40 fixed-bottom">
        <div class="container ht-100p pd-t-0-f">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020 || Power By Nbxx {{ date('Y') }}</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
        </div><!-- container -->
        </div><!-- az-footer -->



        {{-- <script src="{{ asset('Azia/lib/jquery/jquery.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('Azia/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Azia/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('Azia/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('Azia/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('Azia/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('Azia/lib/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('Azia/js/azia.js') }}"></script>
    <script src="{{ asset('Azia/js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('Azia/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('Azia/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Silahkan Pilih",
                    allowClear: true
                });
            });
        </script>
        <script>
                new DataTable('#example'
                    , {
                    responsive: true,
                    perPage: 5,
                    perPageSelect: [5, 10, 20, 50],
                    labels: {
                        placeholder: "Cari...",
                        perPage: "{select} baris per halaman",
                        noRows: "Tidak ada data yang ditemukan",
                        info: "Menampilkan {start} sampai {end} dari {rows} baris"
                    }

                });
                    </script>

                @session('success')
                <script>
                        Swal.fire({
                        title: "Good job!",
                        text: "{{ session('success') }}",
                        icon: "success"
                        });
                    </script>
                @endsession
                @session('error')
                    <script>
                        Swal.fire({
                        title: "Oops!",
                        text: "{{ session('error') }}",
                        icon: "error"
                        });
                    </script>
                @endsession
        <script>
        $(function(){
            'use strict'

                var plot = $.plot('#flotChart', [{
            data: flotSampleData3,
            color: '#007bff',
            lines: {
                fillColor: { colors: [{ opacity: 0 }, { opacity: 0.2 }]}
            }
            },{
            data: flotSampleData4,
            color: '#560bd0',
            lines: {
                fillColor: { colors: [{ opacity: 0 }, { opacity: 0.2 }]}
            }
            }], {
                    series: {
                        shadowSize: 0,
                lines: {
                show: true,
                lineWidth: 2,
                fill: true
                }
                    },
            grid: {
                borderWidth: 0,
                labelMargin: 8
            },
                    yaxis: {
                show: true,
                        min: 0,
                        max: 100,
                ticks: [[0,''],[20,'20K'],[40,'40K'],[60,'60K'],[80,'80K']],
                tickColor: '#eee'
                    },
                    xaxis: {
                show: true,
                color: '#fff',
                ticks: [[25,'OCT 21'],[75,'OCT 22'],[100,'OCT 23'],[125,'OCT 24']],
            }
            });

            $.plot('#flotChart1', [{
            data: dashData2,
            color: '#00cccc'
            }], {
                    series: {
                        shadowSize: 0,
                lines: {
                show: true,
                lineWidth: 2,
                fill: true,
                fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.2 } ] }
                }
                    },
            grid: {
                borderWidth: 0,
                labelMargin: 0
            },
                    yaxis: {
                show: false,
                min: 0,
                max: 35
            },
                    xaxis: {
                show: false,
                max: 50
            }
                });

            $.plot('#flotChart2', [{
            data: dashData2,
            color: '#007bff'
            }], {
                    series: {
                        shadowSize: 0,
                bars: {
                show: true,
                lineWidth: 0,
                fill: 1,
                barWidth: .5
                }
                    },
            grid: {
                borderWidth: 0,
                labelMargin: 0
            },
                    yaxis: {
                show: false,
                min: 0,
                max: 35
            },
                    xaxis: {
                show: false,
                max: 20
            }
                });


            //-------------------------------------------------------------//


            // Line chart
            $('.peity-line').peity('line');

            // Bar charts
            $('.peity-bar').peity('bar');

            // Bar charts
            $('.peity-donut').peity('donut');

            var ctx5 = document.getElementById('chartBar5').getContext('2d');
            new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: [0,1,2,3,4,5,6,7],
                datasets: [{
                data: [2, 4, 10, 20, 45, 40, 35, 18],
                backgroundColor: '#560bd0'
                }, {
                data: [3, 6, 15, 35, 50, 45, 35, 25],
                backgroundColor: '#cad0e8'
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                enabled: false
                },
                legend: {
                display: false,
                    labels: {
                    display: false
                    }
                },
                scales: {
                yAxes: [{
                    display: false,
                    ticks: {
                    beginAtZero:true,
                    fontSize: 11,
                    max: 80
                    }
                }],
                xAxes: [{
                    barPercentage: 0.6,
                    gridLines: {
                    color: 'rgba(0,0,0,0.08)'
                    },
                    ticks: {
                    beginAtZero:true,
                    fontSize: 11,
                    display: false
                    }
                }]
                }
            }
            });

            // Donut Chart
            var datapie = {
            labels: ['Search', 'Email', 'Referral', 'Social', 'Other'],
            datasets: [{
                data: [25,20,30,15,10],
                backgroundColor: ['#6f42c1', '#007bff','#17a2b8','#00cccc','#adb2bd']
            }]
            };

            var optionpie = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
            };

            // For a doughnut chart
            var ctxpie= document.getElementById('chartDonut');
            var myPieChart6 = new Chart(ctxpie, {
            type: 'doughnut',
            data: datapie,
            options: optionpie
            });

        });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const forms = document.querySelectorAll(".form-hapus-proyek");

                forms.forEach(form => {
                    form.addEventListener("submit", function (e) {
                        e.preventDefault(); // Cegah submit langsung

                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
                const forms = document.querySelectorAll(".form-hapus-dokument");
                forms.forEach(form => {
                    form.addEventListener("submit", function (e) {
                        e.preventDefault(); // Cegah submit langsung
                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
                const forms = document.querySelectorAll(".form-konfirmasi-dokument");
                forms.forEach(form => {
                    form.addEventListener("submit", function (e) {
                        e.preventDefault(); // Cegah submit langsung
                        Swal.fire({
                            title: 'Yakin ingin Mengkonfirmasi?',
                            text: "Data Akan dikonfirmasi, Pastikan Semua Laporan Yang Anda Masukan Telah Sesuai!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745', // warna hijau
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Konfirmasi!',           
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                const forms = document.querySelectorAll(".form-konfirmasi-tahap");
                forms.forEach(form => {
                    form.addEventListener("submit", function (e) {
                        e.preventDefault(); // Cegah submit langsung
                        Swal.fire({
                            title: 'Yakin ingin Mengkonfirmasi Tahap ini?',
                            text: "Data Akan dikonfirmasi, Pastikan Semua Laporan Yang Anda Masukan Telah Sesuai!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745', // warna hijau
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Konfirmasi!',           
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                const forms = document.querySelectorAll(".konfirmasi-dokument-admin");
                forms.forEach(form => {
                    form.addEventListener("submit", function (e) {
                        e.preventDefault(); // Cegah submit langsung
                        Swal.fire({
                            title: 'Yakin ingin Mengkonfirmasi?',
                            text: "Data Akan dikonfirmasi, Pastikan Semua Laporan Yang Anda Masukan Telah Sesuai!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745', // warna hijau
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Konfirmasi!',           
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                const forms = document.querySelectorAll(".logout-form");
                forms.forEach(form => {
                    form.addEventListener("submit", function (e) {
                        e.preventDefault(); // Cegah submit langsung
                        Swal.fire({
                            title: 'Yakin ingin keluar?',
                            text: "Anda akan keluar dari akun ini!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Keluar!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
            });
            // ambil nama lengkap berdasarkan nik yang dipilih
                        document.addEventListener('DOMContentLoaded', function () {
                            const nikSelect = document.getElementById('nik');
                            const namaInput = document.getElementById('nama_lengkap');

                            function updateNama() {
                                const opt = nikSelect.options[nikSelect.selectedIndex];
                                if (!opt || !opt.text) {
                                    namaInput.value = '';
                                    return;
                                }
                                // Expect option text like "123456789 - Nama Lengkap"
                                const parts = opt.text.split(' - ');
                                namaInput.value = parts.length > 1 ? parts.slice(1).join(' - ').trim() : '';
                            }

                            nikSelect.addEventListener('change', updateNama);
                            // Initialize on load (useful when old input is present)
                            updateNama();
                        });
        </script>

    </body>
    </html>
