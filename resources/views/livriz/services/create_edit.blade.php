@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{trans('cruds.service.title_singular')}}</h1>
        <ul>
            <li><a href="{{route('admin.users.index')}}">{{trans('cruds.service.title')}}</a></li>
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
                            <div class="col float-right">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="name">{{ trans('cruds.service.fields.name') }}*</label>
                                <input type="text" id="name" name="name" class="form-control form-control-rounded @error('name') is-invalid @enderror" value="{{ old('name', isset($service) ? $service->name : '') }}" >
                                @if($errors->has('name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.service.fields.name_helper') }}
                                </p>
                            </div>

                            <div class="col-md-6 form-group" >
                                <label for="service_code">{{ trans('cruds.service.fields.service_code') }}</label>
                                <select class="form-control form-control-rounded" name="service_code" id="service_code">
                                    <option value=""> </option>
                                    @foreach($serviceCodes as $key => $code)
                                        <option value="{{$key}}" {{ (collect(old('currency_code', isset($service) ? $service->service_code : ''))->contains($key)) ? 'selected':'' }}>{{strtoupper($code)}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('service_code'))
                                    <em class="invalid-feedback">
                                        pepe
                                        {{ $errors->first('service_code') }}
                                    </em>
                                @endif
                            </div>

                            <div class="client_id col-md-6 form-group mb-3 {{ $errors->has('client_id') ? 'has-error' : '' }}">
                                <label for="client_id">{{ trans('cruds.service.fields.client_id') }}</label>
                                <input type="text" id="client_id" name="client_id" class="form-control form-control-rounded @error('client_id') is-invalid @enderror" value="{{ old('client_id', isset($service) ? $service->client_id : '') }}" >
                                @if($errors->has('client_id'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('client_id') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.service.fields.client_id_helper') }}
                                </p>
                            </div>

                            <div class="client_secret col-md-6 form-group mb-3 {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="client_secret">{{ trans('cruds.service.fields.client_secret') }}</label>
                                <input type="text" id="client_secret" name="client_secret" class="form-control form-control-rounded @error('email') is-invalid @enderror" value="{{ old('email', isset($service) ? $service->client_secret : '') }}" >
                                @if($errors->has('email'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('client_secret') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.service.fields.client_secret_helper') }}
                                </p>
                            </div>

                            <div class="col-md-6 form-group" >
                                <label for="country_code">{{ trans('cruds.service.fields.country_code') }}</label>
                                <select class="form-control form-control-rounded" name="country_code" id="country_code">
                                    <option value=""> </option>
                                    @foreach($countryCodes as $key => $country)
                                        <option value="{{$key}}" {{ (collect(old('country_code', isset($service) ? $service->country_code : ''))->contains($key)) ? 'selected':'' }}>{{$key}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group" >
                                <label for="currency_code">{{ trans('cruds.service.fields.currency_code') }}</label>
                                <select class="form-control form-control-rounded" name="currency_code" id="currency_code">
                                    <option value=""> </option>
                                    @foreach($currencyCodes as $key => $currency)
                                        <option value="{{$key}}" {{ (collect(old('currency_code', isset($service) ? $service->currency_code : ''))->contains($key)) ? 'selected':'' }}>{{$key}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group" >
                                <label for="language_code">{{ trans('cruds.service.fields.language_code') }}</label>
                                <select class="form-control form-control-rounded" name="language_code" id="language_code">
                                    <option value=""> </option>
                                    @foreach($languageCodes as $key => $language)
                                        <option value="{{ strtolower($language) }}" {{ (collect(old('currency_code', isset($service) ? $service->language_code : ''))->contains(strtoupper($language))) ? 'selected':'' }}>{{strtoupper($language)}}</option>
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

@section('page-js')
        <script>
            const ML = 1;
            const AMZ = 2;
            const Woo = 3;
            let client_id = $(".client_id");
            let client_secret = $(".client_secret");
            $( document ).ready(function() {
                changeInput($("#service_code").val())
            });
            client_id.addClass('d-none');
            client_secret.addClass('d-none');

            $("#service_code").on('change', function(){
                changeInput($(this).val())
            });

            function changeInput(val)
            {
                if (val == 1)
                {
                    console.log('woo');
                    client_id.removeClass('d-none')
                    client_secret.removeClass('d-none')
                    client_id.addClass('d-block')
                    client_secret.addClass('d-block')
                }
                if (val == 2)
                {
                    client_id.removeClass('d-block')
                    client_secret.removeClass('d-block')
                    client_id.addClass('d-none');
                    client_secret.addClass('d-none');
                }

                if (val == 3)
                {
                    client_id.removeClass('d-block')
                    client_secret.removeClass('d-block')
                    client_id.addClass('d-none');
                    client_secret.addClass('d-none');
                }
            }




        </script>
@endsection
