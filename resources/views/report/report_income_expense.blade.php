@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Laporan Pendapatan dan Pengeluaran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li>Pendapatan dan Pengeluaran</li>
      </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <div>
                <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Awal</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" id="start" name="start" value="{{ old('start') }}" class="form-control pull-right" id="datepicker">
                    </div>
                    @if ($errors->has('start'))
                        <span class="help-block">
                            <strong>{{ $errors->first('start') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('end') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Akhir</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" id="end" name="end" value="{{ old('end') }}" class="form-control pull-right" id="datepicker">
                    </div>
                    @if ($errors->has('end'))
                        <span class="help-block">
                            <strong>{{ $errors->first('end') }}</strong>
                        </span>
                    @endif
                </div>
                {{ csrf_field() }}
                
                <button type="button" onclick="myFunction()" class="btn btn-primary btn-lg">Tampilkan</button>
                {{ csrf_field() }}
            </div>
        </div>
    </div>
</section>

<script>
  function myFunction() {
    var start = document.getElementById("start").value;
    var end = document.getElementById("end").value;
    if (start != "" && end !="") {
      openInNewTab("/report/income-expense/view?start="+start+"&end="+end);
    }
  }

  function openInNewTab(url) {
    var a = document.createElement("a");
    a.target = "_blank";
    a.href = url;
    a.click();
  }
</script>
@endsection