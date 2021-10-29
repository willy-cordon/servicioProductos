
<div class="row">

    <div class="col-md-6 p-3">
        <label class="switch pr-5 switch-primary mr-3"><span>{{$service->pivot->status == 1 ? 'Activo' : 'Inactivo'}}</span>
            <input type="hidden" name="status[{{$service->pivot->id}}]" value="0">
            <input type="checkbox" name="status[{{$service->pivot->id}}]"  {{ $service->pivot->status == 1 ? 'checked' : '' }}   /><span class="slider"></span>
        </label>

    </div>
    <div class="col-md-6 ">

    </div>


    <div class="col-md-6 form-group mb-3 {{ $errors->has('external_client_id') ? 'has-error' : '' }}">
{{--        <label for="before_description">{{ trans('cruds.service.fields.before_description') }}</label>--}}
        <input type="hidden" name="service_id_client_id" value="{{$service->pivot->id}}">
{{--        <div class="input-group">--}}
            <label for="external_client_id">{{ trans('cruds.service.fields.client_id') }}</label>
            <input type="text" id="external_client_id" name="external_client_id" class="form-control form-control-rounded @error('email') is-invalid @enderror" value="{{ old('external_client_id', isset($service) ? $service->pivot->external_client_id : '') }}" >
{{--        </div>--}}
        @if($errors->has('external_client_id'))
            <em class="invalid-feedback">
                {{ $errors->first('external_client_id') }}
            </em>
        @endif
        <p class="helper-block">
{{--            {{ trans('cruds.service.fields.before_description_helper') }}--}}
        </p>

    </div>


    <div class="col-md-6 form-group mb-3 {{ $errors->has('after_description') ? 'has-error' : '' }}">
{{--        <label for="after_description">{{ trans('cruds.service.fields.after_description') }}</label>--}}
        <input type="hidden" name="service_id_secret" value="{{$service->pivot->id}}">

{{--        <div class="input-group">--}}
            <label for="external_client_secret">{{ trans('cruds.service.fields.client_secret') }}</label>
            <input type="text" id="external_client_secret" name="external_client_secret" class="form-control form-control-rounded @error('email') is-invalid @enderror" value="{{ old('external_client_secret', isset($service) ? $service->pivot->external_client_secret : '') }}" >

{{--        </div>--}}
        @if($errors->has('after_description'))
            <em class="invalid-feedback">
                {{ $errors->first('after_description') }}
            </em>
        @endif
        <p class="helper-block">
{{--            {{ trans('cruds.service.fields.after_description_helper') }}--}}
        </p>

    </div>

    <div class="col-md-12 form-group mb-3 {{ $errors->has('external_url') ? 'has-error' : '' }}">
        {{--        <label for="before_description">{{ trans('cruds.service.fields.before_description') }}</label>--}}
        <input type="hidden" name="service_id_url" value="{{$service->pivot->id}}">
        {{--        <div class="input-group">--}}
        <label for="external_url">{{ trans('cruds.service.fields.external_url') }}</label>
        <input type="text" id="external_url" name="external_url" class="form-control form-control-rounded @error('email') is-invalid @enderror" value="{{ old('email', isset($service) ? $service->pivot->external_url : '') }}" >
        {{--        </div>--}}
        @if($errors->has('external_url'))
            <em class="invalid-feedback">
                {{ $errors->first('external_url') }}
            </em>
        @endif
        <p class="helper-block">
{{--            {{ trans('cruds.service.fields.before_description_helper') }}--}}
        </p>

    </div>

    <div class="col-md-12 form-group mb-3">
        <label for="availableOrders">{{ trans('cruds.service.fields.available_order_fields') }}
            <span class="btn  btn-outline-primary  btn-sm m-1 btn-icon select-all">
                                        <span class="ul-btn__icon"><i class="i-Add"></i></span>
                                        <span class="ul-btn__text">{{ trans('global.select_all') }}</span>
                                    </span>
            <span class="btn  btn-outline-primary  btn-sm m-1 btn-icon deselect-all">
                                        <span class="ul-btn__icon"><i class="i-Remove"></i></span>
                                        <span class="ul-btn__text">{{ trans('global.deselect_all') }}</span>
                                    </span>
        </label>
        <select name="availableOrders[]" id="availableOrders" class="form-control form-control-rounded to-select2 @error('availableOrders') is-invalid @enderror" multiple="multiple" >
            @foreach($availableOrderFields as $id => $role)

                <option value="{{ $id }}" {{ !empty($enabledOrderFields) && key_exists($id, $enabledOrderFields) ? 'selected' : '' }}>{{ $role }}</option>
            @endforeach
        </select>
        @if($errors->has('availableOrders'))
            <em class="invalid-feedback">
                {{ $errors->first('availableOrders') }}
            </em>
        @endif
        <p class="helper-block">
            {{ trans('cruds.user.fields.roles_helper') }}
        </p>


    </div>
    @if(!empty($enabledOrderFields))

        @foreach($enabledOrderFields as $key => $orderField)
            <div class="col-md-4 form-group mb-3">
                <label for="{{$key}}">{{$orderField}}*</label>
                <input type="text" id="{{$key}}" name="{{$key}}" class="form-control form-control-rounded @error('name') is-invalid @enderror" value="{{ old('name', isset($user) ? $user->name : '') }}" >
            </div>
        @endforeach
    @endif



</div>
