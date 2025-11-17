<x-layout>

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
            <div class="card p-0 m-0 mb-2 text-bg-primary flex-fill">
                <div class="card-header">
                    <h5>Tambah Keluarga Baru</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($keluargaToEdit) ? route('keluarga.update', $keluargaToEdit) : route('keluarga.store') }}"
                        method="POST" class="row g-3">
                        @csrf

                        @isset($keluargaToEdit)
                            @method('PUT')
                        @endisset


                        <div class="col-md-12">
                            <label class="form-label">Nomor KK</label>
                            <input type="text" name="KK_ID" class="form-control"
                                value="{{ old('KK_ID', $keluargaToEdit->KK_ID ?? null) }}"
                                placeholder="16 digit Nomor Kartu Keluarga..." required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">NIK Kepala Keluarga</label>
                            <input type="text" name="nik_kepala" class="form-control"
                                value="{{ old('nik_kepala', $keluargaToEdit->NIK_Kepala_Keluarga ?? null) }}"
                                placeholder="16 digit NIK..." required
                                @isset($keluargaToEdit) readonly required @endisset>
                        </div>


                        <div class="col-md-12">
                            <label class="form-label">Nama Lengkap Kepala Keluarga</label>
                            <input type="text" name="nama_kepala" class="form-control"
                                value="{{ old('nama_kepala', $keluargaToEdit->kepalaKeluarga->Nama_Lengkap ?? null) }}"
                                placeholder="Nama lengkap..."
                                @isset($keluargaToEdit) readonly required   @endisset>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Keluarga</label>
                            <textarea name="Alamat" class="form-control" rows="2" placeholder="Alamat lengkap..." required>{{ old('Alamat', $keluargaToEdit->Alamat ?? null) }}</textarea>
                        </div>

                        <div class="col-12 text-end ">
                            <button type="submit" class="btn btn-light">
                                {{ isset($keluargaToEdit) ? 'Perbarui Data' : 'Simpan Keluarga Baru' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card p-0 m-0 mb-2 text-bg-primary flex-fill">
                <div class="card-header">
                    <h5>Tambah Anggota Warga</h5>
                </div>
                <div class="card-body ">
                    <!--
      Form ini sekarang dinamis:
      1. 'action' akan mengarah ke 'warga.store' atau 'warga.update'.
      2. 'method' akan menambahkan @method('PUT') jika 'update'.
    -->
                    <form
                        action="{{ isset($wargaToEdit) ? route('warga.update', $wargaToEdit) : route('warga.store') }}"
                        method="POST" class="row g-3">
                        @csrf

                        <!-- Jika $wargaToEdit ada (mode edit), tambahkan method spoofing 'PUT' -->
                        @isset($wargaToEdit)
                            @method('PUT')
                        @endisset

                        <div class="col-12">
                            <label class="form-label">Pilih Keluarga (Kepala Keluarga)</label>
                            <select name="KK_ID" class="form-select" required>
                                <option value="" disabled selected>-- Pilih keluarga yang sudah ada --</option>
                                @foreach ($keluargas as $keluarga)
                                    <!--
                      Logika value dinamis:
                      1. Ambil data 'old' (jika validasi gagal).
                      2. Jika tidak, ambil data dari '$wargaToEdit->KK_ID'.
                    -->
                                    <option value="{{ $keluarga->KK_ID }}"
                                        {{ old('KK_ID', $wargaToEdit->KK_ID ?? null) == $keluarga->KK_ID ? 'selected' : '' }}>
                                        {{ $keluarga->kepalaKeluarga->Nama_Lengkap ?? 'KK: ' . $keluarga->KK_ID }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="NIK" class="form-control"
                                value="{{ old('NIK', $wargaToEdit->NIK ?? null) }}" placeholder="16 digit NIK..."
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="Nama_Lengkap" class="form-control"
                                value="{{ old('Nama_Lengkap', $wargaToEdit->Nama_Lengkap ?? null) }}"
                                placeholder="Nama lengkap..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="Tempat_Lahir" class="form-control"
                                value="{{ old('Tempat_Lahir', $wargaToEdit->Tempat_Lahir ?? null) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="Tanggal_Lahir" class="form-control"
                                value="{{ old('Tanggal_Lahir', $wargaToEdit->Tanggal_Lahir ?? null) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="Jenis_Kelamin" class="form-select" required>
                                <option value="Laki-laki"
                                    {{ old('Jenis_Kelamin', $wargaToEdit->Jenis_Kelamin ?? null) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('Jenis_Kelamin', $wargaToEdit->Jenis_Kelamin ?? null) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Hubungan</label>
                            <select name="Status_Hubungan_Keluarga" class="form-select" required>
                                <!-- Tambahkan 'Kepala Keluarga' jika diperlukan -->
                                <option value="Kepala Keluarga"
                                    {{ old('Status_Hubungan_Keluarga', $wargaToEdit->Status_Hubungan_Keluarga ?? null) == 'Kepala Keluarga' ? 'selected' : '' }}>
                                    Kepala Keluarga</option>
                                <option value="Istri"
                                    {{ old('Status_Hubungan_Keluarga', $wargaToEdit->Status_Hubungan_Keluarga ?? null) == 'Istri' ? 'selected' : '' }}>
                                    Istri</option>
                                <option value="Anak"
                                    {{ old('Status_Hubungan_Keluarga', $wargaToEdit->Status_Hubungan_Keluarga ?? null) == 'Anak' ? 'selected' : '' }}>
                                    Anak</option>
                                <option value="Suami"
                                    {{ old('Status_Hubungan_Keluarga', $wargaToEdit->Status_Hubungan_Keluarga ?? null) == 'Suami' ? 'selected' : '' }}>
                                    Suami</option>
                                <option value="Lainnya"
                                    {{ old('Status_Hubungan_Keluarga', $wargaToEdit->Status_Hubungan_Keluarga ?? null) == 'Lainnya' ? 'selected' : '' }}>
                                    Lainnya
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <select name="Pekerjaan" class="form-select" required>
                                <option value="Belum Diisi"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'Belum Diisi' ? 'selected' : '' }}>
                                    -- Pilih Pekerjaan --</option>
                                <option value="IRT"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'IRT' ? 'selected' : '' }}>
                                    IRT</option>
                                <option value="Pelajar/Mahasiswa"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>
                                    Pelajar/Mahasiswa</option>
                                <option value="Wiraswasta"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'Wiraswasta' ? 'selected' : '' }}>
                                    Wiraswasta</option>
                                <option value="Karyawan Swasta"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'Karyawan Swasta' ? 'selected' : '' }}>
                                    Karyawan Swasta</option>
                                <option value="PNS"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'PNS' ? 'selected' : '' }}>
                                    PNS</option>
                                <option value="Petani"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'Petani' ? 'selected' : '' }}>
                                    Petani</option>
                                <option value="Tidak Bekerja"
                                    {{ old('Pekerjaan', $wargaToEdit->Pekerjaan ?? null) == 'Tidak Bekerja' ? 'selected' : '' }}>
                                    Tidak Bekerja</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan</label>
                            <select name="Pendidikan" class="form-select" required>
                                <option value="Belum Diisi"
                                    {{ old('Pendidikan', $wargaToEdit->Pendidikan ?? null) == 'Belum Diisi' ? 'selected' : '' }}>
                                    -- Pilih Pendidikan --</option>
                                <option value="SLTA/Sederajat"
                                    {{ old('Pendidikan', $wargaToEdit->Pendidikan ?? null) == 'SLTA/Sederajat' ? 'selected' : '' }}>
                                    SLTA/Sederajat</option>
                                <option value="S1"
                                    {{ old('Pendidikan', $wargaToEdit->Pendidikan ?? null) == 'S1' ? 'selected' : '' }}>
                                    S1</option>
                                <option value="D3"
                                    {{ old('Pendidikan', $wargaToEdit->Pendidikan ?? null) == 'D3' ? 'selected' : '' }}>
                                    D3</option>
                                <option value="SLTP/Sederajat"
                                    {{ old('Pendidikan', $wargaToEdit->Pendidikan ?? null) == 'SLTP/Sederajat' ? 'selected' : '' }}>
                                    SLTP/Sederajat</option>
                                <option value="SD/Sederajat"
                                    {{ old('Pendidikan', $wargaToEdit->Pendidikan ?? null) == 'SD/Sederajat' ? 'selected' : '' }}>
                                    SD/Sederajat</option>
                                <option value="Belum Sekolah"
                                    {{ old('Pendidikan', $wargaToEdit->Pendidikan ?? null) == 'Belum Sekolah' ? 'selected' : '' }}>
                                    Belum Sekolah</option>
                            </select>
                        </div>
                        <div class="col-12 text-end ">
                            <!-- Teks tombol juga berubah secara dinamis -->
                            <button type="submit" class="btn btn-success">
                                {{ isset($wargaToEdit) ? 'Perbarui Anggota' : 'Simpan Anggota Warga' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="card mb-2 text-bg-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Keluarga Terdaftar</h5>
                <a href="{{ route('warga.print') }}" target="_blank" class="btn btn-sm btn-outline-light">
                    {{-- <i class="fas fa-print"></i> (Jika Anda pakai FontAwesome) --}}
                    Cetak PDF
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-accordion text-center mb-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%;"></th>
                                <th scope="col">Nomor KK</th>
                                <th scope="col">Kepala Keluarga</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Jml. Anggota</th>
                                <th scope="col" style="width: 15%;">Aksi Keluarga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keluargas as $keluarga)
                                <tr data-bs-toggle="collapse" href="#keluarga-{{ $keluarga->KK_ID }}" role="button"
                                    aria-expanded="false" aria-controls="keluarga-{{ $keluarga->KK_ID }}">

                                    <td><i class="icon-toggle"></i></td>

                                    <td><strong>{{ $keluarga->KK_ID }}</strong></td>
                                    <td>{{ $keluarga->kepalaKeluarga->Nama_Lengkap ?? 'N/A' }}</td>
                                    <td>{{ $keluarga->Alamat }}</td>
                                    <td><span class="badge bg-secondary">{{ $keluarga->wargas_count ?? 0 }}</span>
                                    </td>
                                    <td onclick="event.stopPropagation()">

                                        <button type="button" class="btn btn-sm btn-warning"
                                            title="Edit Data Keluarga (Alamat)"
                                            onclick="window.location.href='{{ route('keluarga.edit', $keluarga->KK_ID) }}'">
                                            Edit
                                        </button>

                                        <form action="{{ route('keluarga.destroy', $keluarga->KK_ID) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin hapus keluarga ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                title="Hapus Keluarga">Hapus</button>
                                        </form>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="collapse-row p-0 m-0">
                                        <div class="collapse" id="keluarga-{{ $keluarga->KK_ID }}">
                                            <table class="table table-sm nested-table mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">NIK</th>
                                                        <th scope="col">Nama Anggota</th>
                                                        <th scope="col">Status Hubungan</th>
                                                        <th scope="col">Pekerjaan</th>
                                                        <th scope="col">Aksi Anggota</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($keluarga->wargas as $warga)
                                                        <tr>
                                                            <td>{{ $warga->NIK }}</td>
                                                            <td>{{ $warga->Nama_Lengkap }}</td>
                                                            <td>{{ $warga->Status_Hubungan_Keluarga }}</td>
                                                            <td>{{ $warga->Pekerjaan }}</td>
                                                            <td>
                                                                <a href="{{ route('warga.edit', $warga->NIK) }}"
                                                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                                                <form
                                                                    action="{{ route('warga.destroy', $warga->NIK) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirm('Yakin ingin hapus keluarga ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger"
                                                                        title="Hapus Keluarga">Hapus</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4"> Belum ada data keluarga. Silakan
                                        tambah data baru.
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
