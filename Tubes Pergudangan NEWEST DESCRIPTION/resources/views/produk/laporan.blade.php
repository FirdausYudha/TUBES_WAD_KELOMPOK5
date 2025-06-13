<!-- {{--
File ini adalah halaman laporan produk yang menampilkan ringkasan dan daftar lengkap produk dengan fitur filter dan ekspor.
Berikut penjelasan lengkap per bagian kode:

1. Extends dan Section:
- Meng-extends layout utama aplikasi.
- Menentukan judul halaman menjadi "Laporan Produk".
- Membuka section content untuk isi halaman.

2. Header Halaman:
- Container fleksibel dengan judul "Laporan Produk".
- Deskripsi singkat "Ringkasan dan daftar lengkap produk dengan filter."
- Tombol untuk download laporan dalam format CSV dan PDF, serta tombol kembali ke dashboard.

3. Kartu Statistik:
- Empat kartu menampilkan statistik utama:
  * Produk Ditemukan (total produk hasil filter)
  * Total Stok (jumlah stok keseluruhan)
  * Jumlah Kategori
  * Stok Rendah (produk dengan stok ≤ 10)
- Setiap kartu menggunakan ikon FontAwesome dan styling Bootstrap.

4. Filter dan Search:
- Form dengan method GET ke route 'produk.laporan'.
- Dropdown filter kategori dan supplier dengan opsi "Semua".
- Input teks untuk pencarian nama produk atau SKU.
- Tombol submit untuk menerapkan filter.

5. Tabel Produk:
- Menampilkan daftar produk lengkap sesuai filter.
- Kolom tabel: No, Nama Produk, SKU, Kategori, Stok, Harga Beli, Supplier, Status.
- Kolom Nama Produk menampilkan nama dan deskripsi singkat jika ada.
- Kolom Stok menampilkan badge dengan warna merah jika stok ≤ 10, hijau jika lebih.
- Kolom Status menampilkan badge dengan status stok: Habis, Stok Rendah, Tersedia.
- Jika tidak ada data sesuai filter, menampilkan pesan dan tombol reset filter.
- Pagination dengan mempertahankan query filter.

6. Pie Chart Kategori:
- Menampilkan chart pie stok produk per kategori menggunakan Chart.js.
- Terdapat tombol export PDF yang mengarah ke laporan PDF dengan filter yang sama.

7. Script JavaScript:
- Fungsi changePerPage untuk mengubah jumlah item per halaman dan reset halaman ke 1.
- Inisialisasi Chart.js untuk menampilkan pie chart stok per kategori dengan warna dan opsi legend.

Fungsi utama file ini adalah menyediakan tampilan laporan produk yang interaktif dengan filter, statistik, dan opsi ekspor untuk manajemen inventaris yang lebih baik.
--}}

{{--
Baris 1: Meng-extends layout utama aplikasi.
Baris 2: Menentukan judul halaman menjadi "Laporan Produk".
Baris 4-10: Membuka section content dan membuat header halaman dengan judul dan deskripsi.
Baris 11-20: Menampilkan tombol download CSV, PDF, dan tombol kembali ke dashboard.
Baris 22-56: Menampilkan kartu statistik produk ditemukan, total stok, jumlah kategori, dan stok rendah dengan ikon dan styling.
Baris 58-88: Form filter dengan dropdown kategori, supplier, input pencarian, dan tombol filter.
Baris 90-146: Tabel produk lengkap dengan kolom No, Nama Produk (dengan deskripsi singkat jika ada), SKU, Kategori, Stok (dengan badge warna), Harga Beli, Supplier, dan Status (dengan badge warna).
Baris 147-160: Menampilkan pesan jika data kosong atau tidak ada produk sesuai filter, dengan tombol reset filter jika ada filter aktif.
Baris 162-168: Pagination dengan mempertahankan query filter.
Baris 170-192: Menampilkan pie chart stok per kategori dengan judul dan canvas chart.
Baris 193-201: Tombol export PDF dengan ikon dan styling.
Baris 203-205: Memuat library Chart.js dari CDN.
Baris 207-234: Script JavaScript untuk fungsi changePerPage dan inisialisasi chart pie menggunakan data stok kategori.
Baris 236: Menutup section content.

Fungsi utama file ini adalah menyediakan tampilan laporan produk yang interaktif dengan filter, statistik, dan opsi ekspor untuk manajemen inventaris yang lebih baik.
--}} -->

