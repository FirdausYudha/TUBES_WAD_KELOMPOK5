<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Pastikan model Produk sudah benar
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
class ProdukController extends Controller
{
    /**
     * Menampilkan dashboard utama dengan statistik dan daftar produk.
     */
    public function index(): View
    {
        // Data untuk Kartu Statistik
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('jumlah');
        $totalKategori = Produk::distinct('kategori')->count('kategori');

        // Data untuk Tabel (dengan pagination)
        $produks = Produk::latest()->paginate(7); // 7 item per halaman

        // Data untuk Pie Chart (Jumlah STOK per Kategori)
        $chartData = Produk::select('kategori', DB::raw('sum(jumlah) as total_stok'))
            ->groupBy('kategori')
            ->pluck('total_stok', 'kategori');

        return view('produk.index', compact('produks', 'totalProduk', 'totalStok', 'totalKategori', 'chartData'));
    }

    /**
     * Menampilkan formulir untuk membuat produk baru.
     */
    public function create(): View
    {
        return view('produk.create');
    }

    /**
     * Menyimpan produk baru ke dalam database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:produks',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);

        Produk::create($request->all());

        return redirect()->route('produk.index')
                         ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit produk.
     */
    public function edit(Produk $produk): View
    {
        return view('produk.edit', compact('produk'));
    }

    /**
     * Mengupdate data produk di database.
     */
    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:produks,sku,' . $produk->id,
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);

        $produk->update($request->all());

        return redirect()->route('produk.index')
                         ->with('success', 'Data produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        $produk->delete();

        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Menampilkan halaman laporan produk.
     */
    public function laporan(Request $request): View
    {
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('jumlah');
        $totalKategori = Produk::distinct('kategori')->count('kategori');
        $stokRendah = Produk::where('jumlah', '<=', 10)->count();

        $query = Produk::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $allowedSortFields = ['nama_produk', 'sku', 'kategori', 'jumlah'];
        $sortField = in_array($request->get('sort'), $allowedSortFields) ? $request->get('sort') : 'nama_produk';
        $sortDirection = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sortField, $sortDirection);

        $perPage = is_numeric($request->get('per_page')) ? (int) $request->get('per_page') : 25;
        $produks = $query->paginate($perPage);

        $kategoris = Produk::select('kategori')->distinct()->pluck('kategori');
        $suppliers = Produk::select('supplier')->distinct()->pluck('supplier');

        $chartData = Produk::select('kategori', DB::raw('sum(jumlah) as total_stok'))
            ->groupBy('kategori')
            ->pluck('total_stok', 'kategori');

        $supplierChartData = Produk::select('supplier', DB::raw('sum(jumlah) as total_stok'))
            ->groupBy('supplier')
            ->pluck('total_stok', 'supplier');

        return view('produk.laporan', compact(
            'produks', 
            'totalProduk', 
            'totalStok', 
            'totalKategori', 
            'stokRendah',
            'kategoris',
            'suppliers',
            'chartData',
            'supplierChartData'
        ));
    }

    /**
     * Export laporan produk to CSV.
     */
    public function laporanCsv(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $produks = $query->orderBy('nama_produk')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_produk.csv"',
        ];

        $columns = ['Nama Produk', 'SKU', 'Kategori', 'Jumlah', 'Harga Beli', 'Supplier', 'Status'];

        $callback = function() use ($produks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($produks as $produk) {
                $status = 'Tersedia';
                if ($produk->jumlah <= 0) {
                    $status = 'Habis';
                } elseif ($produk->jumlah <= 10) {
                    $status = 'Stok Rendah';
                }

                fputcsv($file, [
                    $produk->nama_produk,
                    $produk->sku,
                    $produk->kategori,
                    $produk->jumlah,
                    $produk->harga_beli,
                    $produk->supplier,
                    $status,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export laporan produk to PDF.
     */
    public function laporanPdf(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $produks = $query->orderBy('nama_produk')->get();

        $pdf = \PDF::loadView('produk.laporan_pdf', compact('produks'));

        return $pdf->download('laporan_produk.pdf');
    }
}
