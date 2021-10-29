@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{trans('cruds.role.title_singular')}}</h1>
        <ul>
            <li><a href="{{route('admin.roles.index')}}">{{trans('cruds.role.title')}}</a></li>
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
                                <label for="name">{{ trans('cruds.role.fields.name') }}*</label>
                                <input type="text" id="name" name="name" class="form-control form-control-rounded  @error('name') is-invalid @enderror" value="{{ old('name', isset($role) ? $role->name : '') }}" >
                                @if($errors->has('name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.role.fields.name_helper') }}
                                </p>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="roles">{{ trans('cruds.role.fields.permissions') }}*
                                    <span class="btn  btn-outline-primary  btn-sm m-1 btn-icon select-all">
                                        <span class="ul-btn__icon"><i class="i-Add"></i></span>
                                        <span class="ul-btn__text">{{ trans('global.select_all') }}</span>
                                    </span>
                                    <span class="btn  btn-outline-primary  btn-sm m-1 btn-icon deselect-all">
                                        <span class="ul-btn__icon"><i class="i-Remove"></i></span>
                                        <span class="ul-btn__text">{{ trans('global.deselect_all') }}</span>
                                    </span>
                                </label>

                                <select name="permission[]" id="permission" class="form-control form-control-rounded to-select2 @error('permission') is-invalid @enderror" multiple="multiple" >
                                    @foreach($permissions as $id => $permission)
                                        <option value="{{ $id }}" {{ (in_array($id, old('permission', [])) || isset($role) && $role->permissions()->pluck('id')->contains($id)) ? 'selected' : '' }}>{{ $permission }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('permission'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('permission') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.role.fields.permissions_helper') }}
                                </p>
                            </div>
                            <div class="col-md-12">
                                <input class="btn btn-primary" type="submit" value="{{ trans('global.save') }}">
                            </div>
                    </form>


                </div>
            </div>
@endsection
