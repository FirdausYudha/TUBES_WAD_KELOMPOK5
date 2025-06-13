
<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response; // Tambahkan ini

/**
 * ProdukController adalah controller yang mengatur semua operasi terkait produk dalam aplikasi.
 * Controller ini menangani operasi CRUD (Create, Read, Update, Delete) produk serta pembuatan laporan produk dalam berbagai format (tampilan web, CSV, dan PDF).
 * 
 * Berikut penjelasan detail setiap bagian:
 * 
 * 1. Namespace dan Import:
 * - Berada di namespace App\Http\Controllers.
 * - Mengimpor model Produk, kelas Request, View, RedirectResponse untuk tipe data.
 * - Menggunakan DB facade untuk query database, PDF facade untuk pembuatan PDF, dan Response facade untuk streaming file CSV.
 * 
 * 2. Kelas ProdukController:
 * - Meng-extend kelas Controller.
 * - Berisi metode-metode untuk mengelola data produk.
 * 
 * 3. Metode-metode:
 * 
 * - index(): Menampilkan halaman utama daftar produk dengan data ringkasan seperti total produk, total stok, total kategori, dan data untuk grafik stok berdasarkan kategori. Mengambil data produk terbaru dengan pagination 7 per halaman.
 * 
 * - create(): Menampilkan form untuk menambah produk baru.
 * 
 * - store(Request $request): Memvalidasi data input produk baru, menyimpan produk ke database, dan mengarahkan kembali ke halaman daftar produk dengan pesan sukses.
 * 
 * - edit(Produk $produk): Menampilkan form untuk mengedit produk yang sudah ada.
 * 
 * - update(Request $request, Produk $produk): Memvalidasi data input untuk update produk, memperbarui data produk di database, dan mengarahkan kembali ke halaman daftar produk dengan pesan sukses.
 * 
 * - destroy(Produk $produk): Menghapus produk dari database dan mengarahkan kembali ke halaman daftar produk dengan pesan sukses.
 * 
 * - laporan(Request $request): Menampilkan halaman laporan produk dengan fitur filter berdasarkan kategori, supplier, dan pencarian nama produk atau SKU. Menyediakan data statistik, pagination, sorting, dan data untuk grafik berdasarkan kategori dan supplier.
 * 
 * - laporanCsv(Request $request): Mengekspor data laporan produk yang sudah difilter ke format CSV dan mengunduhnya.
 * 
 * - laporanPdf(Request $request): Mengekspor data laporan produk yang sudah difilter ke format PDF dan mengunduhnya.
 * 
 * Secara keseluruhan, ProdukController mengelola data produk dan menyediakan tampilan serta fitur ekspor laporan untuk kebutuhan manajemen inventaris produk.
 */
class ProdukController extends Controller
{
    // Method index, create, store, edit, update, destroy tetap sama persis
    // seperti sebelumnya dan tidak perlu diubah.
    
    public function index(): View
    {
        // Menghitung total produk yang ada di database
        $totalProduk = Produk::count();
        // Menghitung total stok dari semua produk
        $totalStok = Produk::sum('jumlah');
        // Menghitung jumlah kategori produk yang unik
        $totalKategori = Produk::distinct('kategori')->count('kategori');
        // Mengambil data produk terbaru dengan pagination 7 produk per halaman
        $produks = Produk::latest()->paginate(7);
        // Mengambil data untuk grafik stok berdasarkan kategori produk
        $chartData = Produk::select('kategori', DB::raw('sum(jumlah) as total_stok'))
            ->groupBy('kategori')
            ->pluck('total_stok', 'kategori');

        // Mengembalikan view produk.index dengan data yang sudah dikompak
        return view('produk.index', compact('produks', 'totalProduk', 'totalStok', 'totalKategori', 'chartData'));
    }

    // Menampilkan form untuk menambah produk baru
    public function create(): View { return view('produk.create'); }

