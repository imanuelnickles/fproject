@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Daftar Kontrak
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Kontrak</a></li>
        <li class="active">Lihat Daftar</li>
      </ol>
</section>
<section class="content">
    
      <table id="dataTable5" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Property</th>
                <th>Tenant</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Contract Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contracts as $cn)
            <tr>
                <td>{{ $cn->name}}</td>
                
                <td>{{ $cn->title }} {{ $cn->first_name }} {{ $cn->last_name }}</td>
                <td>{{ $cn->start_date}}</td>
                <td>{{ $cn->end_date}}</td>
                <td>{{ $cn->contract_date}}</td>
                <td>
                    <a class="badge bg-yellow" href="{{ route('show_contract',['id'=>$cn->property_id,'contract_id'=>$cn->contract_id]) }}">
                        Lihat/ Tambah Pembayaran
                    </a>
                    <a class="badge bg-green" href="{{ route('generate_contract',['id'=>$cn->property_id,'contract_id'=>$cn->contract_id]) }}">
                        Generate Template Kontrak
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
      </table>
    
</section>
@endsection
@section('js')
<script src="{{ asset('js/tenant/data-table.js') }}"></script>
@endsection