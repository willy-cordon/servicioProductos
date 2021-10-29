@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
        <h1>Home</h1>
        <ul>
            <li>Dashboard</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <!-- ICON BG -->
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Warning-Window"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Pendientes</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$productSyncPending}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Checkout-Basket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Sincronizados</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$productSyncSynced}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Checkout-Basket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Ordenes</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$orders}}</p>
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="col-lg-3 col-md-6 col-sm-6">--}}
{{--            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
{{--                <div class="card-body text-center">--}}
{{--                    <i class="i-Money-2"></i>--}}
{{--                    <div class="content">--}}
{{--                        <p class="text-muted mt-2 mb-0">Expense</p>--}}
{{--                        <p class="text-primary text-24 line-height-1 mb-2">$1200</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

    </div>




@endsection

@section('page-js')

@endsection
