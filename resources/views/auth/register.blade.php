@extends('auth.credential')
@section('content')
{!! Form::open(['class' => 'login100-form validate-form']) !!}  

    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
         {!! Form::text('name', null, ['class' => 'input100', 'placeholder' => 'Full Name']) !!}
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
    </div>
    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
       {!! Form::email('email', null, ['class' => 'input100', 'placeholder' => 'Email']) !!}
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
    </div>
    <div class="wrap-input100 validate-input" data-validate="Password is required">
        {!! Form::password('password', ['readonly onfocus=this.removeAttribute("readonly");', 'class' => 'input100', 'placeholder' => 'Password']) !!}
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
    </div>
    <div class="wrap-input100 validate-input" data-validate="Password is required">
        {!! Form::password('password_confirmation', ['readonly onfocus=this.removeAttribute("readonly");', 'class' => 'input100', 'placeholder' => 'Password']) !!}
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
    </div>
     <input type="submit" class="fadeIn fourth" value="Register">
    <div style="height: 50px;margin-top: -10px;font-size: 12px;" class="text-center p-t-12">
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