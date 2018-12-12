@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Laporan Pendapatan Mendatang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li>Pendapatan Mendatang</li>
      </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <div>
                <div class="form-group{{ $errors->has('cutoff') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Cut Off</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" id="cutoff" name="cutoff" value="{{ old('cutoff') }}" class="form-control pull-right" id="datepicker">
                    </div>
                    @if ($errors->has('cutoff'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cutoff') }}</strong>
                        </span>
                    @endif
                </div>
                
                <button type="button" onclick="myFunction()" class="btn btn-primary btn-lg">Tampilkan</button>
                {{ csrf_field() }}
            </div>
        </div>
    </div>
</section>

<script>
  function myFunction() {
    var cutoff = document.getElementById("cutoff").value;
    
    if (cutoff != "") {
      openInNewTab("/report/upcoming-income/view?cutoff="+cutoff);
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