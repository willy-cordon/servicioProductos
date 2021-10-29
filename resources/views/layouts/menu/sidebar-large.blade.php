<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            @can('commons')
                <li class="nav-item {{ request()->is('dashboard/*') ? 'active' : '' }}" >
                    <a class="nav-item-hold" href="{{route('dashboard.home')}}">
                        <i class="nav-icon i-Bar-Chart"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @cannot('users_manage')

                <li class="nav-item {{ request()->is('accounts/*') || request()->is('accounts') ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{route('commons.accounts.user',auth()->user()->account_id)}}">
                    <i class="nav-icon i-Management"></i>
                    <span class="nav-text">{{trans('cruds.account.title_singular')}}</span>
                </a>
                <div class="triangle"></div>
            </li>
                <li class="nav-item {{ request()->is('services/*') || request()->is('services') ? 'active' : '' }}" >
                    <a class="nav-item-hold" href="{{route('commons.services.serviceAccount')}}">
                        <i class="nav-icon i-Network-Window"></i>
                        <span class="nav-text">{{trans('cruds.service.title')}}</span>
                    </a>
                    <div class="triangle"></div>
                </li>

                        <li class="nav-item {{ request()->is('services/*') || request()->is('services') ? 'active' : '' }}" >
                            <a class="nav-item-hold" href="{{route('commons.products.account')}}">
                                <i class="nav-icon i-Car-Items"></i>
                                <span class="nav-text">{{trans('cruds.product.title')}}</span>
                            </a>
                            <div class="triangle"></div>
                        </li>

            @endcannot


                @can('users_manage')
                    <li class="nav-item {{ request()->is('accounts/*') || request()->is('accounts') ? 'active' : '' }}" >
                        <a class="nav-item-hold" href="{{route('admin.accounts.index')}}">
                            <i class="nav-icon i-Management"></i>
                            <span class="nav-text">{{trans('cruds.account.title')}}</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan
                @can('users_manage')
                    <li class="nav-item {{ request()->is('accounts/*') || request()->is('accounts') ? 'active' : '' }}" >
                        <a class="nav-item-hold" href="{{route('admin.services.index')}}">
                            <i class="nav-icon i-Network-Window"></i>
                            <span class="nav-text">{{trans('cruds.service.title')}}</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan
{{--                @can('users_manage')--}}
{{--                    <li class="nav-item {{ request()->is('accounts/*') || request()->is('accounts') ? 'active' : '' }}" >--}}
{{--                        <a class="nav-item-hold" href="{{route('admin.account_services.indexAll')}}">--}}
{{--                            <i class="nav-icon i-Windows-2"></i>--}}
{{--                            <span class="nav-text">{{trans('cruds.account_service.title')}}</span>--}}
{{--                        </a>--}}
{{--                        <div class="triangle"></div>--}}
{{--                    </li>--}}
{{--                @endcan--}}
        </ul>
    </div>


    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu starter -->
        <ul class="childNav" data-parent="setting">
{{--            <li class="nav-item {{ request()->is('accounts/*') || request()->is('accounts') ? 'active' : '' }}" >--}}
{{--                <a class="nav-item-hold" href="{{route('admin.accounts.index')}}">--}}
{{--                    <i class="nav-icon i-Management"></i>--}}
{{--                    <span class="nav-text">{{trans('cruds.account.title')}}</span>--}}
{{--                </a>--}}
{{--                <div class="triangle"></div>--}}
{{--            </li>--}}
{{--            <li class="nav-item {{ request()->is('accounts/*') || request()->is('accounts') ? 'active' : '' }}" >--}}
{{--                <a class="nav-item-hold" href="{{route('admin.services.index')}}">--}}
{{--                    <i class="nav-icon i-Management"></i>--}}
{{--                    <span class="nav-text">{{trans('cruds.service.title')}}</span>--}}
{{--                </a>--}}
{{--                <div class="triangle"></div>--}}
{{--            </li>--}}
        </ul>

        <!-- Submenu Docs -->
{{--        <ul class="childNav" data-parent="docs">--}}
{{--            <li class="nav-item ">--}}
{{--                <a href="http://demos.ui-lib.com/gull-html-doc/" target="_blank">--}}
{{--                    <i class="nav-icon i-Link"></i>--}}
{{--                    <span class="item-name">Gull Docs</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="https://bulkitv2.cssninja.io/_components-icons-im.html" target="_blank">--}}
{{--                    <i class="nav-icon i-Link"></i>--}}
{{--                    <span class="item-name">Icons Reference</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item ">--}}
{{--                <a href="https://laravel.com/" target="_blank">--}}
{{--                    <i class="nav-icon i-Link"></i>--}}
{{--                    <span class="item-name">Laravel</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item ">--}}
{{--                <a href="https://laravel-news.com/eloquent-tips-tricks" target="_blank">--}}
{{--                    <i class="nav-icon i-Link"></i>--}}
{{--                    <span class="item-name">Eloquent Tricks</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item ">--}}
{{--                <a href="https://medium.com/hackernoon/eloquent-relationships-cheat-sheet-5155498c209" target="_blank">--}}
{{--                    <i class="nav-icon i-Link"></i>--}}
{{--                    <span class="item-name">Eloquent Relationships</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
    </div>



    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
