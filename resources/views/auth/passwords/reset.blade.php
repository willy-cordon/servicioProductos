@extends('layouts.app')
@section('main-content')
    <div class="card o-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="p-4">
                    <div class="auth-logo text-center mb-4">
                        <a href="{{env('APP_URL')}}">
                            <img src="{{asset('img/logo.png')}}" alt="">
                        </a>
                    </div>
                    <h1 class="mb-3 text-18">{{trans('global.reset_password')}}</h1>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group ">
                            <label for="email">
                                {{trans('global.login_email')}}
                            </label>

                            <input id="email" type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <div class="form-group ">
                            <label for="password">
                                {{trans('global.new_password')}}
                            </label>

                            <input id="password" type="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="password-confirm">
                                {{trans('global.confirm_password')}}
                            </label>
                             <input id="password-confirm" type="password" class="form-control form-control-rounded" name="password_confirmation" required autocomplete="new-password">

                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-2">{{trans('global.reset_password')}}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
