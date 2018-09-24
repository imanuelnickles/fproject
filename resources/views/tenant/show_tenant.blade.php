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
    <div class="row">
        @foreach($tenant as $t)
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="http://www.microsoft.com/en-us/research/wp-content/themes/microsoft-research-theme/assets/images/svg/icon-people-circle.svg" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
                <h3 class="widget-user-username">
                    {{$t->title}}
                    {{$t->first_name}}
                    {{$t->last_name}}
                </h3>
              <h5 class="widget-user-desc">{{$t->email}}</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">No. HP <span class="pull-right badge bg-blue">{{$t->mobile}}</span></a></li>
                <li><a href="#">No. Telp <span class="pull-right badge bg-aqua">{{$t->phone}}</span></a></li>
                <li><a class="pull-right badge bg-yellow" href="{{route('show_detail_tenant',['id'=>$t->tenant_id])}}">Lihat/Ubah</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        @endforeach
    </div>
</section>
@endsection