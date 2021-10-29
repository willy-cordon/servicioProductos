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
                                {{ trans('cruds.product.fields.product_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.status_synchronize') }}
                            </th>
                            <th>
                                {{ trans('cruds.product.fields.status_action') }}
                            </th>



                            <th class="actions-3 not-export-col">
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product1)
                            <tr data-entry-id="1">
                                <td>

                                </td>
                                <td>

                                    {{$product1->id}}
                                </td>
                                    <td>
                                        {{$product1->product->product_data->title}}
                                    </td>

                                <td>
{{--                                    <p>{{$product1->product_id}} - {{$product1->status}} </p>--}}
                                    @switch($product1->status)
                                        @case(1)
                                             <span class="badge badge-warning">Pendiente</span>
                                             @break
                                        @case(3)
                                             <span class="badge badge-success">Sincronizado</span>
                                             @break
                                        @case(4)
                                            <span class="badge badge-success">Sincronizado</span>
                                            @break
                                    @endswitch
                                </td>

                                    <td>
                                        @switch($product1->action)
                                            @case(1)
                                            <span class="badge badge-info">Crear</span>
                                            @break
                                            @case(2)
                                            <span class="badge badge-warning text-white">Actualizar</span>
                                            @break
                                            @case(3)
                                            <span class="badge badge-danger">Borrar</span>
                                            @break
                                        @endswitch
                                    </td>
                                <td>
                                    {{-- Acciones --}}
                                </td>

                                </tr>

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
        $(function () {
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
            $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
