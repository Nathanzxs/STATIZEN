<x-layout>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-bg-primary text-center shadow-sm">
                <div class="card-body">
                    <svg width="91" height="91" viewBox="0 0 91 91" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M45.4556 19.9062C50.9525 19.9062 55.4087 15.4501 55.4087 9.95312C55.4087 4.45617 50.9525 0 45.4556 0C39.9586 0 35.5024 4.45617 35.5024 9.95312C35.5024 15.4501 39.9586 19.9062 45.4556 19.9062Z"
                            fill="white" />
                        <path
                            d="M55.1474 34.0183H55.1563L56.5178 33.6095L63.0566 55.3997L71.2324 52.947L68.3513 43.3209C68.3513 43.2996 68.3513 43.2783 68.3389 43.2569L65.3458 33.2825L64.5087 30.4849L64.3487 29.9517H64.3399L63.8937 28.4499C63.4048 26.8026 62.3965 25.3575 61.0192 24.33C59.642 23.3025 57.9695 22.7476 56.2512 22.7482H34.7009C32.9826 22.7476 31.3101 23.3025 29.9328 24.33C28.5556 25.3575 27.5473 26.8026 27.0583 28.4499L26.6122 29.9517H26.6015L26.4416 30.4849L25.6044 33.2825L22.6114 43.2569C22.6114 43.2783 22.6114 43.2996 22.5989 43.3209L19.7179 52.947L27.8936 55.3997L34.4272 33.6095L35.7673 34.0112L26.3491 65.4062H35.5025V90.9999H44.7446V65.4062H46.1665V90.9999H55.4087V65.4062H64.5638L55.1474 34.0183Z"
                            fill="white" />
                    </svg>
                    <h3 class="card-title mt-2">{{ $dataWarga ?? 0 }}</h3>
                    <p class="card-text">Total Warga</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-bg-primary text-center shadow-sm">
                <div class="card-body">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M31.25 21.875C31.25 14.9714 36.8464 9.375 43.75 9.375H56.25C63.1536 9.375 68.75 14.9714 68.75 21.875V22.7291C72.6353 23.0847 76.4892 23.5498 80.3085 24.1213C86.3671 25.0278 90.625 30.2985 90.625 36.2737V48.912C90.625 53.9585 87.5682 58.7136 82.5572 60.3795C72.3191 63.7833 61.3716 65.625 50.0001 65.625C38.6286 65.625 27.6809 63.7833 17.4428 60.3794C12.4318 58.7134 9.375 53.9584 9.375 48.9119V36.2737C9.375 30.2985 13.6329 25.0278 19.6915 24.1213C23.5108 23.5499 27.3647 23.0847 31.25 22.7291V21.875ZM62.5 21.875V22.2534C58.3652 22.0024 54.1973 21.875 50 21.875C45.8027 21.875 41.6348 22.0024 37.5 22.2534V21.875C37.5 18.4232 40.2982 15.625 43.75 15.625H56.25C59.7018 15.625 62.5 18.4232 62.5 21.875ZM50 56.25C51.7259 56.25 53.125 54.8509 53.125 53.125C53.125 51.3991 51.7259 50 50 50C48.2741 50 46.875 51.3991 46.875 53.125C46.875 54.8509 48.2741 56.25 50 56.25Z"
                            fill="white" />
                        <path
                            d="M12.5 76.6665V65.0164C13.4293 65.5261 14.4207 65.9611 15.471 66.3102C26.337 69.9228 37.95 71.875 50.0001 71.875C62.0501 71.875 73.6631 69.9229 84.529 66.3103C85.5793 65.9612 86.5707 65.5262 87.5 65.0165V76.6665C87.5 82.7162 83.1365 88.0312 76.9869 88.8477C68.1564 90.0201 59.148 90.625 50 90.625C40.852 90.625 31.8436 90.0201 23.0131 88.8477C16.8635 88.0312 12.5 82.7162 12.5 76.6665Z"
                            fill="white" />
                    </svg>
                    <h3 class="card-title mt-2">{{ $dataKK ?? 0 }}</h3>
                    <p class="card-text">Kepala Keluarga</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-bg-primary text-center shadow-sm">
                <div class="card-body">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M47.5417 8.40417C50.8334 8.69584 52.7625 9.82084 53.9334 11.1208C55.3625 12.7083 56.25 15.2167 56.25 18.75C56.2506 19.8556 55.9578 20.9415 55.4017 21.897C54.8456 22.8525 54.0459 23.6433 53.0844 24.1889C52.1228 24.7345 51.0338 25.0153 49.9283 25.0026C48.8228 24.9899 47.7405 24.6842 46.7917 24.1167L46.25 23.75C45.8123 23.4217 45.3142 23.1828 44.7841 23.047C44.2541 22.9112 43.7025 22.8812 43.1608 22.9586C42.6191 23.0359 42.098 23.2193 41.6272 23.498C41.1563 23.7768 40.745 24.1456 40.4167 24.5833C40.0884 25.0211 39.8495 25.5192 39.7137 26.0493C39.5779 26.5793 39.5479 27.1309 39.6253 27.6726C39.7815 28.7666 40.366 29.7536 41.25 30.4167C43.4167 32.0417 45.993 33.0312 48.6904 33.2744C51.3877 33.5176 54.0995 33.0049 56.5219 31.7937C58.9443 30.5826 60.9815 28.7207 62.4054 26.4169C63.8292 24.1131 64.5834 21.4583 64.5834 18.75C64.5834 15.8958 64.1584 13.0458 63.1334 10.4458C79.7084 15.9458 91.6667 31.575 91.6667 50C91.6667 73.0125 73.0125 91.6667 50 91.6667C26.9875 91.6667 8.33337 73.0125 8.33337 50C8.33337 27.8125 25.675 9.67918 47.5417 8.40417ZM61 63.4667C60.1512 62.7598 59.0564 62.4188 57.9563 62.5188C56.8562 62.6188 55.8408 63.1516 55.1334 64C53.6375 65.7917 51.8084 66.6667 50 66.6667C48.1917 66.6667 46.3625 65.7917 44.8667 64C44.1505 63.1813 43.1425 62.6752 42.0581 62.5897C40.9737 62.5042 39.8989 62.8462 39.0633 63.5426C38.2277 64.2389 37.6975 65.2345 37.586 66.3165C37.4745 67.3985 37.7906 68.4812 38.4667 69.3334C41.2667 72.6958 45.3167 75 50 75C54.6834 75 58.7334 72.6958 61.5334 69.3334C62.2403 68.4845 62.5813 67.3897 62.4812 66.2896C62.3812 65.1895 61.8485 64.1741 61 63.4667ZM35.4167 41.6667C33.7591 41.6667 32.1694 42.3252 30.9973 43.4973C29.8252 44.6694 29.1667 46.2591 29.1667 47.9167C29.1667 49.5743 29.8252 51.164 30.9973 52.3361C32.1694 53.5082 33.7591 54.1667 35.4167 54.1667C37.0743 54.1667 38.664 53.5082 39.8361 52.3361C41.0082 51.164 41.6667 49.5743 41.6667 47.9167C41.6667 46.2591 41.0082 44.6694 39.8361 43.4973C38.664 42.3252 37.0743 41.6667 35.4167 41.6667ZM64.5834 41.6667C62.9258 41.6667 61.3361 42.3252 60.164 43.4973C58.9919 44.6694 58.3334 46.2591 58.3334 47.9167C58.3334 49.5743 58.9919 51.164 60.164 52.3361C61.3361 53.5082 62.9258 54.1667 64.5834 54.1667C66.241 54.1667 67.8307 53.5082 69.0028 52.3361C70.1749 51.164 70.8334 49.5743 70.8334 47.9167C70.8334 46.2591 70.1749 44.6694 69.0028 43.4973C67.8307 42.3252 66.241 41.6667 64.5834 41.6667Z"
                            fill="white" />
                    </svg>
                    <h3 class="card-title mt-2">{{ $dataBLT ?? 0 }}</h3>
                    <p class="card-text">Penerima Bantuan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title mb-2 mb-md-0">Statistik Warga</h5>

                        <select id="chartFilter" class="form-select form-select-sm" style="width: 150px;">
                            <option value="Pendidikan" selected>Pendidikan</option>
                            <option value="Pekerjaan">Jenis Pekerjaan</option>
                            <option value="Usia">Usia</option>
                        </select>
                    </div>
                    <div class="mt-3" style="height: 250px;">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center mb-4">
        <div class="col-lg-4 text-center mb-3 mb-lg-0">
            <img src='{{ asset('/3d-house-1.png') }}' alt="home" style="max-width: 100%; height: auto;" />
        </div>
        <div class="col-lg-8">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <p class="card-text mb-0">
                        RT 06 berada di Perumahan Griya Anda Dih, Jl. Serma Ishak Ahmad, Kelurahan Bulung, Kecamatan
                        Alam Barajo, Kota Jambi. Wilayah ini merupakan kawasan pemukiman aktif yang dipimpin oleh Ketua
                        RT 06. Sebagai kawasan pemukiman, RT 06 memiliki karakteristik warga kolam menjaga ketertiban
                        lingkungan dan memiliki potensi untuk pengembangan sistem digital pendataan warga.
                    </p>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            const initialData = {!! $initialChartData ?? '{}' !!};

            // Siapkan canvas
            const ctx = document.getElementById('dashboardChart');

            // Cek jika elemen ada sebelum membuat chart
            if (ctx) {
                let myChart = new Chart(ctx, {
                    type: 'bar',
                    data: initialData, // Gunakan data awal dari controller
                    options: {
                        indexAxis: initialData.labels && initialData.labels.length > 10 ? 'y' :
                        'x', // Otomatis ganti ke bar horizontal jika data terlalu banyak
                        responsive: true,
                        maintainAspectRatio: false,
                        // Menambahkan borderRadius untuk membuat sudut bar melengkung
                        datasets: {
                            bar: {
                                borderRadius: 5,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: false // Menghilangkan garis grid di sumbu Y
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Ambil elemen dropdown filter
                const filterSelect = document.getElementById('chartFilter');

                // Tambahkan event listener saat nilai dropdown berubah
                filterSelect.addEventListener('change', function() {
                    const selectedFilter = this.value;
                    // Panggil fungsi untuk update chart
                    updateChartData(selectedFilter);
                });

                // Fungsi untuk mengambil data baru via AJAX dan update chart
                async function updateChartData(filter) {
                    try {
                        // Tentukan URL AJAX (pastikan route ini ada di web.php)
                        const url = '{{ route('dashboard.chartdata') }}';

                        // Kirim permintaan GET dengan parameter filter
                        const response = await axios.get(url, {
                            params: {
                                filter: filter
                            }
                        });

                        const newData = response.data;

                        // Perbarui data di chart
                        myChart.data.labels = newData.labels;
                        myChart.data.datasets = newData.datasets;

                        // Perbarui tipe chart: bar horizontal (y) jika label banyak, vertikal (x) jika sedikit
                        myChart.options.indexAxis = newData.labels.length > 10 ? 'y' : 'x';

                        // Perintahkan Chart.js untuk menggambar ulang
                        myChart.update();

                    } catch (error) {
                        console.error('Gagal mengambil data chart:', error);
                    }
                }
            }
        </script>
    @endpush

</x-layout>
