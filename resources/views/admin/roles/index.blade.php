@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection
@section('main-content')
    <div class="breadcrumb">
        <h1>{{ trans('cruds.role.title') }}</h1>
        <ul>
            <li>{{ trans('global.list') }}</li>
        </ul>

        <a class="btn btn-primary btn-header-right" href="{{ route("admin.roles.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
        </a>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left pt-3">
                <div class="card-body p-3">
                    <table class="dataTable table table-bordered table-striped table-hover datatable datatable-Role">
                        <thead>
                            <tr>
                                <th width="10" class="not-export-col" >

                                </th>
                                <th>
                                    {{ trans('cruds.role.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.role.fields.name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.role.fields.permissions') }}
                                </th>
                                <th class="actions-3 not-export-col">
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $role)
                                <tr data-entry-id="{{ $role->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $role->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $role->name ?? '' }}
                                    </td>
                                    <td data-export-data="{{$role->permissions()->pluck('name')->implode(', ')}}">
                                        @foreach($role->permissions()->pluck('name') as $permission)
                                            <span class="badge badge-pill badge-outline-primary p-2 m-1">{{ $permission }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-icon btn-sm m-1" href="{{ route('admin.roles.show', $role->id) }}" >
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                        </a>
                                        <a class="btn btn-success btn-icon btn-sm m-1" href="{{ route('admin.roles.edit', $role->id) }}" >
                                            <span class="ul-btn__icon"><i class="i-Pen-2"></i></span>
                                        </a>
                                        @include('partials.delete_button', ['model'=> $role, 'destroy_method' => 'admin.roles.destroy'])

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

    <script>
        $(function () {
          let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
          let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
          let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.roles.mass_destroy') }}",
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
          $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
