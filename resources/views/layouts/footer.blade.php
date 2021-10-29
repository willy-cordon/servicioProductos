<!-- Footer Start -->
<div class="flex-grow-1"></div>
<div class="app-footer">
    <span class="col-3 float-left">
    {{trans('global.version')}} {{config('app.version')}}
    </span>
    <span class="col-9 float-right text-right">
    Copyright © Livriz   {{\Carbon\Carbon::now()->format('Y')}}. {{trans('global.allRightsReserved')}}
    </span>
</div>
<!-- fotter end -->
