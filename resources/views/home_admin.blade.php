@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
{{--    <h1 class="mr-2">Dashboard</h1>--}}
    <ul>
        <li><a  href="{{route('dashboard.home')}}">Dashboard</a></li>
        <li>home</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <!-- CARD ICON-->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Checked-User"></i>
                        <p class="text-muted mt-2 mb-2">{{trans('global.users')}}</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{$countUsers}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Network-Window"></i>
                        <p class="text-muted mt-2 mb-2">{{trans('global.services')}}</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{$countServices}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Management"></i>
                        <p class="text-muted mt-2 mb-2">{{trans('global.accounts')}}</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{$countAccounts}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-big mb-4">
                    <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                        <p class="text-muted mt-2 mb-2">{{trans('global.synchronized')}}</p>
                        <p class="line-height-1 text-title text-18 mt-2 mb-0">{{$countProductsSync['synced']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-big mb-4">
                    <div class="card-body text-center"><i class="i-Warning-Window"></i>
                        <p class="text-muted mt-2 mb-2">{{trans('global.pending')}}</p>
                        <p class="line-height-1 text-title text-18 mt-2 mb-0">{{$countProductsSync['pending']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-big mb-4">
                    <div class="card-body text-center"><i class="i-Close"></i>
                        <p class="text-muted mt-2 mb-2">{{trans('global.reject')}}</p>
                        <p class="line-height-1 text-title text-18 mt-2 mb-0">{{$countProductsSync['reject']}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card o-hidden mb-4">
            <div class="card-header d-flex align-items-center">
                <h3 class="w-50 float-left card-title m-0">{{trans('global.users')}}</h3>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dataTable-collapse text-center" id="user_table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('cruds.user.fields.name')}}</th>
                            <th scope="col">{{trans('cruds.user.fields.email')}}</th>
                            <th scope="col">{{trans('global.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a class="btn btn-info btn-icon btn-sm m-1" href="{{ route('admin.users.show', $user->id) }}" >
                                    <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                </a>
                                <a class="btn btn-success btn-icon btn-sm m-1" href="{{ route('admin.users.edit', $user->id) }}" >
                                    <span class="ul-btn__icon"><i class="i-Pen-2"></i></span>
                                </a>

                                @include('partials.delete_button', ['model'=> $user, 'destroy_method' => 'admin.users.destroy'])


                            </td>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="flex-grow-1"></div>
@endsection

@section('page-js')

@endsection
