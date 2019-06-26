@extends('auth.credential')
@section('content')

{!! Form::open(['route' => 'lock','class' => 'login100-form validate-form']) !!}  
    <span class="login100-form-title">
        {{ config('website.name') }}
        <br> 
        Reset Password
    </span>
    <div style="margin-top: -20px" class="text-center">
        @if(Auth::user()->photo == '')
        <img src="{{ Helper::files('profile/default_profile.png') }}" class="rounded-circle" />
        @else
        <img src="{{ Helper::files('profile/'.Auth::user()->photo) }}" class="rounded-circle" />
        @endif
        <h2 style="margin: -20px 0px -30px 0px" class="login100-form-title">{{ Auth::user()->name }}</h2>
    </div>

    @if(session()->has('sukses'))
    <div class="text-center help-block alert-{{ session()->get('sukses') == true ? 'success' : 'danger' }}">
        {{ session()->get('sukses') == true ? 'Password Has Been Change !' : 'Password Failed To Change !' }}
    </div>
    @endif
    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
        {!! Form::text('email', null, ['class' => 'input100', 'placeholder' => 'Email']) !!}
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
    </div>
    
    <div style="height: 50px;margin-top: -10px;font-size: 12px;" class="text-center p-t-10">
        @if ($errors->any())
             @foreach ($errors->all() as $error)
                 <span class="help-block text-danger">
                    <strong>{{ $error }}</strong>
                </span>
             @endforeach
         @endif
    </div>
{!! Form::close() !!}
@endsection
