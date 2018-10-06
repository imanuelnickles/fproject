@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Ubah Data Properti
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Properti</a></li>
        <li class="active">Ubah Data Property</li>
      </ol>
</section>
<section class="content">
  <div class="box box-danger">            
    <div class="box-body">
      <form method="POST">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback ">
              <label>Nama</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                  </div>
                  <input type="text" name="name" value="{{ old('name')==NULL ? $property->name : old('name') }}" class="form-control">
              </div>
              @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
            <div class="col-md-6" style="padding-left: 0 !important;">
              <div class="form-group">
                <label>Negara</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-flag"></i>
                    </div>
                    <input type="text" name="country" value="{{ old('country')==NULL ? $property->country : old('country') }}" class="form-control">
                </div>
              </div>
            </div>
            
            <div class="col-md-6" style="padding-right: 0 !important;">
              <div class="form-group">
                <label>Kota</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-home"></i>
                    </div>
                    <input type="text" name="city" value="{{ old('city')==NULL ? $property->city : old('city') }}" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} has-feedback">
              <label>Alamat</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-road"></i>
                  </div>
                  <textarea class="form-control" rows="5" id="address" name="address">{{ old('address')==NULL ? $property->address : old('address') }}</textarea>
              </div>
              @if ($errors->has('address'))
              <span class="help-block">
                  <strong>{{ $errors->first('address') }}</strong>
              </span>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Kode Pos</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-search"></i>
                  </div>
                  <input type="text" name="post_code" value="{{ old('post_code')==NULL ? $property->post_code : old('post_code') }}" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tipe Properti</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-tag"></i>
                  </div>
                  <input type="text" name="property_type" value="{{ old('property_type')==NULL ? $property->property_type : old('property_type') }}" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group{{ $errors->has('total_floor') ? ' has-error' : '' }} has-feedback">
              <label>Jumlah Lantai</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-plus"></i>
                  </div>
                  <input type="number" name="total_floor" value="{{ old('total_floor')==NULL ? $property->total_floor : old('total_floor') }}" class="form-control">
              </div>
              @if ($errors->has('total_floor'))
              <span class="help-block">
                  <strong>{{ $errors->first('total_floor') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group{{ $errors->has('total_bedrooms') ? ' has-error' : '' }} has-feedback">
              <label>Jumlah Kamar</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-plus"></i>
                  </div>
                  <input type="number" name="total_bedrooms" value="{{ old('total_bedrooms')==NULL ? $property->total_bedrooms : old('total_bedrooms') }}" class="form-control">
              </div>
              @if ($errors->has('total_bedrooms'))
              <span class="help-block">
                  <strong>{{ $errors->first('total_bedrooms') }}</strong>
              </span>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Luas Bangunan</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-resize-full"></i>
                  </div>
                  <input type="text" name="building_area" value="{{ old('building_area')==NULL ? $property->building_area : old('building_area') }}" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Luas Tanah</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-resize-full"></i>
                  </div>
                  <input type="text" name="surface_area" value="{{ old('surface_area')==NULL ? $property->surface_area : old('surface_area') }}" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group{{ $errors->has('purchase_date') ? ' has-error' : '' }} has-feedback">
              <label>Tanggal Pembelian</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="date" name="purchase_date" value="{{ old('purchase_date')==NULL ? $property->purchase_date : old('purchase_date') }}" class="form-control pull-right" id="datepicker">
              </div>
              @if ($errors->has('purchase_date'))
              <span class="help-block">
                  <strong>{{ $errors->first('purchase_date') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group{{ $errors->has('purchase_price') ? ' has-error' : '' }} has-feedback">
              <label>Harga Beli</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </div>
                  <input type="text" name="purchase_price" value="{{ old('purchase_price')==NULL ? $property->purchase_price : old('purchase_price') }}" class="form-control">
              </div>
              @if ($errors->has('purchase_price'))
              <span class="help-block">
                  <strong>{{ $errors->first('purchase_price') }}</strong>
              </span>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Fasilitas</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-thumbs-up"></i>
                  </div>
                  <textarea class="form-control" rows="5" id="notes" name="notes">{{ old('notes')==NULL ? $property->notes : old('notes') }}</textarea>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="col-md-6" style="padding-left: 0 !important;">
              <div class="form-group{{ $errors->has('tax') ? ' has-error' : '' }} has-feedback">
                <label>PBB</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </div>
                    <input type="text" name="tax" value="{{ old('tax')==NULL ? $property->tax : old('tax') }}" class="form-control">
                </div>
                @if ($errors->has('tax'))
                <span class="help-block">
                    <strong>{{ $errors->first('tax') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            <div class="col-md-6" style="padding-right: 0 !important;">
              <div class="form-group{{ $errors->has('valuation') ? ' has-error' : '' }} has-feedback">
                <label>Valuasi Sekarang</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </div>
                    <input type="text" name="valuation" value="{{ old('valuation')==NULL ? $property->valuation : old('valuation') }}" class="form-control">
                </div>
                @if ($errors->has('valuation'))
                <span class="help-block">
                    <strong>{{ $errors->first('valuation') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6" style="padding-left: 0 !important;">
              <div class="form-group{{ $errors->has('rent_price') ? ' has-error' : '' }} has-feedback">
                <label>Harga Sewa</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </div>
                    <input type="text" name="rent_price" value="{{ old('rent_price')==NULL ? $property->rent_price : old('rent_price') }}" class="form-control">
                </div>
                @if ($errors->has('rent_price'))
                <span class="help-block">
                    <strong>{{ $errors->first('rent_price') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6" style="padding-right: 0 !important;">
              <div class="form-group">
                <label>Status</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <select class="form-control" id="sel1" name="occupied">
                      <option value="0" {{ $property->occupied=== 0 ? 'selected' : '' }}>Kosong</option>
                      <option value="1" {{ $property->occupied=== 1 ? 'selected' : '' }}>Isi</option>
                    </select>
                </div>
                @if ($errors->has('rent_price'))
                <span class="help-block">
                    <strong>{{ $errors->first('rent_price') }}</strong>
                </span>
                @endif
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-block btn-primary btn-lg">Simpan</button>
      </form>    
    </div>
  </div>
</section>            
@endsection