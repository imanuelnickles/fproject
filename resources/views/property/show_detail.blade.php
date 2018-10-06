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
              <li class="active" id="tab-tab_1"><a href="#tab_1" data-toggle="tab">Info Properti</a></li>
              <li id="tab-tab_2"><a href="#tab_2" data-toggle="tab">Daftar Kontrak</a></li>
              <li id="tab-tab_3"><a href="#tab_3" data-toggle="tab">Daftar Pemasukan</a></li>
              <li id="tab-pengeluaran"><a href="#pengeluaran" data-toggle="tab">Daftar Pengeluaran</a></li>
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
              <div class="tab-pane" id="pengeluaran">
                <div class="row">
                  <div class="col-md-2">
                    <a href="{{ route('property_expenses',['id'=>$property->property_id]) }}">
                      <button type="button" class="btn btn-primary btn-sm" >Tambah Pengeluaran</button>
                    </a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                  @include('property.expenses.expenses')
                  </div>
                </div>
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

@section('js')
  @if(session('open_tab'))
    <script>
      $(document).ready(function(){
        $('#tab_1').removeClass('active');
        $('#tab-tab_1').removeClass('active');
        $('#{{ session('open_tab') }}').addClass('active');
        $('#tab-{{ session('open_tab') }}').addClass('active');
      });
    </script>
  @endif
  <script src="{{ asset('js/tenant/data-table.js') }}"></script>
@endsection