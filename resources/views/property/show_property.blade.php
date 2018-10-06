@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Daftar Properti
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Properti</a></li>
        <li class="active">Lihat Daftar</li>
      </ol>
</section>
<section class="content">
  <div class="row">
    @foreach($property as $t)
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->

      <div class="small-box {{ $t->occupied=== 1 ? 'bg-red' : 'bg-green' }}">
        <div class="inner">
          <h4>{{$t->name}}</h4>
          <p>Harga Sewa: Rp.{{$t->rent_price}},-</p>
        </div>
        <div class="icon">
          <i class="fa fa-home"></i>
        </div>
        <a href="{{route('show_detail_property',['id'=>$t->property_id])}}" class="small-box-footer">
          Lihat Detail Properti <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endsection