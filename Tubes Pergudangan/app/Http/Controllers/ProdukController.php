<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Pastikan nama model Anda 'Produk' atau sesuaikan
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
        $produks = Produk::latest()->paginate(7); // Tampilkan 7 item per halaman

        // Data untuk Pie Chart (Jumlah STOK per Kategori)
        $chartData = Produk::select('kategori', DB::raw('sum(jumlah) as total_stok'))
            ->groupBy('kategori')
            ->pluck('total_stok', 'kategori');

        // Mengirim semua data ke view 'produk.index'
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
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:produks',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);

        // Membuat produk baru
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
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:produks,sku,' . $produk->id,
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);

        // Update data produk
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
}
