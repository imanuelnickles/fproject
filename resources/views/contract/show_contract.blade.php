
@extends('root')
@section('content')


<section class="content-header">
      <h1>
        Kontrak Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Properti</a></li>
        <li class="active">Detail Properti</li>
        <li class="active">Kontrak Detail</li>
      </ol>
</section>
<section class="content">
    <div class="box box-danger">
        <div class="box-body control">
            <div class="controls"> 
            <form method="POST">
                <div class="form-group" id="form-html">
                    <label>Nama Properti</label>
                    <div class="input-group">
                        <h4>{{ $property->name }}</h4>
                    </div>
                </div>
                
                <div>
                  <label>Penyewa</label>
                  <div class="input-group">
                      <h5>{{ $contract->tenant->title }} {{ $contract->tenant->first_name }} {{ $contract->tenant->last_name }}</h4>
                  </div>
                </div>
                <div>
                    <label>Tanggal Pembuatan Kontrak</label>
                    <div class="input-group">
                      <h5>{{ $contract->contract_date }}</h5>
                    </div>
                </div>
                <div>
                    <label>Tanggal Mulai</label>
                    <div class="input-group">
                    <h5>{{ $contract->start_date }}</h5>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Selesai</label>
                    <div class="input-group">
                    <h5>{{ $contract->end_date }}</h5>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }} has-feedback">
                    <label>Keterangan</label>
                    <div class="input-group">
                        <h5>{{ $contract->notes }}</h4>
                    </div>
                </div>
                <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Jumlah</th>
                            <th>Jatuh Tempo</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($payment_term as $o)
                        <tr>
                            <td>{{ $o->amount }}</td>
                            <td>{{ $o->deadline }}</td>
                            <td>{{ $o->payment_date }}</td>
                            @if($o->payment_date == null)
                            <td>
                                <a class="badge bg-yellow" href="{{ route('add_payment',['id'=>$property->property_id,'payment_term_id'=>$o->payment_term_id]) }}">
                                    Lakukan Pembayaran
                                </a>
                            </td>
                            @else
                            <td>
                                <a class="badge bg-green" href="{{ route('show_payment',['id'=>$property->property_id,'payment_term_id'=>$o->payment_term_id, 'payment_id'=>$o->payment[0]->payment_id]) }}">
                                    Lihat Detail Pembayaran
                                </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
            </table>
            </form>   
            </div> 
        </div>
    </div>
</section>
@endsection

@section('js')
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <script src="{{ asset('js/select2.full.min.js') }}"></script>
  <script>
    
  </script>

@endsection