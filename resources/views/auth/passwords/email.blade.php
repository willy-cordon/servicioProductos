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
                    @if(session('status'))
                        <div class="row">
                            <div class="col-md-12" >
                                <div class="alert alert-card alert-success text-left" role="alert">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                    @else

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label">
                                {{trans('global.login_email')}}
                            </label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block mt-2">
                                    {{trans('global.send_reset_link')}}
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
