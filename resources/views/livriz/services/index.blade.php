@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection
@section('main-content')
    <div class="breadcrumb">
        <h1>{{ trans('cruds.service.title') }}</h1>
        <ul>
            <li>{{ trans('global.list') }}</li>
        </ul>

        <a class="btn btn-primary btn-header-right" href="{{ route("admin.services.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.service.title_singular') }}
        </a>

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
                                {{ trans('cruds.account.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.account.fields.name') }}
                            </th>


                            <th class="actions-3 not-export-col">
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr data-entry-id="{{ $service->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $service->id ?? '' }}
                                </td>
                                <td>
                                    {{ $service->name ?? '' }}
                                </td>


                                <td>
                                    @if($service->trashed())

                                        @include('partials.restore_button', ['model'=> $service, 'restore_method' => 'admin.services.restore', 'restore_label'=> trans('global.restore')])
                                    @else

                                        <a class="btn btn-success btn-icon btn-sm m-1" href="{{ route('admin.services.edit', $service->id) }}" >
                                            <span class="ul-btn__icon"><i class="i-Pen-2"></i></span>
                                        </a>

                                        @include('partials.delete_button', ['model'=> $service, 'destroy_method' => 'admin.services.destroy'])
                                    @endif

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
            let dtButtons = $.extend(false, [], $.fn.dataTable.defaults.buttons)

            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.users.mass_destroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')
                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': '{{ csrf_token() }}'},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)


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
