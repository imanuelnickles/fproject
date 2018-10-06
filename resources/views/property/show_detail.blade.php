@extends('root')
@section('content')
<section class="content-header">
      <h1>
        {{$property->name}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Properti</a></li>
        <li class="active">Detail Properti</li>
      </ol>
</section>
<section class="content">
  <div class="row">
  <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Info Properti</a></li>
              <li><a href="#tab_2" data-toggle="tab">Daftar Kontrak</a></li>
              <li><a href="#tab_3" data-toggle="tab">Daftar Pemasukan</a></li>
              <li><a href="#tab_4" data-toggle="tab">Daftar Pengeluaran</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                Info Property
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                Daftar Kontrak
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                Daftar Pemasukan
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                Daftar Pengeluaran
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
  </div>
</section>
@endsection