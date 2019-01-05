@extends('layouts.app')

@section('title', __('User Login'))

@section('content')
    <div class="container">
        <div class="row justify-content-center user-login">
            <div class="col loginLeft">

                <h2>为什么要绑定账户？</h2>
                <p> 1、 绑定账户后，你在登录时可直接用手机验证码或微信直接登录云测速网站或云测速APP，再也不用担心忘记密码。</p>
                <p>
                    2、 未经你的允许，你在云测速的测速、浏览等涉及隐私的信息不会被他人看到。
                </p>

            </div>
            <div class="col loginRight">
                <h2>绑定账户</h2>
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Binging') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="account" type="text"
                                   class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account"
                                   value="{{ old('account') }}" required autofocus placeholder="账号">

                            @if ($errors->has('account'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required placeholder="密码">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12 ">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Binding account') }}
                            </button>

                            <a class="btn btn-link register" href="{{ route('register') }}">
                                {{ __('No account?Register now') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
