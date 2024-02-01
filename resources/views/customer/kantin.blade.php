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
    <!-- Content Row -->
    <div class="row">
        <!-- Produk Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Saldo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.
                                {{ number_format($wallets->saldo) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-11 ml-5 mt-3 ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="font-weight-bold">Produk</h4>
                        <div
                            class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center mt-5">
                            @foreach($produks as $produk)
                                <div class="col-3 mb-5">
                                    <div class="card h-100"
                                        style="box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;">
                                        <!-- Product itmage-->
                                        <img class="card-img-top"
                                            src="{{ asset('storage/produk/' . $produk->foto) }}"
                                            alt="{{ $produk->nama_produk }}"
                                            style="max-height: 15em; object-fit: cover;" />
                                        <!-- Product details-->
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <h5 class="fw-bolder mb-3">{{ $produk->nama_produk }}</h5>
                                                <p class="mb-3">{{ $produk->kategori->nama_kategori }}</p>
                                                <p class="mb-3">Tersedia :{{ $produk->stok }}</p>
                                                <h5>Rp.
                                                    {{ number_format($produk->harga, 0, ',', '.') }},00
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <div class="text-center"><button class="btn btn-outline-dark mt-auto"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addToCart{{ $produk->id }}"><i
                                                        class="ti-shopping-cart"></i> Tambah ke Keranjang</button></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</main>

@foreach($produks as $produk)
    <div class="modal fade" id="addToCart{{ $produk->id }}" tabindex="-1" role="dialog"
        aria-labelledby="addToCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addToCartModalLabel">Tambah ke Keranjang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('addToCart', $produk->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                        <input type="hidden" name="harga" value="{{ $produk->harga }}">
                        <div class="form-group">
                            <label for="jumlah_produk">Qty</label>
                            <input type="number" id="jumlah_produk" class="form-control" min="1"
                                max="{{ $produk->stok }}" name="jumlah_produk" value="1" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tambah</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
