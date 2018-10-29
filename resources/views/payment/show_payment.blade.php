
@extends('root')
@section('content')


<section class="content-header">
      <h1>
        Pembayaran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Pembayaran</a></li>
        <li class="active">Detail Properti</li>
        <li class="active">Pembayaran</li>
      </ol>
</section>
<section class="content">
    <div class="box box-danger">
        <div class="box-body control">
            <div class="controls"> 
            <form method="POST">
                <input type="text" name="payment_term_id" value="{{$payment_term->payment_term_id}}" hidden>
                <input type="text" name="tenant_id" value="{{$payment_term->contract->tenant->tenant_id}}" hidden>
                <input type="text" name="amount" value="{{ $payment_term->amount }}" hidden>
                {{ csrf_field() }}
                <div class="form-group" id="form-html">
                    <label>Nama Properti</label>
                    <div class="input-group">
                        <h4>{{ $property->name }}</h4>
                    </div>
                </div>
                <div class="">
                  <label>Penyewa</label>
                  <div class="input-group">
                    <h5>{{ $payment_term->contract->tenant->title }} {{ $payment_term->contract->tenant->first_name }} {{ $payment_term->contract->tenant->last_name }}</h5>
                  </div>
                </div>

                <div class="">
                  <label>Jumlah Pembayaran</label>
                  <div class="input-group">
                    <h5>{{ $payment_term->amount }}</h5>
                  </div>
                </div>

                <div>
                  <label>Deadline</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" name="payment_date" value="{{ $payment_term->deadline }}" class="form-control pull-right" id="datepicker" readonly>
                  </div>
                </div>
                
                <div class="form-group{{ $errors->has('payment_date') ? ' has-error' : '' }} has-feedback" style="margin-top:25px;">
                  <label>Tanggal Pembayaran</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" name="payment_date" value="{{ $payment->payment_date }}" class="form-control pull-right" id="datepicker" readonly>
                  </div>
                  @if ($errors->has('payment_date'))
                  <span class="help-block">
                      <strong>{{ $errors->first('payment_date') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Tipe Pembayaran</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-circle-arrow-up"></i>
                      </div>
                      <select class="form-control" id="sel1" name="payment_type" disabled>
                        
                        <option value="Transfer"  {{ ($payment->payment_type) == "Transfer" ? "selected" : "" }}>Transfer</option>
                        <option value="Tunai" {{ ($payment->payment_type) == "Tunai" ? "selected" : "" }}>Tunai</option>
                      </select>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }} has-feedback">
                  <label>Notes</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-thumbs-up"></i>
                      </div>
                      <textarea readonly class="form-control" rows="5" id="notes" name="notes" value="">{{ $payment->notes }}</textarea>
                  </div>
                  @if ($errors->has('notes'))
                  <span class="help-block">
                      <strong>{{ $errors->first('notes') }}</strong>
                  </span>
                  @endif
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
    
    $(document).ready(function(){
     
    });
  </script>

@endsection