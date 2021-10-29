@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
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

    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left pt-3">
                <div class="card-body p-3">
                    <table class="dataTable table table-bordered table-striped table-hover datatable datatable-User">
                        <thead>
                        <tr>
                            <th width="10" class="not-export-col">

                            </th>
                            <th>
                                {{ trans('cruds.order.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.order_id') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.seller_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.total_paid_amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.product_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.method_paid') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.status_order') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.payer_nickname') }}
                            </th>


                            <th class="actions-3 not-export-col">
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accountServiceOrders as $accountServiceOrder)
                            @foreach($accountServiceOrder->external_data as $data)
                            <tr data-entry-id="{{ $accountServiceOrder->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $accountServiceOrder->id ?? '' }}
                                </td>
                                <td>
                                    {{ $accountServiceOrder->external_order_id ?? '' }}
                                </td>
                                <td>
                                    {{ $data->seller->nickname ?? '' }}
                                </td>
                                <td>
                                    ${{ $data->payments[0]->total_paid_amount ?? '' }}
                                </td>
                                <td>
                                    {{ $data->payments[0]->reason ?? '' }}
                                </td>
                                <td>
                                    {{ $data->payments[0]->payment_type ?? '' }}
                                </td>
                                <td>
                                    {{ $data->payments[0]->status ?? '' }}
                                </td>
                                <td>
                                    {{ $data->buyer->nickname ?? '' }}
                                </td>


                                <td>
                                    <a class="btn btn-info" href="https://www.mercadolibre.com.ar/ventas/{{$accountServiceOrder->external_order_id}}/detalle" target="_blank"><i class="i-Eye"></i></a>

                                </td>

                            </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')

    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>

    @parent

    @include('partials.datatables_globals')
    <!-- -->
    <script>
        let table;
        $(function () {
            $('.loader').hide();
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            delete dtButtons[0];
            delete dtButtons[1];
            delete dtButtons[2];
            delete dtButtons[3];
            delete dtButtons[4];
            delete dtButtons[5];


            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            table = $('.datatable-User:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });


            $('.buttonSync').on('click', function()
            {
                $('.loader').show();
                $('.iconS').hide();
                $.ajax({
                    "url": "{{ route('commons.synchronize.orders.ml') }}",
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


        })

    </script>
@endsection