    public function store(Request $request): RedirectResponse
    {
        // Validasi data input dari form tambah produk
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:produks',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);
        // Menyimpan data produk baru ke database
        Produk::create($request->all());
        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit produk yang sudah ada
    public function edit(Produk $produk): View { return view('produk.edit', compact('produk')); }

    public function update(Request $request, Produk $produk): RedirectResponse
    {
        // Validasi data input dari form edit produk
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:produks,sku,' . $produk->id,
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);
        // Memperbarui data produk di database
        $produk->update($request->all());
        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    // Menghapus produk dari database
    public function destroy(Produk $produk): RedirectResponse
    {
        $produk->delete();
        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Menampilkan halaman laporan produk.
     */
    public function laporan(Request $request): View
    {
        // Membuat query builder untuk model Produk
        $query = Produk::query();

        // Terapkan filter kategori jika ada
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        // Terapkan filter supplier jika ada
        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }
        // Terapkan filter pencarian nama produk atau SKU jika ada
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Hitung statistik setelah filter diterapkan
        $totalProduk = $query->count();
        $totalStok = $query->sum('jumlah');
        $totalKategori = $query->clone()->distinct()->count('kategori');
        $stokRendah = $query->clone()->where('jumlah', '<=', 10)->count();

        // Daftar field yang diizinkan untuk sorting
        $allowedSortFields = ['nama_produk', 'kategori', 'jumlah', 'harga_beli'];
        // Daftar arah sorting yang diizinkan
        $allowedDirections = ['asc', 'desc'];

        // Ambil field sorting dari request, default 'nama_produk'
        $sortField = $request->get('sort', 'nama_produk');
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'nama_produk';
        }

        // Ambil arah sorting dari request, default 'asc'
        $sortDirection = $request->get('direction', 'asc');
        if (!in_array($sortDirection, $allowedDirections)) {
            $sortDirection = 'asc';
        }

        // Terapkan sorting pada query
        $query->orderBy($sortField, $sortDirection);

        // Pagination, default 10 data per halaman
        $perPage = $request->get('per_page', 10);
        $produks = $query->paginate($perPage);

        // Ambil data kategori unik untuk dropdown filter
        $kategoris = Produk::select('kategori')->distinct()->pluck('kategori');
        // Ambil data supplier unik untuk dropdown filter
        $suppliers = Produk::select('supplier')->distinct()->pluck('supplier');

        // Data untuk chart stok berdasarkan kategori
        $chartData = Produk::select('kategori', DB::raw('sum(jumlah) as total_stok'))->groupBy('kategori')->pluck('total_stok', 'kategori');
        // Data untuk chart stok berdasarkan supplier
        $supplierChartData = Produk::select('supplier', DB::raw('sum(jumlah) as total_stok'))->groupBy('supplier')->pluck('total_stok', 'supplier');

        // Mengembalikan view laporan dengan data yang sudah dikompak
        return view('produk.laporan', compact(
            'produks', 'totalProduk', 'totalStok', 'totalKategori', 'stokRendah',
            'kategoris', 'suppliers', 'chartData', 'supplierChartData'
        ));
    }

    /**
     * Export laporan produk to CSV.
     */
    public function laporanCsv(Request $request)
    {
        // Membuat query builder untuk model Produk
        $query = Produk::query();
        // Terapkan filter kategori jika ada
        if ($request->filled('kategori')) { $query->where('kategori', $request->kategori); }
        // Terapkan filter supplier jika ada
        if ($request->filled('supplier')) { $query->where('supplier', $request->supplier); }
        // Terapkan filter pencarian nama produk atau SKU jika ada
        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('nama_produk', 'like', '%' . $request->search . '%')->orWhere('sku', 'like', '%' . $request->search . '%'));
        }
        // Mengambil data produk yang sudah difilter dan mengurutkan berdasarkan nama produk
        $produks = $query->orderBy('nama_produk')->get();
        
        // Header untuk file CSV yang akan diunduh
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="laporan_produk.csv"'];
        // Kolom-kolom yang akan ditulis ke file CSV
        $columns = ['Nama Produk', 'SKU', 'Kategori', 'Jumlah', 'Harga Beli', 'Supplier', 'Status'];

        // Callback untuk menulis data ke output CSV
        $callback = function() use ($produks, $columns) {
            $file = fopen('php://output', 'w');
            // Menulis header kolom CSV
            fputcsv($file, $columns);
            // Menulis setiap baris data produk ke CSV
            foreach ($produks as $produk) {
                // Menentukan status produk berdasarkan jumlah stok
                $status = 'Tersedia';
                if ($produk->jumlah <= 0) { $status = 'Habis'; } 
                elseif ($produk->jumlah <= 10) { $status = 'Stok Rendah'; }
                // Menulis data produk ke file CSV
                fputcsv($file, [$produk->nama_produk, $produk->sku, $produk->kategori, $produk->jumlah, $produk->harga_beli, $produk->supplier, $status]);
            }
            fclose($file);
        };
        // Mengembalikan response streaming file CSV untuk diunduh
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export laporan produk to PDF.
     */
    public function laporanPdf(Request $request)
    {
        // Membuat query builder untuk model Produk
        $query = Produk::query();
        // Terapkan filter kategori jika ada
        if ($request->filled('kategori')) { $query->where('kategori', $request->kategori); }
        // Terapkan filter supplier jika ada
        if ($request->filled('supplier')) { $query->where('supplier', $request->supplier); }
        // Terapkan filter pencarian nama produk atau SKU jika ada
        if ($request->filled('search')) {
             $query->where(fn($q) => $q->where('nama_produk', 'like', '%' . $request->search . '%')->orWhere('sku', 'like', '%' . $request->search . '%'));
        }
        // Mengambil data produk yang sudah difilter dan mengurutkan berdasarkan nama produk
        $produks = $query->orderBy('nama_produk')->get();
        // Mendapatkan tanggal sekarang dalam format 'd F Y'
        $tanggal = now()->format('d F Y');
        
        // Membuat file PDF dari view laporan_pdf dengan data produk dan tanggal
        $pdf = PDF::loadView('produk.laporan_pdf', compact('produks', 'tanggal'));
        // Mengunduh file PDF dengan nama yang mengandung tanggal hari ini
        return $pdf->download('laporan-produk-'.now()->format('Y-m-d').'.pdf');
    }
}
