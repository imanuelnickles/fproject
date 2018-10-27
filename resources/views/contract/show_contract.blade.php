
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
                      <h5>test</h4>
                  </div>
                </div>
                <div>
                    <label>Tanggal Pembuatan Kontrak</label>
                    <div class="input-group">
                      <h5>test</h4>
                    </div>
                </div>
                <div>
                    <label>Tanggal Mulai</label>
                    <div class="input-group">
                      <h5>test</h4>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Selesai</label>
                    <div class="input-group">
                      <h5>test</h4>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }} has-feedback">
                    <label>Keterangan</label>
                    <div class="input-group">
                      <h5>test</h4>
                    </div>
                </div>
                
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