@extends('root_admin')
@section('content')
<section class="content-header">
      <h1>
        Lihat Detail User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li>User</li>
        <li>Lihat Detail</li>
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
                        <label>Nama</label>
                        <div class="input-group">                           
                        <span>{{ $user->name }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">                           
                        <span>{{ $user->email }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <div class="input-group">                           
                        <span>{{ $user->role==2?'Admin':'User' }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="input-group">                           
                        <span>{{ $user->blocked_on!=NULL?'Banned':'Active' }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Registered Date</label>
                        <div class="input-group">                           
                        <span>{{ $user->created_at }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subscription</label>
                        <div class="input-group">                           
                        <span>
                            {{ $is_sub_expired ? 'Expired' : 'Active'}}
                        </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('subscription') ? ' has-error' : '' }} has-feedback">
                        <label>Update Subscription</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="	glyphicon glyphicon-calendar"></i>
                            </div>
                            <input type="date" name="subscription" value="{{ old('subscription')==NULL ? $user->subscription->end_date : old('subscription') }}" class="form-control">
                        </div>
                        @if ($errors->has('subscription'))
                            <span class="help-block">
                                <strong>{{ $errors->first('subscription') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-block btn-info btn-lg">Update</button>
                    <button type="button" onclick="event.preventDefault();
                  document.getElementById('ban-user').submit();" class="btn btn-block btn-danger btn-lg">
                  {{ $user->blocked_on ==NULL ? 'Ban' : 'Unban' }}
                  </button>
                </form> 
                <form id="ban-user" method="POST" action="{{ route('admin_user_ban',['id'=>$user->id])}}">
                {{ csrf_field() }}
                </form>
            </div>
        </div>
</section>
@endsection

@section('js')

@endsection