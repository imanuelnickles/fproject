@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Daftar Penyewa
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Penyewa</a></li>
        <li class="active">Lihat Daftar</li>
      </ol>
</section>
<section class="content">
<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>No. Telp</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tenant as $t)
            <tr>
                <td>
                    {{$t->title}}
                    {{$t->first_name}}
                    {{$t->last_name}}
                </td>
                <td>{{$t->email}}</td>
                <td>{{$t->mobile}}</td>
                <td>{{$t->phone}}</td>
                <td>
                    <a class="badge bg-yellow" href="{{route('show_detail_tenant',['id'=>$t->tenant_id])}}">
                        Lihat/Ubah
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