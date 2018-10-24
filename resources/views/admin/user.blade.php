@extends('root_admin')
@section('content')
<section class="content-header">
      <h1>
        Daftar User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">User</li>
      </ol>
</section>
<section class="content">
<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($user as $u)
            <tr>
                <td>{{$u->name}}</td>
                <td>{{$u->email}}</td>
                <td>
                  {{$u->role==1?'User':'Admin'}}
                </td>
                <td>{{$u->blocked_on != null?'Banned':'Active'}}</td>
                <td>
                    <a class="badge bg-yellow" href="{{ route('admin_user_detail',['id'=>$u->id]) }}">
                        Lihat
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
</table>
</section>
@endsection

@section('js')
<script>
$(document).ready(function() {
  $('#dataTable').DataTable();
});
</script>
@endsection