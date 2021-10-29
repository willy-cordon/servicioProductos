@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{trans('cruds.user.title_singular')}}</h1>
        <ul>
            <li><a href="{{route('admin.users.index')}}">{{trans('cruds.user.title')}}</a></li>
            <li>{{ trans('global.create') }}</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                                <input type="text" id="name" name="name" class="form-control form-control-rounded @error('name') is-invalid @enderror" value="{{ old('name', isset($user) ? $user->name : '') }}" >
                                @if($errors->has('name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.user.fields.name_helper') }}
                                </p>
                            </div>
                            <div class="col-md-4 form-group mb-3 {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                                <input type="email" id="email" name="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" value="{{ old('email', isset($user) ? $user->email : '') }}" >
                                @if($errors->has('email'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.user.fields.email_helper') }}
                                </p>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                                <input type="password" id="password" name="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" >
                                @if($errors->has('password'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </em>
                                @endif
                                @if($method == 'PUT')
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.password_helper') }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="roles">{{ trans('cruds.user.fields.roles') }}*
                                    <span class="btn  btn-outline-primary  btn-sm m-1 btn-icon select-all">
                                        <span class="ul-btn__icon"><i class="i-Add"></i></span>
                                        <span class="ul-btn__text">{{ trans('global.select_all') }}</span>
                                    </span>
                                    <span class="btn  btn-outline-primary  btn-sm m-1 btn-icon deselect-all">
                                        <span class="ul-btn__icon"><i class="i-Remove"></i></span>
                                        <span class="ul-btn__text">{{ trans('global.deselect_all') }}</span>
                                    </span>
                                </label>
                                <select name="roles[]" id="roles" class="form-control form-control-rounded to-select2 @error('roles') is-invalid @enderror" multiple="multiple" >
                                    @foreach($roles as $id => $role)
                                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles()->pluck('id')->contains($id)) ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('roles'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('roles') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.user.fields.roles_helper') }}
                                </p>
                            </div>

                            <div class="col-md-6 form-group" style="margin-top: 0.8rem !important;">
                                <label for="picker1">Cuenta</label>
                                <select id="account_id" name="account_id" class="form-control form-control-range">
                                    <option>Seleccione una cuenta...</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}" {{ (collect(old('account_id', isset($user) ? $user->account_id : ''))->contains($account->id)) ? 'selected':'' }}>{{ $account->name }}</option>
                                    @endforeach

                                </select>
                            </div>



                            <div class="col-md-12">
                                <button class="btn btn-primary">{{ trans('global.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
