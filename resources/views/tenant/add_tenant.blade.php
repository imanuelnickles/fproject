@extends('root')
@section('content')
<section class="content-header">
      <h1>
        Tambah Baru Penyewa
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Penyewa</a></li>
        <li class="active">Tambah Baru</li>
      </ol>
</section>
<section class="content">
        <div class="box box-danger">
            <!-- <div class="box-header">
                <h3 class="box-title">Input masks</h3>
            </div> -->
            <div class="box-body">
                <form method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Titel</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <select name="title" class="form-control" required>
                                <option>Bapak</option>
                                <option>Ibu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label>Nama Depan</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <input type="text" name="first-name" class="form-control" required>
                        </div>
                        <!-- <span class="help-block">
                            <strong>Error!</strong>
                        </span> -->
                    </div>
                    <div class="form-group">
                        <label>Nama Belakang</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <input type="text" name="last-name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="	glyphicon glyphicon-envelope"></i>
                            </div>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nomor HP</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-phone"></i>
                            </div>
                            <input type="text" name="mobile" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Telepon</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-earphone"></i>
                            </div>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" name="dob" class="form-control pull-right" id="datepicker" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No. KTP</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-info-sign"></i>
                            </div>
                            <input type="text" name="id-number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-home"></i>
                            </div>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="glyphicon glyphicon-tag"></i>
                            </div>
                            <input type="text" name="notes" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary btn-lg">Simpan</button>
                </form>    
            </div>
        </div>
</section>            
@endsection