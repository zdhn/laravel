@extends('layout.main')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Dashboard</h6>
            </nav>
           
                </div>
               
                   
                   
                        </a>
                    </li>
                    
                   
                        
                                       
                                    </div>
                                </a>
                            </li>
                           
                                    </div>
                                </a>
                            </li>
                            <li>
                               
                                       
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                   
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
   
                        
                    </div>
                  
                </div>
            </div>
            
                       
                    </div>
                   
                </div>
            </div>
           
                        
                    </div>
                  
                </div>
            </div>
            
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <div>
            <table class="table text-center">
                <button type="submit" class="btn btn-sm btn-success col-1 ml-3 mt-4 " data-bs-toggle="modal"
                    data-bs-target="#tambahModal">
                    Tambah
                </button>
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Desc</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $i => $produk)
                        <tr>
                            {{-- nomer --}}
                            <td>{{ $i + 1 }}</td>
                            {{-- foto --}}
                            <td class="text-center">
                                <img src="{{ asset('./storage/produk/' . $produk->foto) }}"
                                    alt="{{ $produk->nama_produk }}" style="max-width: 100px;">
                            </td>
                            <td>{{ $produk->nama_produk }}</td>
                            {{-- harga --}}
                            <td>RP.
                                {{ number_format($produk->harga, 0,',','.') }},00
                            </td>
                            {{-- stok --}}
                            <td>{{ $produk->stok }}</td>
                            <td>{{ $produk->desc }}</td>
                            <td class="text-center">
                                <!-- Tombol Edit untuk setiap baris -->
                                <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $produk->id }}">
                                    Edit
                                </button>
                                <!-- Tombol Delete -->
                                <form action="{{ route('produk.destroy', $produk->id) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>

                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

@foreach($produks as $produk)
    <!-- Modal untuk Edit -->
    <div class="modal fade" id="editModal{{ $produk->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editModal{{ $produk->id }}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal{{ $produk->id }}Label">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir Edit -->
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                value="{{ $produk->nama_produk }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulir Tambah -->
                <form action="{{ route('produk.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok" name="stok" required>
                    </div>
                    <div class="form-group">
                        <select name="id_kategori" id="" class="form-control">
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="desc">Desc</label>
                        <input type="text" class="form-control" id="desc" name="desc" required>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Default file input example</label>
                        <input class="form-control" type="file" id="formFile" name="foto">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
