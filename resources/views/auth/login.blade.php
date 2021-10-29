@extends('layouts.app')
@section('main-content')
    <div class="card o-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="p-4">
                    <div class="auth-logo text-center mb-4">
                        <img src="{{asset('img/liv.png')}}" alt="">
                    </div>
                    <h1 class="mb-3 text-18">{{trans('global.login')}}</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{trans('global.login_email')}}</label>
                            <input id="email"
                                class="form-control form-control-rounded @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}"  autocomplete="email"
                                autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{trans('global.login_password')}}</label>
                            <input id="password" type="password"
                                class="form-control form-control-rounded @error('password') is-invalid @enderror"
                                name="password"  autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ trans('global.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block mt-2">{{trans('global.login')}}</button>

                    </form>
                    @if (Route::has('password.request'))

                    <div class="mt-3 text-center">

                        <a href="{{ route('password.request') }}" class="text-muted"><u>{{trans('global.forgot_password')}}</u></a>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection
