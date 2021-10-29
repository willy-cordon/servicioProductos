@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{trans('cruds.account.title_singular')}}</h1>
        <ul>
{{--            <li><a href="{{route('admin.users.index')}}">{{trans('cruds.account.title')}}</a></li>--}}
              <li>{{ trans('global.edit') }}</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger">
                    {{Session::get('fail')}}
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method($method)

                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="name">{{ trans('cruds.account.fields.name') }}*</label>
                                <input type="text" id="name" name="name" class="form-control form-control-rounded @error('name') is-invalid @enderror" value="{{ old('name', isset($account) ? $account->name : '') }}" >
                                @if($errors->has('name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.account.fields.name_helper') }}
                                </p>
                            </div>
                            <div class="col-md-12 form-group pb-5" >
                                <h2 class="h4 pb-2">Servicios</h2>
                            @foreach($servicesAll as $service)
                                <label class="switch pr-5 switch-primary mr-3"><span>{{$service->name}}</span>
                                    <input type="hidden" name="services[{{$service->id}}]" value="0">
                                    <input type="checkbox" name="services[{{$service->id}}]"  {{ isset($servicesAvailable)?($servicesAvailable->contains($service->id) ? 'checked' : ''):'' }}   /><span class="slider"></span>
                                </label>
                            @endforeach
                            </div>


                            @if(isset($servicesAvailable))
                            <div class="col-md-12 mb-5" >
                                <div class="card">
                                    <div class="card-body">
                                        <!-- right control icon-->
                                        <h3 class="card-title">Servicios agregados</h3>
                                        <div class="accordion" id="accordionRightIcon">
                                            @foreach($servicesAvailable as $key => $service)
                                            <div class="card">
                                                <div class="card-header header-elements-inline">
                                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0"><a class="text-default collapsed" data-toggle="collapse" href="#collapse-{{$key}}" aria-expanded="false"><span><i class="i-Big-Data ul-accordion__font"> </i></span> {{$service->name}}</a></h6>
                                                </div>
                                                <div class="collapse" id="collapse-{{$key}}" data-parent="#accordionRightIcon">
                                                    <div class="card-body">
                                                        @if($service->service_code == \App\Enums\ServiceCode::ML)
                                                            @include('partials.form_edit_ml', ['service'=> $service, 'status' => $status, 'countryCodes'=>$countryCodes,'currencyCodes'=>$currencyCodes, 'languageCodes'=>$languageCodes, 'services'=>$services ])
                                                        @endif

                                                        @if($service->service_code == \App\Enums\ServiceCode::WOO)
                                                                @include('partials.form_edit_woo', ['service'=> $service, 'status' => $status, 'countryCodes'=>$countryCodes,'currencyCodes'=>$currencyCodes, 'languageCodes'=>$languageCodes, 'services'=>$services, 'availableOrderFields'=>$availableOrderFields, 'enabledOrderFields'=>$enabledOrderFields ])
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach



                                        </div>
                                        <!-- /right control icon-->
                                    </div>
                                </div>
                            </div>
                            @endif



                            <div class="col-md-12 mt-6">
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

        window.ButtonDisconnect = function(id)
        {

            $.ajax({
                "url": "{{ route('commons.accounts.disconnectMl') }}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success:function(response){
                   location.reload()
                },
                error :function( data ) {
                }
            });
        }


    </script>
@endsection
