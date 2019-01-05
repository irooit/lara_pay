@extends('layouts.app')

@section('title', __('User Login'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Account') }}</label>

                                <div class="col-md-6">
                                    <input id="account" type="text"
                                           class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}"
                                           name="account" value="{{ old('account') }}" required autofocus>

                                    @if ($errors->has('account'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <h3 class="login-auth">第三方账号登录</h3>
                        <div>
                            <ul class="auth-clients">

                                <li><a class="weibo auth-link" href="{{ url('/auth/social/weibo') }}" title="微博"><span
                                                class="auth-icon weibo"></span></a></li>
                                <li><a class="wechat auth-link" href="{{ url('/auth/social/wechat') }}" title="微信"><span
                                                class="auth-icon wechat"></span></a></li>
                                <li><a class="qq auth-link" href="{{ url('/auth/social/qq') }}" title="QQ"><span
                                                class="auth-icon qq"></span></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
