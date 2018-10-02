@extends('root')
@section('content')
    <!-- <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Properti</h3>
              <button type="button" class="btn btn-primary btn-sm" style="float:right;">Tambah Properti Baru</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Tipe</th>
                  <th>Status</th>
                  <th style="width:95px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Kos 39z</td>
                  <td>Gang keluarga</td>
                  <td>Kos</td>
                  <td>Berjalan</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-eye"></i></button>
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Tesla</td>
                  <td>Tesla Selatan 10 no 6</td>
                  <td>Kontrakan</td>
                  <td>Tersewa</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-eye"></i></button>
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></button>
                    </div>
                  </td>
                </tr>
                
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    @endsection