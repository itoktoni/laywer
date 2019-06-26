@extends('layouts.credential')
@section('content')
<div class="panel panel-sign">
    <div class="panel-title-sign mt-xl text-right">
        <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Recover Password</h2>
    </div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-info">
            <p class="m-none text-weight-semibold h6">{{ session('status') }}</p>   
        </div>
        @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
            {{ csrf_field() }}
            <div class="form-group mb-none {{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="input-group">
                    <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">Reset!</button>
                    </span>
                </div>
            </div>
            <p class="text-left mt-lg">Ingin Login Kembali ? <a href="{{ url('/login') }}">Sign In!</a>
        </form>
    </div>
</div>
@endsection
