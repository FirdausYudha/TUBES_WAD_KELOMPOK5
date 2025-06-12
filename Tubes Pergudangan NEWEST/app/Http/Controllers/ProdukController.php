<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response; // Tambahkan ini

class ProdukController extends Controller
{
    // Method index, create, store, edit, update, destroy tetap sama persis
    // seperti sebelumnya dan tidak perlu diubah.
    
    public function index(): View
    {
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('jumlah');
        $totalKategori = Produk::distinct('kategori')->count('kategori');
        $produks = Produk::latest()->paginate(7);
        $chartData = Produk::select('kategori', DB::raw('sum(jumlah) as total_stok'))
            ->groupBy('kategori')
            ->pluck('total_stok', 'kategori');

        return view('produk.index', compact('produks', 'totalProduk', 'totalStok', 'totalKategori', 'chartData'));
    }

    public function create(): View { return view('produk.create'); }

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
        return redirect()->route('produk.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function edit(Produk $produk): View { return view('produk.edit', compact('produk')); }

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
        return redirect()->route('produk.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk): RedirectResponse
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Menampilkan halaman laporan produk.
     */
    public function laporan(Request $request): View
    {
        $query = Produk::query();

        // Terapkan filter terlebih dahulu
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

        // Hitung statistik SETELAH filter diterapkan
        $totalProduk = $query->count();
        $totalStok = $query->sum('jumlah');
        $totalKategori = $query->clone()->distinct()->count('kategori');
        $stokRendah = $query->clone()->where('jumlah', '<=', 10)->count();

        // Validasi dan pengurutan
        $allowedSortFields = ['nama_produk', 'kategori', 'jumlah', 'harga_beli'];
        $allowedDirections = ['asc', 'desc'];

        $sortField = $request->get('sort', 'nama_produk');
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'nama_produk';
        }

        $sortDirection = $request->get('direction', 'asc');
        if (!in_array($sortDirection, $allowedDirections)) {
            $sortDirection = 'asc';
        }

        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $produks = $query->paginate($perPage);

        // Data untuk dropdown filter
        $kategoris = Produk::select('kategori')->distinct()->pluck('kategori');
        $suppliers = Produk::select('supplier')->distinct()->pluck('supplier');

        // Data untuk chart
        $chartData = Produk::select('kategori', DB::raw('sum(jumlah) as total_stok'))->groupBy('kategori')->pluck('total_stok', 'kategori');
        $supplierChartData = Produk::select('supplier', DB::raw('sum(jumlah) as total_stok'))->groupBy('supplier')->pluck('total_stok', 'supplier');

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
        $query = Produk::query();
        if ($request->filled('kategori')) { $query->where('kategori', $request->kategori); }
        if ($request->filled('supplier')) { $query->where('supplier', $request->supplier); }
        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('nama_produk', 'like', '%' . $request->search . '%')->orWhere('sku', 'like', '%' . $request->search . '%'));
        }
        $produks = $query->orderBy('nama_produk')->get();
        
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="laporan_produk.csv"'];
        $columns = ['Nama Produk', 'SKU', 'Kategori', 'Jumlah', 'Harga Beli', 'Supplier', 'Status'];

        $callback = function() use ($produks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($produks as $produk) {
                $status = 'Tersedia';
                if ($produk->jumlah <= 0) { $status = 'Habis'; } 
                elseif ($produk->jumlah <= 10) { $status = 'Stok Rendah'; }
                fputcsv($file, [$produk->nama_produk, $produk->sku, $produk->kategori, $produk->jumlah, $produk->harga_beli, $produk->supplier, $status]);
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
        if ($request->filled('kategori')) { $query->where('kategori', $request->kategori); }
        if ($request->filled('supplier')) { $query->where('supplier', $request->supplier); }
        if ($request->filled('search')) {
             $query->where(fn($q) => $q->where('nama_produk', 'like', '%' . $request->search . '%')->orWhere('sku', 'like', '%' . $request->search . '%'));
        }
        $produks = $query->orderBy('nama_produk')->get();
        $tanggal = now()->format('d F Y');
        
        $pdf = PDF::loadView('produk.laporan_pdf', compact('produks', 'tanggal'));
        return $pdf->download('laporan-produk-'.now()->format('Y-m-d').'.pdf');
    }
}