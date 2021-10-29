@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/datetimepicker/jquery.datetimepicker.min.css')}}">
@endsection
@section('main-content')
    <div class="breadcrumb">
        <h1>{{ trans('cruds.order.title') }}</h1>
        <ul>
            <li>{{ trans('global.list') }}</li>
        </ul>
        <div class="justify-content-right" style="margin-left: auto;
  order: 2">
        <button  class="btn btn-info float-right text-white buttonSync ml-2" value="{{$accountServiceId}}"> <i class="iconS i-Reload-2"></i> Sincronizar Pedidos</button>
            <div style="font-size: 5px" class="loader spinner spinner-info p-3"></div>
        </div>

    </div>

    <div class="container mt-5">
            <h2 class="h5">Filtros</h2>
            <div class="separator-breadcrumb border-top"></div>
        <div class="row">

            <div class="col-md-2 form-group ">

                <select id="search" name="search" class="form-control form-control-range">
                    <option>Buscar por estado...</option>
                    @foreach($statusWoo as $key => $status)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group" >
                <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
            </div>


            <div class='col-md-3'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input style="background: #FFF;" type='text' class="form-control" id="date_timepicker_start" readonly/>
                        <span class="input-group-addon date-picker-button">
                            <span class="glyphicon glyphicon-calendar ">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </span>
                    </div>


                </div>

            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input style="background: #FFF;" type="text" id="date_timepicker_end"  name="departureDate"  class="form-control"  readonly/>
                        <span class="input-group-addon date-picker-button">
                            <span class="glyphicon glyphicon-calendar">
                                <i  class="fas fa-calendar-alt"></i>
                            </span>
                        </span>

                    </div>
                </div>
            </div>

            <div class="col-md-1">
                <button id="search-button" class="btn btn-info" onclick="search()" disabled>Buscar</button>

            </div>
        </div>


    </div>



    <div class="row mb-4">

        <div class="col-md-12 mb-4">
            <div class="card text-left pt-3">
                <div class="card-body p-3">

                    <table class="dataTable table table-bordered table-striped table-hover datatable datatable-User">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="7">Características</th>
                            <th class="text-center" colspan="9">Destinatario</th>
                            <th class="text-center" colspan="8">Domicilio destino</th>
                            <th class="text-center" colspan="6">Remitente</th>
                        </tr>
                        <tr>
                            <th  width="10" class="not-export-col">

                            </th>
                            <th data-orderable="false" class="not-export-col">
                                {{ trans('cruds.order.fieldsWoo.weight') }}
                            </th>
                            <th data-orderable="false" class="not-export-col">
                                {{ trans('cruds.order.fieldsWoo.entrust_name') }}
                            </th>
                            <th data-orderable="false" class="not-export-col">
                                {{ trans('cruds.order.fieldsWoo.height') }}
                            </th>
                            <th data-orderable="false" class="not-export-col">
                                {{ trans('cruds.order.fieldsWoo.width') }}
                            </th>
                            <th data-orderable="false" class="not-export-col">
                                {{ trans('cruds.order.fieldsWoo.depth') }}
                            </th>
                            <th data-orderable="false" class="not-export-col">
                                {{ trans('cruds.order.fieldsWoo.declared_value') }}
                            </th>

                            <th data-orderable="false" class="not-export-col">
                                {{ trans('cruds.order.fields.order_id') }}
                            </th>
                            <th class="not-export-col pr-4">
                                {{ trans('cruds.order.fieldsWoo.last_updated') }}
                            </th>
                            <th data-orderable="false" class="not-export-col" >
                                {{ trans('cruds.order.fieldsWoo.status') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.user_name') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.user_last_name') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.user_dni') }}
                            </th>
                            <th width="20" data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.user_email') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.user_phone') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.user_phone_code') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_reference') }}
                            </th>
                            <th style="width: 20px !important;" data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_address') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_number') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_piso') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_departament') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_location') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_postal_code') }}
                            </th>
                            <th data-orderable="false">
                                {{ trans('cruds.order.fieldsWoo.address_observation') }}
                            </th>

                            @if(!empty($enabledOrderFields))
                                @foreach($enabledOrderFields as $key => $value)
                                <th data-orderable="false" class="not-export-col ">
                                    {{$value}}
                                </th>
                                @endforeach
                            @else
                                <th class="d-none" data-orderable="false"></th>
                            @endif


                        </tr>
                        </thead>
                        <tbody class="buscar"></tbody>
                        <tfoot></tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')

    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('js/datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>

    @parent

    @include('partials.datatables_globals')
    <!-- -->
    <script>
        let table;
        jQuery(function(){
            jQuery('#datetimepicker6').datetimepicker({
                format:'d/m/Y',
                lang:'ar',
                onShow:function( ct ){
                    this.setOptions({
                        maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
                    })
                },
                timepicker:false
            });
            jQuery('#datetimepicker7').datetimepicker({
                format:'d/m/Y',
                lang:'ar',
                onShow:function( ct ){
                    this.setOptions({
                        minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
                    })
                },
                timepicker:false
            });
        });

        // var oOptions = {
        //     icons: {
        //         time: "fas fa-clock",
        //         date: "fa fa-calendar"
        //     },
        //     format: "DD/MM/YYYY HH:mm",
        //     locale: 'es',
        //     ignoreReadonly: true,
        //     useCurrent: false
        // };

        function toggleButton(){
            if($("#date_timepicker_start").val() === '' || $("#date_timepicker_end").val() === ''){
                $('#search-button').attr('disabled', true);
            }else{
                $('#search-button').attr('disabled', false);
            }
        }

        jQuery(function(){

            // $('#datetimepicker6').datetimepicker(oOptions);
            // $('#datetimepicker7').datetimepicker(oOptions);

            $("#datetimepicker6").on("change", function (e) {
                console.log('algo dentro den function de picker');
                // $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                toggleButton();
            });
            $("#datetimepicker7").on("change", function (e) {
                console.log('algo dentro den function de picker');
                // $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                toggleButton();
            });


        });

        function search(){
            table.draw();
        }

        $(function () {
            $('.loader').hide();
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            delete dtButtons[5];


            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 8, 'desc' ]],
                pageLength: 60,
            });
            table = $('.datatable-User:not(.ajaxTable)').DataTable({
                "scrollX": true,
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                stateSave: true,
                bFilter: true,
                dom: '<"table-header" Br>t<"table-footer"lpi><"actions">',
                ajax: {
                   "url":"{{ route('commons.accountServiceOrder.datatables.woo') }}",
                   "data": function (s){
                       s.accountServiceId = "{{$accountServiceId}}";
                       s.dataInit = $("#date_timepicker_start").val();
                       s.dataEnd =$("#date_timepicker_end").val();
                   }
                },
                columns:[
                    {data:'any'} ,
                    {data:'product_weight'} ,
                    {data:'entrust_name'} ,
                    {data:'product_height'} ,
                    {data:'product_width'} ,
                    {data:'product_depth'} ,
                    {data:'product_declared_value'} ,
                    {data:'account_service_orders-external_order_id'} ,
                    {data:'updated_at'} ,
                    {data:'external_status'} ,
                    {data:"data_client-first_name"},
                    {data:"data_client-last_name"},
                    {data:"data_client-dni"},
                    {data:"data_client-email"},
                    {data:"data_client-phone"},
                    {data:"data_client-phone_code"},
                    {data:"data_address-ref"},
                    {data:"data_address-address"},
                    {data:"data_address-number"},
                    {data:"data_address-floor"},
                    {data:"data_address-department"},
                    {data:"data_address-location"},
                    {data:"data_address-postal_code"},
                    {data:"data_address-customer_note"},


                    @if(!empty($enabledOrderFields))
                        @foreach($enabledOrderFields as $key => $value)
                        {data:"{{$key}}"},
                        @endforeach
                    @else
                        {data:"any2"},
                    @endif
                ],

                createdRow: function( row, data, dataIndex ) {
                    $( row ).attr('class', 'notificationClass');
                    $( row ).attr('data-status', data['notification-status']);
                },

                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos - Para exportar"]],
            });
            console.log()

            $('#search').on( 'change', function () {
                console.log(this.value);
                table
                    .search($(this).val())
                    .draw();
            });
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            $('.buttonSync').on('click', function()
            {
                $('.loader').show();
                $('.iconS').hide();
                $.ajax({
                    "url": "{{ route('commons.synchronize.orders.woo') }}",
                    type:"GET",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id: $(this).val()
                    },
                    success:function(response){
                        console.log(response);
                        if (response === 'ok')
                        {
                            $('.loader').hide();
                            $('.iconS').show();
                            table.draw();

                        }
                    },
                    error :function( data ) {
                    }
                });
            })
        });
        // function synchronizeOrders(id)
        // {
        //     console.log(id);
        //
        // }


    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            (function ($) {
                $('#filtrar').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.buscar tr').hide();
                    $('.buscar tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });
    </script>
@endsection
