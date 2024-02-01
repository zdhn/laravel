<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
   public function index()
   {
    $title = 'Data Kategori';
    $kategoris =Kategori::all();

    return view('kantin.kategori', compact('title', 'kategoris'));
   }

   public function store(Request $request)
   {
    $request->validate([
        'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
    ]);

    Kategori::create([
        'nama_kategori' => $request->nama_kategori,
    ]);

    return redirect()->back()->with('success', 'berhasil menambahkan sebuah data kategori baru.');
   }

   public function update(Request $request,$id)
   {
    $request->validate([
        'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
    ]);

    $kategori = Kategori::find($id);

    if(!$kategori) {
        return redirect()->back()->with('error', 'kategori tidak ditemukan.');
    }

    $kategori->nama_kategori =$request->nama_kategori;
    $kategori->save();

    return redirect()->back()->with('success', 'berhasil mengedit sebuah data kategori');
   }

   public function destroy($id)
   {
    $kategori = Kategori::find($id);
    $kategori ->delete();

    return redirect()->back()->with('success', 'berhasil menghapus sebuah data kategori.');


   }


}
