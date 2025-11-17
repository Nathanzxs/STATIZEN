<x-layout>

    <!-- Notifikasi (Success, Error, Validation) -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif 
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif 
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops! Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container my-4">
        <div class="d-flex flex-column flex-lg-row gap-3">

            <!-- ====================================================== -->
            <!-- FORM 1: TAMBAH/EDIT PROGRAM BANTUAN -->
            <!-- ====================================================== -->
            <div class="card p-0 m-0 mb-2 text-bg-primary flex-fill">
                <div class="card-header">
                    <!-- Judul dinamis -->
                    <h5>{{ isset($programToEdit) ? 'Edit Program Bantuan' : 'Tambah Program Bantuan Baru' }}</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($programToEdit) ? route('program-bantuan.update', $programToEdit) : route('program-bantuan.store') }}"
                        method="POST" class="row g-3">
                        @csrf

                        @isset($programToEdit)
                            @method('PUT')
                        @endisset

                        <!-- ID Program (Hanya tampil saat edit, readonly) -->


                        <!-- Nama Program -->
                        <div class="col-md-12">
                            <label class="form-label">Nama Program Bantuan</label>
                            <input type="text" name="Nama_Program" class="form-control"
                                value="{{ old('Nama_Program', $programToEdit->Nama_Program ?? null) }}"
                                placeholder="Misal: Bantuan Langsung Tunai" required>
                        </div>

                        <div class="col-12 text-end ">
                            <button type="submit" class="btn btn-light">
                                {{ isset($programToEdit) ? 'Perbarui Program' : 'Simpan Program Baru' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ====================================================== -->
            <!-- FORM 2: TAMBAH/EDIT PENERIMA BANTUAN -->
            <!-- ====================================================== -->
            <div class="card p-0 m-0 mb-2 text-bg-primary flex-fill">
                <div class="card-header">
                    <h5>{{ isset($penerimaToEdit) ? 'Edit Penerima Bantuan' : 'Tambah Penerima Bantuan' }}</h5>
                </div>
                <div class="card-body ">
                    <form
                        action="{{ isset($penerimaToEdit) ? route('penerima-bantuan.update', $penerimaToEdit) : route('penerima-bantuan.store') }}"
                        method="POST" class="row g-3">
                        @csrf

                        @isset($penerimaToEdit)
                            @method('PUT')
                        @endisset

                        <!-- Pilih Program Bantuan -->
                        <div class="col-12">
                            <label class="form-label">Pilih Program Bantuan</label>
                            <select name="Program_ID" class="form-select" required>
                                <option value="" disabled selected>-- Pilih program --</option>
                                @foreach ($programBantuans as $program)
                                    <option value="{{ $program->Program_ID }}"
                                        {{ old('Program_ID', $penerimaToEdit->Program_ID ?? null) == $program->Program_ID ? 'selected' : '' }}>
                                        {{ $program->Nama_Program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilih Warga (NIK) -->
                        <div class="col-md-12">
                            <label class="form-label">Pilih Warga (Penerima)</label>
                            <!-- Perlu variabel $wargas dari controller -->
                            <select name="NIK" class="form-select" required>
                                <option value="" disabled selected>-- Cari NIK / Nama Warga --</option>
                                @foreach ($wargas ?? [] as $warga)
                                    <option value="{{ $warga->NIK }}"
                                        {{ old('NIK', $penerimaToEdit->NIK ?? null) == $warga->NIK ? 'selected' : '' }}>
                                        {{ $warga->Nama_Lengkap }} ({{ $warga->NIK }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Bantuan -->
                        <div class="col-md-12">
                            <label class="form-label">Status Bantuan</label>
                            <select name="Status" class="form-select" required>
                                <option value="Pending"
                                    {{ old('Status', $penerimaToEdit->Status ?? null) == 'Pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="Layak"
                                    {{ old('Status', $penerimaToEdit->Status ?? null) == 'Layak' ? 'selected' : '' }}>
                                    Layak</option>
                                <option value="Tidak Layak"
                                    {{ old('Status', $penerimaToEdit->Status ?? null) == 'Tidak Layak' ? 'selected' : '' }}>
                                    Tidak Layak</option>
                            </select>
                        </div>

                        <div class="col-12 text-end ">
                            <button type="submit" class="btn btn-success">
                                {{ isset($penerimaToEdit) ? 'Perbarui Penerima' : 'Simpan Penerima' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- ====================================================== -->
        <!-- TABEL 1: DAFTAR PROGRAM BANTUAN (INDUK) -->
        <!-- ====================================================== -->
        <div class="card mb-2 text-bg-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Program Bantuan Terdaftar</h5>

                <a href="{{ route('bantuan.print') }}" target="_blank" class="btn btn-sm btn-outline-light">
                    {{-- <i class="fas fa-print"></i> (Jika Anda pakai FontAwesome) --}}
                    Cetak Laporan PDF
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-accordion text-center mb-0">
                        <thead>
                            <th scope="col">Nama Program Bantuan</th>
                            <th scope="col">Jumlah Penerima</th>
                            <th scope="col" style="width: 15%;">Aksi Program</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programBantuans as $program)
                                <tr data-bs-toggle="collapse" href="#program-{{ $program->Program_ID }}" role="button"
                                    aria-expanded="false" aria-controls="program-{{ $program->Program_ID }}">
                                    <td>{{ $program->Nama_Program }}</td>
                                    <td><span
                                            class="badge bg-secondary">{{ $program->penerima_bantuans_count ?? 0 }}</span>
                                    </td>
                                    <td onclick="event.stopPropagation()">

                                        <!-- Tombol Edit Program -->
                                        <button type="button" class="btn btn-sm btn-warning"
                                            title="Edit Program Bantuan"
                                            onclick="window.location.href='{{ route('program-bantuan.edit', $program) }}'">
                                            Edit
                                        </button>

                                        <!-- Tombol Hapus Program -->
                                        <form action="{{ route('program-bantuan.destroy', $program) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin hapus program ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                title="Hapus Program">Hapus</button>
                                        </form>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="collapse-row p-0 m-0">
                                        <div class="collapse" id="program-{{ $program->Program_ID }}">
                                            <!-- ====================================================== -->
                                            <!-- TABEL 2: DAFTAR PENERIMA BANTUAN (ANAK) -->
                                            <!-- ====================================================== -->
                                            <table class="table table-sm nested-table mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">NIK</th>
                                                        <th scope="col">Nama Penerima</th>
                                                        <th scope="col">Alamat</th>
                                                        <th scope="col">Status Bantuan</th>
                                                        <th scope="col">Aksi Penerima</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($program->penerimaBantuans as $penerima)
                                                        <tr>
                                                            <td>{{ $penerima->NIK }}</td>
                                                            <td>{{ $penerima->warga->Nama_Lengkap ?? 'N/A' }}</td>
                                                            <td>{{ $penerima->warga->keluarga->Alamat ?? 'N/A' }}</td>
                                                            <td>
                                                                @if ($penerima->Status == 'Layak')
                                                                    <span
                                                                        class="badge bg-success">{{ $penerima->Status }}</span>
                                                                @elseif($penerima->Status == 'Pending')
                                                                    <span
                                                                        class="badge bg-warning text-dark">{{ $penerima->Status }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-danger">{{ $penerima->Status }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Tombol Edit Penerima -->
                                                                <a href="{{ route('penerima-bantuan.edit', $penerima) }}"
                                                                    class="btn btn-sm btn-outline-primary">Edit</a>

                                                                <!-- Tombol Hapus Penerima -->
                                                                <form
                                                                    action="{{ route('penerima-bantuan.destroy', $penerima) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirm('Yakin ingin hapus penerima ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger"
                                                                        title="Hapus Penerima">Hapus</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center p-3">Belum ada
                                                                penerima untuk program ini.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4"> Belum ada data program bantuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    @endpush

</x-layout>
