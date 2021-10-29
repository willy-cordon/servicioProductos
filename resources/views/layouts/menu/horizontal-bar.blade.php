
<div class="horizontal-bar-wrap">
    <div class="header-topnav">
        <div class="container-fluid">
            <div class=" topnav rtl-ps-none" id="" data-perfect-scrollbar data-suppress-scroll-x="true">
                <ul class="menu float-left">
                    <li class="{{ request()->is('dashboard/*') ? 'active' : '' }}">
                        <div>
                            <div>
                                @can('commons')
                                <a href="#">
                                    <i class="nav-icon mr-2 i-Bar-Chart"></i>
                                     Demo Pages
                                </a>
                                @endcan
                                <ul class="childNav" data-parent="starter">
                                    <li class="nav-item ">
                                        <a class="{{ Route::currentRouteName()=='dashboard.home' ? 'open' : '' }}"  href="{{route('dashboard.home')}}">
                                            <i class="nav-icon i-Clock-3 mr-3"></i>
                                            <span class="item-name">Home</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ Route::currentRouteName()=='dashboard.sample' ? 'open' : '' }}"  href="{{route('dashboard.sample')}}">
                                            <i class="nav-icon i-Clock-4 mr-3"></i>
                                            <span class="item-name">Sample</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div>
                            <div>
                                @can('commons')
                                <a href="#">
                                    <i class="nav-icon i-Life-Safer mr-2"></i>
                                    Help
                                </a>
                                @endcan
                                <ul>
                                    <li class="nav-item ">
                                        <a href="http://demos.ui-lib.com/gull-html-doc/" target="_blank">
                                            <i class="nav-icon i-Link mr-2"></i>
                                            <span class="item-name">Gull Docs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://bulkitv2.cssninja.io/_components-icons-im.html" target="_blank">
                                            <i class="nav-icon i-Link mr-2"></i>
                                            <span class="item-name">Icons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="https://laravel.com/" target="_blank">
                                            <i class="nav-icon i-Link mr-2"></i>
                                            <span class="item-name">Laravel</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="https://laravel-news.com/eloquent-tips-tricks" target="_blank">
                                            <i class="nav-icon i-Link mr-2"></i>
                                            <span class="item-name">Eloquent Tricks</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="https://medium.com/hackernoon/eloquent-relationships-cheat-sheet-5155498c209" target="_blank">
                                            <i class="nav-icon i-Link mr-2"></i>
                                            <span class="item-name">Relationships</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
