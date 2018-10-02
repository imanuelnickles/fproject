@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Tambah Baru Properti
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Properti</a></li>
        <li class="active">Tambah Baru</li>
      </ol>
</section>
<section class="content">
  <div class="box box-danger">            
    <div class="box-body">
      <form method="POST">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Nama</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                  </div>
                  <input type="text" name="name" value="{{ old('name') }}" class="form-control">
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
                    <input type="text" name="negara" value="{{ old('negara') }}" class="form-control">
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
                    <input type="text" name="kota" value="{{ old('kota') }}" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Alamat</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-road"></i>
                  </div>
                  <textarea class="form-control" rows="5" id="Address"></textarea>
              </div>
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
                  <input type="text" name="kodePos" value="{{ old('kodePos') }}" class="form-control">
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
                  <input type="text" name="tipeProperti" value="{{ old('tipeProperti') }}" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Jumlah Lantai</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-plus"></i>
                  </div>
                  <input type="text" name="jumlahLantai" value="{{ old('jumlahLantai') }}" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Jumlah Kamar</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-plus"></i>
                  </div>
                  <input type="text" name="jumlahKamar" value="{{ old('jumlahKamar') }}" class="form-control">
              </div>
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
                  <input type="text" name="luasBangunan" value="{{ old('luasBangunan') }}" class="form-control">
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
                  <input type="text" name="luasTanah" value="{{ old('luasTanah') }}" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tanggal Pembelian</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="date" name="tanggalPembelian" value="{{ old('tanggalPembelian') }}" class="form-control pull-right" id="datepicker">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Harga Beli</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </div>
                  <input type="text" name="hargaBeli" value="{{ old('hargaBeli') }}" class="form-control">
              </div>
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
                  <textarea class="form-control" rows="5" id="Fasilitas"></textarea>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="col-md-6" style="padding-left: 0 !important;">
              <div class="form-group">
                <label>PBB</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </div>
                    <input type="text" name="PBB" value="{{ old('PBB') }}" class="form-control">
                </div>
              </div>
            </div>
            
            <div class="col-md-6" style="padding-right: 0 !important;">
              <div class="form-group">
                <label>Valuasi Sekarang</label>
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </div>
                    <input type="text" name="valuasi" value="{{ old('valuasi') }}" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Harga Sewa</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </div>
                  <input type="text" name="hargaSewa" value="{{ old('hargaSewa') }}" class="form-control">
              </div>
              @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-block btn-primary btn-lg">Simpan</button>
      </form>    
    </div>
  </div>
</section>            
@endsection