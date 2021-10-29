@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{trans('cruds.role.title_singular')}}</h1>
        <ul>
            <li><a href="{{route('admin.roles.index')}}">{{trans('cruds.role.title')}}</a></li>
            <li>{{ trans('global.show') }}</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <td>
                            {{ $role->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.name') }}
                        </th>
                        <td>
                            {{ $role->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Permissions
                        </th>
                        <td>
                            @foreach($role->permissions()->pluck('name') as $permission)
                                <span class="label label-info label-many">{{ $permission }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

                </div>
            </div>
        </div>
    </div>
@endsection
