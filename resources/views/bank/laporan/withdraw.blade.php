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
                                            <th>Rekening</th>
                                            <th>Nama</th>
                                            <th>Nominal</th>
                                            <th>Kode Unik</th>
                                            <th>Status</th>
                                        </tr>
                                </thead>
                                <tbody>
                                @foreach ($withdrawals as $i => $withdrawal)
                                        
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="text-center"> {{ $withdrawal->wallet->rekening }}</td>
                                        <td class="text-center"> {{ $withdrawal->wallet->user->name}}</td>
                                        <td class="text-center">Rp.{{ number_format ( $withdrawal->nominal, 0,',','.') }}</td>
                                        <td class="text-center">{{ $withdrawal->kode_unik }}</td>
                                        <td class="text-center">{{ $withdrawal->status }}</td>
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