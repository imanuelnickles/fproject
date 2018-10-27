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
                <div class="row">
                  
                  <div class="col-md-2">
                    <a href="{{route('edit_property',['id'=>$property->property_id])}}" class="small-box-footer">
                      <button type="button" class="btn btn-block btn-primary btn-sm">Ubah Data Properti</button>
                    </a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama</label>
                      <div class="input-group">
                          <div class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                          </div>
                          <input readonly type="text" name="name" value="{{ $property->name }}" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-left: 0 !important;">
                      <div class="form-group">
                        <label>Negara</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="glyphicon glyphicon-flag"></i>
                            </div>
                            <input readonly type="text" name="country" value="{{ $property->country }}" class="form-control">
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
                            <input readonly type="text" name="city" value="{{ $property->city }}" class="form-control">
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
                          <textarea readonly class="form-control" rows="5" id="address" name="address">{{$property->address}}</textarea>
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
                          <input readonly type="text" name="post_code" value="{{ $property->post_code }}" class="form-control">
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
                          <input readonly type="text" name="property_type" value="{{ $property->property_type }}" class="form-control">
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
                          <input readonly type="number" name="total_floor" value="{{ $property->total_floor }}" class="form-control">
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
                          <input readonly type="number" name="total_bedrooms" value="{{ $property->total_bedrooms }}" class="form-control">
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
                          <input readonly type="text" name="building_area" value="{{ $property->building_area }}" class="form-control">
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
                          <input readonly type="text" name="surface_area" value="{{ $property->surface_area }}" class="form-control">
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
                        <input readonly type="date" name="purchase_date" value="{{ $property->purchase_date }}" class="form-control pull-right" id="datepicker">
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
                          <input readonly type="text" name="purchase_price" value="{{ $property->purchase_price }}" class="form-control">
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
                          <textarea readonly class="form-control" rows="5" id="notes" name="notes">{{ $property->notes }}</textarea>
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
                            <input readonly type="text" name="tax" value="{{ $property->tax }}" class="form-control">
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
                            <input readonly type="text" name="valuation" value="{{ $property->valuation }}" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-left: 0 !important;">
                      <div class="form-group">
                        <label>Harga Sewa</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="glyphicon glyphicon-usd"></i>
                            </div>
                            <input readonly type="text" name="rent_price" value="{{ $property->rent_price }}" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-right: 0 !important;">
                      <div class="form-group">
                        <label>Status</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <select readonly class="form-control" id="sel1" name="occupied">
                              <option value="0" {{ $property->occupied=== 0 ? 'selected' : '' }}>Kosong</option>
                              <option value="1" {{ $property->occupied=== 1 ? 'selected' : '' }}>Isi</option>
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_2">
                <div class="row">
                  
                  <div class="col-md-2">
                    <a href="{{ route('add_contract',['id'=>$property->property_id]) }}" class="small-box-footer">
                      <button type="button" class="btn btn-block btn-primary btn-sm">Tambah Kontrak</button>
                    </a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                  @include('contract.contracts')
                  </div>
                </div>
              </div>

              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <div class="row">
                  <div class="col-md-12">
                  @include('.payment.payments')
                  </div>
                </div>
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