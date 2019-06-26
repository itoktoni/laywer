@extends('auth.credential')
@section('content')


{!! Form::open(['class' => '']) !!}
{!! Form::text('email', null, ['autofocus', 'class' => 'fadeIn second', 'placeholder' => 'Email']) !!}
{!! Form::password('password', ['readonly onfocus=this.removeAttribute("readonly");', 'class' => 'fadeIn third', 'placeholder' => 'Password']) !!}

    <input type="submit" class="fadeIn fourth" value="Log In">
</form>

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