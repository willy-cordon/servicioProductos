{{--<div class="row">--}}
{{--    <div class="col float-right">--}}
{{--        @if(isset($services))--}}
{{--            @foreach($services as $key => $service)--}}
{{--                @if(empty($service->pivot->token))--}}
{{--                    <a href="http://auth.mercadolibre.com.ar/authorization?response_type=code&client_id={{$service->client_id}}&redirect_uri=https://dev.livriz-market.broobe.hosting/ml-gateway&state={{$service->pivot->id}}">--}}
{{--                        <button class="btn btn-outline-info btn-icon m-1 float-right w-20" type="button"><span class="ul-btn__icon"><i class="fas fa-plug  pr-3 "></i> <img class="img-fluid w-10" src="https://tuquejasuma.com/media/cache/64/93/6493636eb30668a3e61a63a07132b05e.png" alt="">  </span><span class="ul-btn__text"> {{$service->name}} </span></button>--}}
{{--                    </a>--}}
{{--                @else--}}
{{--                    <button class="btn btn-outline-success btn-icon m-1 float-right w-20" type="button" onclick="ButtonDisconnect({{$service->pivot->id}})"><span class="ul-btn__icon"><i class="fas fa-check  pr-3"></i> <img class="img-fluid w-10" src="https://tuquejasuma.com/media/cache/64/93/6493636eb30668a3e61a63a07132b05e.png" id="disconnectMl"  alt="">  </span><span class="ul-btn__text"> {{$service->name}} </span></button>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}
<div class="row">

    <div class="col-md-2 p-3">
        <label class="switch pr-5 switch-primary mr-3"><span>{{$service->pivot->status == 1 ? 'Activo' : 'Inactivo'}}</span>
            <input type="hidden" name="status[{{$service->pivot->id}}]" value="0">
            <input type="checkbox" name="status[{{$service->pivot->id}}]"  {{ $service->pivot->status == 1 ? 'checked' : '' }}   /><span class="slider"></span>
        </label>

    </div>
    <div class="col-md-10 ">
        @if(isset($services))
            @foreach($services as $key => $service)
                @if(empty($service->pivot->token))
                    <a href="http://auth.mercadolibre.com.ar/authorization?response_type=code&client_id={{$service->client_id}}&redirect_uri={{config('api.callback_url_app.url')}}&state={{$service->pivot->id}}">
                        <button class="btn btn-outline-info btn-icon m-1 float-right w-20" type="button"><span class="ul-btn__icon"><i class="fas fa-plug  pr-3 "></i> <img class="img-fluid w-10" src="https://tuquejasuma.com/media/cache/64/93/6493636eb30668a3e61a63a07132b05e.png" alt="">  </span><span class="ul-btn__text"> {{$service->name}} </span></button>
                    </a>
                @else
                    <button class="btn btn-outline-success btn-icon m-1 float-right w-20" type="button" onclick="ButtonDisconnect({{$service->pivot->id}})"><span class="ul-btn__icon"><i class="fas fa-check  pr-3"></i> <img class="img-fluid w-10" src="https://tuquejasuma.com/media/cache/64/93/6493636eb30668a3e61a63a07132b05e.png" id="disconnectMl"  alt="">  </span><span class="ul-btn__text"> {{$service->name}} </span></button>
                @endif
            @endforeach
        @endif
    </div>


    <div class="col-md-12 form-group mb-3 {{ $errors->has('before_description') ? 'has-error' : '' }}">
        <label for="before_description">{{ trans('cruds.service.fields.before_description') }}</label>
        <input type="hidden" name="service_id_before" value="{{$service->pivot->id}}">
        <div class="input-group">
            <textarea class="form-control" id="before_description" name="before_description" >{{{ old('before_description',isset($service) ? $service->pivot->before_description : '') }}}</textarea>
        </div>
        @if($errors->has('before_description'))
            <em class="invalid-feedback">
                {{ $errors->first('before_description') }}
            </em>
        @endif
        <p class="helper-block">
            {{ trans('cruds.service.fields.before_description_helper') }}
        </p>

    </div>


    <div class="col-md-12 form-group mb-3 {{ $errors->has('after_description') ? 'has-error' : '' }}">
        <label for="after_description">{{ trans('cruds.service.fields.after_description') }}</label>
        <input type="hidden" name="service_id_after" value="{{$service->pivot->id}}">

        <div class="input-group">
{{--            <label for=""></label>--}}
            <textarea class="form-control" id="after_description" name="after_description" aria-label="With textarea">{{{ old('after_description',isset($service) ? $service->pivot->after_description : '') }}}</textarea>
        </div>
        @if($errors->has('after_description'))
            <em class="invalid-feedback">
                {{ $errors->first('after_description') }}
            </em>
        @endif
        <p class="helper-block">
            {{ trans('cruds.service.fields.after_description_helper') }}
        </p>

    </div>


</div>
