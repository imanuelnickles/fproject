@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Ubah Data Pengeluaran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Properti</a></li>
        <li class="active">Detail Properti</li>
      </ol>
</section>
<section class="content">
    <div class="box box-danger">
        <div class="box-body">
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Nama Properti</label>
                    <div class="input-group">
                        <h4>{{ $property->name }}</h4>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback ">
                    <label>Nama Pengeluaran</label>

                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-wrench"></i>
                        </div>
                        <input type="text" name="name" value="{{ $outcome->name ? $outcome->name : old('name') }}" class="form-control">
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }} has-feedback">
                    <label>Jumlah</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                        </div>
                        <input type="text" name="amount" value="{{ $outcome->amount ? $outcome->amount : old('amount') }}" class="form-control">
                    </div>
                    @if ($errors->has('amount'))
                        <span class="help-block">
                            <strong>{{ $errors->first('amount') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('payment_date') ? ' has-error' : '' }} has-feedback">
                    <label>Jatuh Tempo</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" name="payment_date" value="{{ $outcome->payment_date ? $outcome->payment_date : old('payment_date') }}" class="form-control pull-right" id="datepicker">
                    </div>
                    @if ($errors->has('payment_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('payment_date') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} has-feedback">
                    <label>Status</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-info-sign"></i>
                        </div>
                        <select name="status" class="form-control">
                            <option value="0" {{$outcome->status==0?'selected':''}}>Belum Lunas</option>
                            <option value="1" {{$outcome->status==1?'selected':''}}>Lunas</option>
                        </select>
                    </div>
                    @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg">Simpan</button>
                <button type="button" onclick="event.preventDefault();
                  document.getElementById('delete-expenses').submit();" class="btn btn-block btn-danger btn-lg">Delete</button>
            </form>
            <form id="delete-expenses" method="POST" action="{{ route('delete_property_expenses',['id'=>$property->property_id,'expenses_id'=>$outcome->outcome_id])}}">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</section>
@endsection

@section('js')
@endsection