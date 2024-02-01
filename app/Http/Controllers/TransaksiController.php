<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Models\Wallet;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoretransaksiRequest;
use App\Http\Requests\UpdatetransaksiRequest;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function customerIndexKantin()
    {
        $title = 'Kantin';
        $produks = Produk::all();
        $wallets = Wallet::where('id_user', auth()->user()->id)->first();
        return view('customer.kantin', compact('title', 'produks', 'wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function keranjangIndex()
    {
        $title = 'Keranjang';
        $id_user = Auth::id();
        $keranjangs = Keranjang::where('id_user', $id_user)->get();

        $totalHarga = 0;

        foreach ($keranjangs as $keranjang) {
            $totalHargaPerItem = $keranjang->produk->harga * $keranjang->jumlah_produk;
            $totalHarga += $totalHargaPerItem;
        }

        return view('customer.keranjang', compact('title', 'keranjangs', 'totalHarga'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'jumlah_produk' => 'required|numeric',
            'id_produk' => 'required',
            'id_user' => 'required',
            'harga' => 'required'
        ]);

        $id_user = $request->id_user;
        $produk = Produk::find($request->id_produk);

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $jumlah_produk = $request->jumlah_produk;
        $total_harga = $request->harga * $jumlah_produk;

        $produk_sama = Keranjang::where('id_user', $id_user)->where('id_produk', $produk->id)->first();

        if ($produk_sama) {
            $produk_sama->jumlah_produk += $jumlah_produk;
            $produk_sama->total_harga += $total_harga;
            $produk_sama->save();
        } else {
            Keranjang::create([
                'id_user' => $id_user,
                'id_produk' => $produk->id,
                'jumlah_produk' => $jumlah_produk,
                'total_harga' => $total_harga,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambah produk ke keranjang');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function keranjangDestroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $keranjang->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus produk dari keranjang.');
    }

    /**
     * Display the specified resource.
     */
    public function checkout(Request $request)
    {
        $id_user = auth()->user()->id;

        $selectedProducts = Keranjang::where('id_user', $id_user)
            ->get();

        $totalHarga = $selectedProducts->sum('total_harga');
        $userWallet = Wallet::where('id_user', $id_user)->first();

        if ($userWallet->saldo < $totalHarga) {
            return redirect()->route('customer.index')->with(['error' => 'Saldo anda tidak mencukupi.']);
        }
        $invoice = 'INV' . auth()->user()->id . now()->format('dmYHis');
        session(['current_invoice' => $invoice]);

        foreach ($selectedProducts as $selectedProduct) {
            $transaksi = new Transaksi();
            $transaksi->id_user = $id_user;
            $transaksi->id_produk = $selectedProduct->id_produk;
            $transaksi->harga = $selectedProduct->produk->harga;
            $transaksi->total_harga = $selectedProduct->total_harga;
            $transaksi->kuantitas = $selectedProduct->jumlah_produk;
            $transaksi->tgl_transaksi = now();
            $transaksi->invoice = $invoice;
            $transaksi->save();

            $produk = Produk::find($selectedProduct->id_produk);
            $produk->stok -= $selectedProduct->jumlah_produk;
            $produk->save();

            $selectedProduct->delete();
        }

        $userWallet->saldo -= $totalHarga;
        $userWallet->save();

        $title = 'Invoice';
        return view('customer.invoice', compact('selectedProducts', 'totalHarga', 'title', 'invoice'));
    }
    public function cetakTransaksi()
    {
        $invoice = session('current_invoice');
        $transaksis = Transaksi::where('invoice', $invoice)->get();
        $totalHarga = $transaksis->sum('total_harga');

        $selectedProducts = [];
        foreach ($transaksis as $transaksi) {
            $produk = Produk::find($transaksi->id_produk);

            $selectedProducts[] = [
                'produk' => $produk,
                'nama_produk' => $produk->nama_produk,
                'kuantitas' => $transaksi->kuantitas,
                'total_harga' => $transaksi->total_harga,
            ];
        }

        session()->forget('current_invoice');

        return view('customer.cetak-invoice', compact('selectedProducts', 'totalHarga', 'invoice'));
    }

    public function laporanTransaksiHarian()
    {
        $title = 'Laporan Transaksi Harian';

        $today = now()->toDateString();
        $transaksis = transaksi::select(DB::raw('DATE(tgl_transaksi) as tanggal'), DB::raw('SUM(total_harga) as total_harga') ) 
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();


        $totalHarga = $transaksis->sum('total_harga');
        

        return view('kantin.laporan.transaksi_harian', compact('transaksis', 'totalHarga', 'title'));
    }

    public function laporanTransaksi($invoice)
    {
        $title = 'Laporan Transaksi';

       
        $transaksis = transaksi::where('invoice', $invoice )->get();
        $totalHarga = $transaksis->sum('total_harga');
        session(['current_invoice'=> $invoice]);

        return view('kantin.laporan.transaksi', compact('transaksis', 'totalHarga', 'title', 'invoice'));
    }
    public function riwayatTransaksi()
    {
        $title = 'Riwayat Transaksi';

        $transaksis = Transaksi::select(DB::raw('DATE(tgl_transaksi) as tanggal'), DB::raw('SUM(total_harga) as total_harga'))
        ->where('id_user', auth()->id())
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();

        $totalHarga = $transaksis->sum('total_harga');

        return view('customer.riwayat.transaksi', compact('title', 'transaksis', 'totalHarga'));
    }
    public function detailRiwayatTransaksi($invoice){
        $title = 'Detail Pembelian';

        $selectedProducts = transaksi::where('invoice', $invoice)->get();
        $totalHarga = $selectedProducts->sum('total_harga');
        session(['current_invoice' => $invoice]);

        return view('customer.invoice', compact('title', 'selectedProducts', 'totalHarga', 'invoice'));
    }
}