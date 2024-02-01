@extends('layout.main')

@section('content')
    
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area sales-style-two">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Permintaan Top Up</h4>
                        <div class="data-tables">
                            <table id="table1" class="text-center table table-bordered table-hover">
                                
                                <thead class="bg-light text-capitalize">
                                <tr>
                                            <th>No.</th>
                                            <th>Invoice</th>
                                            <th>Customer</th>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Total Harga</th>
                                        </tr>
                                </thead>
                                <tbody>
                                @foreach ($transaksis as $i =>$transaksi)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="text-center"> {{ $transaksi->invoice }}</td>
                                            <td class="text-center"> {{ $transaksi->user->name }}</td>
                                            <td class="text-center"> {{ $transaksi->produk->nama_produk}}</td>
                                            <td class="text-center">Rp.{{ number_format ( $transaksi->harga, 0,',','.') }}</td>
                                            <td class="text-center"> {{ $transaksi->kuantitas}}</td>
                                            <td class="text-center">Rp.{{ number_format ( $transaksi->total_harga, 0,',','.') }}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
    <!-- sales report area end -->

    @endsection