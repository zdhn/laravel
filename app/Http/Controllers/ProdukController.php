<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

        class ProdukController extends Controller
        {
            public function index()
            {
                $title = 'Data Produk';
                $produks = Produk::with('kategori')->get();
                $kategoris = Kategori::all();

                return view('kantin.produk', compact('produks', 'title', 'kategoris'));
            }

            public function store(Request $request)
            {
                
                $request->validate([
                    'nama_produk' => 'required|string|max:255|unique:produks,nama_produk',
                    'harga' => 'required|numeric',
                    'stok' => 'required|numeric',
                    'foto' => 'image|mimes:jpeg,jpg,png|max:2048',
                    'desc' => 'required',
                    'id_kategori' => 'required|exists:kategoris,id',
                ]);

                $existingProduk = Produk::where('nama_produk', $request->nama_produk)->first();

                if ($existingProduk) {
                    $existingProduk->stok += $request->stok;
                    $existingProduk->save();
                } else {
                    $foto = $request->file('foto');
                    $foto->storeAs('public/produk', $foto->hashName());

                    Produk::create([
                        'nama_produk' => $request->nama_produk,
                        'harga' => $request->harga,
                        'stok' => $request->stok,
                        'foto' => $foto->hashName(),
                        'desc' => $request->desc,
                        'id_kategori' => $request->id_kategori
                    ]);
            }
                return redirect()->back()->with('success', 'Berhasil menambahkan sebuah data produk baru.');
        }

        public function update(Request $request, Produk $id)
        {
            $request->validate([
            'nama_prduk' => [
                'required',
                'string',
                'max:225',
                Rule::unique('produks', 'nama_produk')->ignore($id),
            ],
            'id_kategori' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:8',
            'stok' => 'required|numeric',
            // 'foto' => 'image|mimes:jpeg,jpg,png|max:2048',
            'desc' => 'required'
        ]);
    
        $produk = Produk::find($id);
    
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
    
        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,jpg,png|,max:2048',
            ]);
    
            $foto = $request->file('foto');
            if ($produk->foto != 'default.png') {
                storage::delete('public/produk/' . $produk->foto);
        }
        $foto->storeAs('public/produk', $foto->hashName());
    
        storage::delete('public/produk/' . $produk->foto);
        $produk->foto = $foto->hashName();
    }
    
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->desc = $request->desc;
        $produk->save();
    
        return redirect()->back()->with('success', 'Berhasil mengedit sebuah data produk.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        Storage::delete('public/produk/' . $produk->image);
        $produk->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus sebuah data produk');
    }


}


