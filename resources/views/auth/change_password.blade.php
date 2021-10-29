@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ trans('global.change_password') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('profile.change_password_update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="current_password">{{ trans('global.current_password') }} *</label>
                                <input type="password" id="current_password" name="current_password" class="form-control form-control-rounded @error('current_password') is-invalid @enderror">
                                @if($errors->has('current_password'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('current_password') }}
                                    </em>
                                @endif
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="new_password">{{ trans('global.new_password') }} *</label>
                                <input type="password" id="new_password" name="new_password" class="form-control form-control-rounded @error('new_password') is-invalid @enderror" >
                                @if($errors->has('new_password'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('new_password') }}
                                    </em>
                                @endif
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="new_password_confirmation">{{ trans('global.confirm_password') }} *</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control form-control-rounded @error('new_password_confirmation') is-invalid @enderror" >
                                @if($errors->has('new_password_confirmation'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('new_password_confirmation') }}
                                    </em>
                                @endif
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="{{ trans('global.save') }}">

                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection
