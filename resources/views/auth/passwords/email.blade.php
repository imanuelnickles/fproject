@extends('layouts.app')

@section('content')
<div class="login-box-body">
    <p class="login-box-msg">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input type="email" name="email" class="form-control" placeholder="Email"  value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
    </form>
</div>
@endsection