@extends('layout')
@section('title', 'Laporan Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Laporan Produk</h1>
        <p class="text-muted">Ringkasan dan daftar lengkap produk dengan filter.</p>
    </div>
    <div>
        <a href="{{ route('produk.laporan.csv', request()->query()) }}" class="btn btn-success me-2">
            <i class="fas fa-file-csv"></i> Download CSV
        </a>
        <a href="{{ route('produk.laporan.pdf', request()->query()) }}" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon bg-primary">
                    <i class="fas fa-box-open"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0">{{ $totalProduk }}</h5>
                    <p class="card-text text-muted">Produk Ditemukan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #10B981;">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0">{{ $totalStok }}</h5>
                    <p class="card-text text-muted">Total Stok</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #F59E0B;">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0">{{ $totalKategori }}</h5>
                    <p class="card-text text-muted">Jml Kategori</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #EF4444;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0">{{ $stokRendah }}</h5>
                    <p class="card-text text-muted">Stok Rendah (≤10)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter dan Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('produk.laporan') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">Semua</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Supplier</label>
                <select name="supplier" class="form-select">
                    <option value="">Semua</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier }}" {{ request('supplier') == $supplier ? 'selected' : '' }}>
                            {{ $supplier }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari Produk</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Nama atau SKU..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="d-grid w-100">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Produk -->
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">Daftar Produk Lengkap</h5>
        <div class="d-flex align-items-center">
            <small class="text-muted me-3">
                Menampilkan {{ $produks->count() }} dari {{ $produks->total() }} produk
            </small>
            <select class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 per halaman</option>
                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 per halaman</option>
                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 per halaman</option>
                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per halaman</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_produk', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="text-decoration-none text-dark">
                                Nama Produk
                                @if(request('sort') == 'nama_produk')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>SKU</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'kategori', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="text-decoration-none text-dark">
                                Kategori
                                @if(request('sort') == 'kategori')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="text-decoration-none text-dark">
                                Stok
                                @if(request('sort') == 'jumlah')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'harga_beli', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="text-decoration-none text-dark">
                                Harga Beli
                                @if(request('sort') == 'harga_beli')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>Supplier</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $index => $produk)
                    <tr>
                        <td>{{ $produks->firstItem() + $index }}</td>
                        <td>
                            <strong class="text-dark">{{ $produk->nama_produk }}</strong>
                            @if($produk->deskripsi)
                                <br><small class="text-muted">{{ Str::limit($produk->deskripsi, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <code class="bg-light px-2 py-1 rounded">{{ $produk->sku }}</code>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $produk->kategori }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $produk->jumlah <= 10 ? 'bg-danger-subtle text-danger-emphasis' : 'bg-success-subtle text-success-emphasis' }}">
                                {{ $produk->jumlah }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                        <td>{{ $produk->supplier }}</td>
                        <td>
                            @if($produk->jumlah <= 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($produk->jumlah <= 10)
                                <span class="badge bg-warning">Stok Rendah</span>
                            @else
                                <span class="badge bg-success">Tersedia</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3"></i>
                            <p class="mb-0">{{ request()->hasAny(['search', 'kategori', 'supplier']) ? 'Tidak ada produk yang sesuai dengan filter.' : 'Data produk masih kosong.' }}</p>
                            @if(request()->hasAny(['search', 'kategori', 'supplier']))
                                <a href="{{ route('produk.laporan') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-times"></i> Reset Filter
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($produks->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $produks->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<!-- Pie Chart Kategori -->
<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">Stok per Kategori</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryPieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <a href="{{ route('produk.laporan.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </h5>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@push('scripts')
<script>
function changePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', function () {
    const categoryData = @json($chartData);

    const ctx = document.getElementById('categoryPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                label: 'Jumlah Stok',
                data: Object.values(categoryData),
                backgroundColor: [
                    '#4A69E2',
                    '#10B981',
                    '#F59E0B',
                    '#6366F1',
                    '#EF4444',
                    '#8B5CF6'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
@endsection
