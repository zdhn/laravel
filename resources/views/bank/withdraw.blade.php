@extends('layout.main')

@section('content')
<!-- main content area start -->


<!-- data table start -->

<!-- data table end -->

<!-- data table start -->
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
                        @foreach($withdrawals as $i => $withdrawal)
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
                                            <button type="submit" class="btn btn-primary btn-sm">Konfirmasi</button>
                                        </form>

                                        <form
                                            action="{{ route('tolak.withdrawal', $withdrawal->id) }}"
                                            method="post" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                        <blade
                                            elseif|(%24withdrawal-%3Estatus%20%3D%3D%3D%20%26%2339%3Bdikonfirmasi%26%2339%3B)%0D />
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
<!-- data table end -->
</div>
</div>
<!-- sales report area end -->
</div>
</div>
<!-- main content area end -->
@endsection
