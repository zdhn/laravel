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
        <div>
            <table class="table text-center">
               
                <thead>
                <tr>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Total Harga</th>
                                            <th scope="col"></th>
                </thead>
                <tbody>
                @foreach ($keranjangs as $keranjang)
                                        <tr>
                                            <td style="vertical-align: middle;"> <img width="100px"
                                                src="{{ asset('storage/produk/' . $keranjang->produk->foto) }}"
                                                alt=""></td>
                                            <td style="vertical-align: middle;">
                                                {{ $keranjang->produk->nama_produk }}</td>
                                            <td style="vertical-align: middle;">
                                                Rp.{{ number_format($keranjang->produk->harga, 0, ',', '.') }},00
                                            </td>
                                            <td style="vertical-align: middle;">{{ $keranjang->jumlah_produk }}
                                            </td>
                                            <td style="vertical-align: middle;">
                                                Rp.{{ number_format($keranjang->total_harga, 0, ',', '.') }},00
                                            </td>
                                            <td>
                                                <!-- Tombol Delete -->
                                                <form action="{{ route('keranjang.destroy', $keranjang->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>                               
                                        </tr>
                                        @endforeach
                </tbody>
            </table>
            <form action="{{route('checkout')}}" method="post">
                @csrf
            <button type="submit" class="btn btn-danger">Beli</button>
            </form>
        </div>
    </div>
</main>



@endsection
