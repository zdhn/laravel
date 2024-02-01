@extends('layout.main')

@section('content')

<!-- Page Wrapper -->
 <div id="wrapper">

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">


        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"> Bank Dashboard </h1>
                
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Kategori Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Riwayat TopUp</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">  {{count($requestTopups)}}  </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Riwayat Tarik Tunai</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">  {{count($requestWithdrawals)}} </div>

                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- DataTables Topup Example -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Permintaan Top Up</h4>
                            <div class="data-tables">
                                <table id="table2" class="table table-bordered table-hover">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>No.</th>
                                            <th>Customer</th>
                                            <th>Rekening</th>
                                            <th>Nominal</th>
                                            <th>Kode Unik</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requestTopups as $i => $topup)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $topup->wallet->user->nama }}</td>
                                                <td>{{ $topup->rekening }}</td>
                                                <td>{{ $topup->nominal }}</td>
                                                <td>{{ $topup->kode_unik }}</td>
                                                <td>{{ $topup->status }}</td>
                                                <td class="col-2">
                                                    @if ($topup->status === 'menunggu')
                                                        <form action="{{ route('konfirmasi.topup', $topup->id) }}"
                                                            method="post" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm">Konfirmasi</button>
                                                        </form>

                                                        <form action="{{ route('tolak.topup', $topup->id) }}"
                                                            method="post" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Tolak</button>
                                                        </form>
                                                    @elseif($topup->status === 'dikonfirmasi')
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm col-12">{{ $topup->status }}</button>
                                                    @else
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm col-12">{{ $topup->status }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
               <!-- End DataTables Top Up Example -->

                <!-- DataTables Tarik Tunai Example -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Permintaan Tarik Tunai</h4>
                            <div class="data-tables">
                                <table id="table2" class="table table-bordered table-hover">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>No.</th>
                                            <th>Customer</th>
                                            <th>Rekening</th>
                                            <th>Nominal</th>
                                            <th>Kode Unik</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($requestWithdrawals as $i => $withdrawal)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $withdrawal->wallet->user->nama }}</td>
                                                    <td>{{ $withdrawal->rekening }}</td>
                                                    <td>{{ $withdrawal->nominal }}</td>
                                                    <td>{{ $withdrawal->kode_unik }}</td>
                                                    <td>{{ $withdrawal->status }}</td>
                                                    <td class="col-2">
                                                        @if ($withdrawal->status === 'menunggu')
                                                            <form
                                                                action="{{ route('konfirmasi.withdrawal', $withdrawal->id) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-sm">Konfirmasi</button>
                                                            </form>

                                                            <form
                                                                action="{{ route('tolak.withdrawal', $withdrawal->id) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Tolak</button>
                                                            </form>
                                                        @elseif($withdrawal->status === 'dikonfirmasi')
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm col-12">{{ $withdrawal->status }}</button>
                                                        @else
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm col-12">{{ $withdrawal->status }}</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End DataTables Tarik Tunai Example -->
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

@endsection