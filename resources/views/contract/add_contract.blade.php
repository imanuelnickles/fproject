
@extends('root')
@section('content')


<section class="content-header">
      <h1>
        Tambah Kontrak Baru
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Properti</a></li>
        <li class="active">Detail Properti</li>
        <li class="active">Tambah Kontrak</li>
      </ol>
</section>
<section class="content">
    <div class="box box-danger">
        <div class="box-body control">
            <div class="controls"> 
            <form method="POST">
                <input type="text" name="property_id" value="{{$property_id}}" hidden>
                {{ csrf_field() }}
                <div class="form-group" id="form-html">
                    <label>Nama Properti</label>
                    <div class="input-group">
                        <h4>{{ $property->name }}</h4>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tenant_id') ? ' has-error' : '' }} has-feedback ">
                  <label>Penyewa</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <select class="form-control select2" style="width: 100%; height: 34px;" name="tenant_id">
                      @foreach($tenant as $t)
                        <option value="{{$t->tenant_id}}">{{$t->first_name}} {{$t->last_name}}</option>
                      @endforeach
                    </select>    
                  </div>
                </div>
                <div class="form-group{{ $errors->has('contract_date') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Pembuatan Kontrak</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" name="contract_date" value="{{ old('contract_date') }}" class="form-control pull-right" id="datepicker">
                    </div>
                    @if ($errors->has('contract_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contract_date') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Mulai</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control pull-right" id="datepicker">
                    </div>
                    @if ($errors->has('start_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('start_date') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }} has-feedback">
                    <label>Tanggal Selesai</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control pull-right" id="datepicker">
                    </div>
                    @if ($errors->has('end_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('end_date') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }} has-feedback">
                    <label>Keterangan</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </div>
                        <textarea class="form-control" rows="5" id="notes" name="notes" value="{{old('notes')}}"></textarea>
                    </div>
                    @if ($errors->has('notes'))
                    <span class="help-block">
                        <strong>{{ $errors->first('notes') }}</strong>
                    </span>
                    @endif
                </div>
                <hr>
                @if ($errors->has('amount.*'))
                <span class="help-block" style="color:red;">
                    <strong>{{ $errors->first('amount.*') }}</strong>
                </span>
                @endif
                <div class="form-group">
                    <div class="entry input-group col-sm-12">
                        <div class="col-sm-6" style="padding-left:0;">
                            <label> Pembayaran </label>
                            <input class="form-control" name="amount[]" type="number" placeholder="Pembayaran" />
                        </div>
                        <div class="col-sm-5">
                            <label> Jatuh Tempo </label>
                            <input type="date" name="deadline[]" value="" class="form-control pull-right" id="datepicker">
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-success btn-add" type="button" style="margin-top:25px;">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="button-submit-container">
                    <button type="submit" class="btn btn-block btn-primary btn-lg">Simpan</button>
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
    $('.select2').select2()
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls form:first'),
            currentEntry = $(this).parents('.form-group:first'),
           
            newEntry = $(currentEntry.clone()).insertBefore("#button-submit-container");
        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.entry:first').remove();
        e.preventDefault();
        return false;
    });
    $(document).ready(function(){
     
    });
  </script>

@endsection