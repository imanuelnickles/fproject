@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Lihat Detail Penyewa
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Penyewa</a></li>
        <li>Lihat Daftar</li>
        <li>Lihat Detail</li>
      </ol>
</section>
<section class="content">
<div class="box box-danger">
            <!-- <div class="box-header">
                <h3 class="box-title">Input masks</h3>
            </div> -->
            <div class="box-body">
                <form method="POST"  enctype="multipart/form-data" action="{{ route('update_tenant',['id'=>$tenant->tenant_id]) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Titel</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <select name="title" class="form-control">
                                <option {{$tenant->title=='Bapak'?'selected':''}} >Bapak</option>
                                <option {{$tenant->title=='Ibu'?'selected':''}} >Ibu</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('first-name') ? ' has-error' : '' }} has-feedback ">
                        <label>Nama Depan</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <input type="text" name="first-name" value="{{ old('first-name')==NULL ? $tenant->first_name : old('first-name') }}" class="form-control">
                        </div>
                        @if ($errors->has('first-name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first-name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('last-name') ? ' has-error' : '' }} has-feedback">
                        <label>Nama Belakang</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <input type="text" name="last-name" value="{{ old('last-name')==NULL ? $tenant->last_name : old('last-name') }}" class="form-control">
                        </div>
                        @if ($errors->has('last-name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last-name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                        <label>Email</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="	glyphicon glyphicon-envelope"></i>
                            </div>
                            <input type="text" name="email" value="{{ old('email')==NULL ? $tenant->email : old('email') }}" class="form-control">
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }} has-feedback">
                        <label>Nomor HP</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-phone"></i>
                            </div>
                            <input type="text" name="mobile" value="{{ old('mobile')==NULL ? $tenant->mobile : old('mobile') }}" class="form-control">
                        </div>
                        @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} has-feedback">
                        <label>Telepon</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-earphone"></i>
                            </div>
                            <input type="text" name="phone" value="{{ old('phone')==NULL ? $tenant->phone : old('phone') }}" class="form-control">
                        </div>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }} has-feedback">
                        <label>Tanggal Lahir</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" name="dob" value="{{ old('dob')==NULL ? $tenant->dob : old('dob') }}" class="form-control pull-right" id="datepicker">
                        </div>
                        @if ($errors->has('dob'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('id-number') ? ' has-error' : '' }} has-feedback">
                        <label>No. KTP</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-info-sign"></i>
                            </div>
                            <input type="text" name="id-number" value="{{ old('id-number')==NULL ? $tenant->id_number : old('id-number') }}" class="form-control">
                        </div>
                        @if ($errors->has('id-number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('id-number') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('id-pic') ? ' has-error' : '' }} has-feedback">
                        <label>Foto KTP</label>
                        <div>
                            <img class="img-thumbnail" style="margin-bottom:1%;max-width:360px" src="{{ $tenant->id_picture }}">
                        </div>
                        <div class="input-group">
                            <input type="file" name="id-pic" value="{{ old('id-pic') }}" class="form-control">
                        </div>
                        @if ($errors->has('id-pic'))
                            <span class="help-block">
                                <strong>{{ $errors->first('id-pic') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} has-feedback">
                        <label>Alamat</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-home"></i>
                            </div>
                            <input type="text" name="address" value="{{ old('address')==NULL ? $tenant->address : old('address') }}" class="form-control">
                        </div>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-tag"></i>
                            </div>
                            <input type="text" name="notes" value="{{ old('notes')==NULL ? $tenant->notes : old('notes') }}" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary btn-lg">Simpan</button>
                    <button type="button" onclick="event.preventDefault();
                  document.getElementById('delete-tenant').submit();" class="btn btn-block btn-danger btn-lg">Delete</button>
                </form> 
                <form id="delete-tenant" method="POST" action="{{ route('delete_tenant',['id'=>$tenant->tenant_id])}}">
                {{ csrf_field() }}
                </form>
            </div>
        </div>
</section>
@endsection