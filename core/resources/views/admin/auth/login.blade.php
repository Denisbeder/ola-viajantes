@extends('admin.__default')

@section('content')


<form class="form-horizontal w-100" method="POST" action="">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }}">
        <label for="identity" class="text-normal text-dark">Usuário ou E-mail</label>
        <input id="identity" type="text" class="form-control" name="identity" value="{{ old('identity') }}"  autofocus>

        @if ($errors->has('identity') || $errors->has('username') || $errors->has('email'))
        <span class="form-text text-danger">
            <small>{{ $errors->first('identity') . $errors->first('username') . $errors->first('email') }}</small>
        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="text-normal text-dark">Senha</label>
        <input id="password" type="password" class="form-control" name="password" >

        @if ($errors->has('password'))
        <span class="form-text text-danger">
            <small>{{ $errors->first('password') }}</small>
        </span>
        @endif
    </div>

    <div class="form-group">
        <div class="peers ai-c jc-sb fxw-nw">
            <div class="peer">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                    <input type="checkbox" id="remember" name="remember" class="peer"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class=" peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Lembrar de mim</span>
                    </label>
                </div>
            </div>
            <div class="peer">
                <button class="btn btn-primary">Entrar</button>
            </div>
        </div>
    </div>
    {{-- <div class="peers ai-c jc-sb fxw-nw">
            <div class="peer">
                <a class="btn btn-link" href="">
                    Esqueci a senha?
                </a>
            </div>
            <div class="peer">
                <a href="/register" class="btn btn-link">Create new account</a>
            </div>
        </div> --}}
</form>

@endsection