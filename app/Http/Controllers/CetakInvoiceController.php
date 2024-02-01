<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CetakPegawaiController extends Controller
{
 public function cetakTransaksi()
 {
    $invoice = session('current_invoice');
        $transaksis = Transaksi::where('invoice', $invoice)->get();
        $totalHarga = $transaksis->sum('total_harga');

        $selectedProducts = [];
        foreach ($transaksis as $transaksi) 
            $produk = Produk::find($transaksi->id_produk);

            $selectedProducts[] = [
                'produk' => $produk,
                'nama_produk' => $produk->nama_produk,
                'kuantitas' => $transaksi->kuantitas,
                'total_harga' => $transaksi->total_harga,
            ];

            
            return view('customer.cetak_invoice', compact('transaksis','totalHarga','selectedProducts'));
 }  

 
}
  
