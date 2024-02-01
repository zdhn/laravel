@extends('layout.main')

@section('content')
    

<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="page-title mb-0 p-0">{{ $title }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Riwayat Top Up</h4>
                    <div class="list-group list-group-flush">
                        @foreach( $topups as $topup )
                            <h6 class="bg-body-tertary p-2 border-top border-bottom">{{ $topup->tanggal}}
                                <span class="float-end">Rp. {{number_format($topup->nominal,0,',','.')}}</span>
                            </h6>
                            @php
                                $topupList = App\Models\TopUp::where(DB::raw('DATE(created_at)'), $topup->tanggal)
                                // ->where('rekening', $wallet->rekening)
                                ->orderBy('created_at', 'desc')
                                ->get();
                            @endphp

                            <ul class="list-group list-group-light mb-4">
                                @foreach ($topupList as $list)
                                    <a href="{{ route('topup.detail', $topup->tanggal)}}">
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center col-12">
                                                <div class="ms-3 col-12">
                                                    <p class="fw-bold mb-1 me-3">{{ $list->kode_unik}}<span class="float-end">{{ $list->created_at}}</span>
                                                    </p>
                                                    <p class="text-muted mb-0">Rp.
                                                        {{ number_format($list->nominal, 2, ',', '.')}}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection