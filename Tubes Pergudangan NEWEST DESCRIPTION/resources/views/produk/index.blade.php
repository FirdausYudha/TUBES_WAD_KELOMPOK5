{{--
File ini adalah halaman dashboard utama yang menampilkan ringkasan inventaris produk dan daftar produk terbaru.
Berikut penjelasan lengkap per bagian:

1. Extends dan Section:
- Meng-extends layout utama aplikasi.
- Menentukan judul halaman menjadi "Dashboard".
- Membuka section content untuk isi halaman.

2. Header Halaman:
- Container fleksibel dengan judul "Dashboard".
- Deskripsi singkat "Ringkasan inventaris Anda saat ini."
- Tombol "Lihat Laporan" yang mengarah ke halaman laporan produk.

3. Kartu Statistik:
- Tiga kartu yang menampilkan statistik utama:
  * Total Jenis Produk dengan ikon kotak terbuka.
  * Total Stok Keseluruhan dengan ikon tumpukan kotak.
  * Jumlah Kategori dengan ikon label harga.
- Setiap kartu menggunakan styling Bootstrap dan ikon FontAwesome.

4. Tabel Produk:
- Menampilkan daftar produk terbaru dalam tabel.
- Kolom tabel: No, Nama Produk, Kategori, Stok, Harga, Aksi.
- Setiap baris menampilkan data produk dengan tombol aksi Edit dan Hapus.
- Jika tidak ada data produk, menampilkan pesan "Data produk masih kosong."
- Pagination Bootstrap 5 untuk navigasi halaman produk.

5. Script Chart:
- Menggunakan Chart.js untuk menampilkan diagram pie stok produk berdasarkan kategori.
- Data chart diambil dari variabel $chartData yang di-encode ke JSON.
- Warna chart sudah ditentukan untuk kategori berbeda.
- Chart responsif dengan legenda di bawah.

Fungsi utama file ini adalah memberikan gambaran cepat tentang status inventaris produk dan akses mudah ke pengelolaan produk serta laporan.
--}}

@extends('layout')
@section('title', 'Dashboard')
@section('content')

<!-- Header Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Dashboard</h1>
        <p class="text-muted">Ringkasan inventaris Anda saat ini.</p>
    </div>
    <div>
        <a href="{{ route('produk.laporan') }}" class="btn btn-primary">Lihat Laporan</a>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="row">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon bg-primary">
                    <i class="fas fa-box-open"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0">{{ $totalProduk }}</h5>
                    <p class="card-text text-muted">Total Jenis Produk</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #10B981;">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0">{{ $totalStok }}</h5>
                    <p class="card-text text-muted">Total Stok Keseluruhan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #F59E0B;">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0">{{ $totalKategori }}</h5>
                    <p class="card-text text-muted">Jumlah Kategori</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Tabel Produk -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">Daftar Produk Terbaru</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produks as $index => $produk)
                            <tr>
                                <td>{{ $produks->firstItem() + $index }}</td>
                                <td><strong class="text-dark">{{ $produk->nama_produk }}</strong><br><small class="text-muted">SKU: {{ $produk->sku }}</small></td>
                                <td><span class="badge" style="background-color: #E2E8F0; color: #475569;">{{ $produk->kategori }}</span></td>
                                <td>{{ $produk->jumlah }}</td>
                                <td>Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                                <td class="text-center">
                                     <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <p>Data produk masih kosong.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($produks->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $produks->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
