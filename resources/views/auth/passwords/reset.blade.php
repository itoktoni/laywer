@extends('auth.credential')

@section('content')
<div class="panel panel-sign">
    <div class="panel-title-sign mt-xl text-right">
        <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i>Reset Password</h2>
    </div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="{{ route('resetpassword') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group mb-lg {{ $errors->has('email') ? ' has-error' : '' }}{{ $errors->has('email') ? ' has-error' : '' }}">
                <label>Email</label>
                <div class="input-group input-group-icon">
                    <input id="email" type="email" class="form-control" placeholder="masukan email" name="email" value="{{ $email or old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group mb-lg {{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="clearfix">
                    <label class="pull-left">Password</label>
                </div>
                <div class="input-group input-group-icon">
                    <input name="password" placeholder="masukan password" type="password" class="form-control" />
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group mb-lg {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <div class="clearfix">
                    <label class="pull-left">Password Confirm</label>

                </div>
                <div class="input-group input-group-icon">
                    <input id="password-confirm" placeholder="masukan password lagi" type="password" class="form-control" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-right">
                    <div class="btn-group">
                        <a class="btn btn-warning" href="{{ route('login') }}">
                            Ingin Login ?
                        </a>
                        <button type="submit" class="btn btn-primary pull-right">Reset</button>
                    </div>


                </div>
            </div>
        </form>
    </div>
</div>



@endsection
