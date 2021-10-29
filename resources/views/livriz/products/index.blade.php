@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection
@section('main-content')
    <div class="breadcrumb">
        <h1>{{ trans('cruds.product.title') }}</h1>
        <ul>
            <li>{{ trans('global.list') }}</li>
        </ul>

        <div class="justify-content-right" style="margin-left: auto;
  order: 2">
            <button  class="btn btn-info float-right text-white buttonSync ml-2" value="{{$accountId}}"> <i class="iconS i-Reload-2"></i> Sincronizar Productos</button>
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
                                {{ trans('cruds.product.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.product_code') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.catalog_code') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.product_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.product_quantity') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.product_price') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.product_category') }}
                            </th>


                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
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
        $(function () {
            $('.loader').hide();
            let table;
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)



            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            table = $('.datatable-User:not(.ajaxTable)').DataTable({
                // "scrollX": true,
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                stateSave: true,
                bFilter: true,
                // dom: '<"table-header" Br>t<"table-footer"lpi><"actions">',
                ajax: {
                    "url":"{{ route('commons.products.datatables') }}",
                    "data": function (s){
                        s.accountId = "{{$accountId}}"
                    }
                },
                columns:[
                    {data:'any'},
                    {data:'products-id'},
                    {data:'products-product_code'},
                    {data:'products-catalog_code'},
                    {data:'products-title'},
                    {data:'products-quantity'},
                    {data:'products-price'},
                    {data:'products-category'},

                ],
                createdRow: function( row, data, dataIndex ) {
                    $( row ).attr('class', 'notificationClass');
                    $( row ).attr('data-status', data['notification-status']);
                },

                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos - Para exportar"]],
            })
            $('#myInput').on( 'keyup', function () {
                table.search( this.value ).draw();
            } );
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            $('.buttonSync').on('click', function()
            {
                $('.loader').show();
                $('.iconS').hide();
                $.ajax({
                    "url": "{{ route('commons.synchronize.products') }}",
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
