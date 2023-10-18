<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo text-center">
        <a href=""><img  src="{{ asset('img') }}/luxeford_logo.png" width="190" height="47"></a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard', 'dashboard') }}">
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'order' ? 'active' : '' }}">
                <a href="{{ route('order.lists') }}">
                    <i class="fa fa-barcode"></i>
                    <p>{{ __('Enter Orders') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'sales' ? 'active' : '' }}">
                <a href="{{ route('sales.list') }}">
                    <i class="fa fa-usd"></i>
                    <p>{{ __('Sales') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'product' ? 'active' : '' }}">
                <a href="{{ route('product.lists') }}">
                    <i class="fa fa-shopping-bag"></i>
                    <p>{{ __('Products') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'report' || $elementActive == 'salesreport' || $elementActive == 'productsreport' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="false" href="#laravelExamples">
                    <i class="fa fa-files-o"></i>
                    <p>
                            {{ __('Reports') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'salesreport' ? 'active' : '' }}">
                            <a href="{{ route('sales.report') }}">
                                <span class="sidebar-mini-icon">{{ __('SR') }}</span>
                                <span class="sidebar-normal">{{ __(' Sales Report ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'productsreport' ? 'active' : '' }}">
                            <a href="">
                                <span class="sidebar-mini-icon">{{ __('PR') }}</span>
                                <span class="sidebar-normal">{{ __(' Product Report ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'users' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="false" href="#laravelExamples2">
                    <i class="fa fa-cogs"><img src=""></i>
                    <p>
                            {{ __('Admin Settings') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'users' || $elementActive == 'usergroup' || $elementActive == 'product-type' || $elementActive == 'product-owner' ? 'show' : '' }}" id="laravelExamples2">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'users' ? 'active' : '' }}">
                            <a href="{{ route('user.lists') }}">
                                <span class="sidebar-mini-icon">{{ __('UP') }}</span>
                                <span class="sidebar-normal">{{ __(' Users ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'usergroup' ? 'active' : '' }}">
                            <a href="{{ route('usergroups.list') }}">
                                <span class="sidebar-mini-icon">{{ __('UG') }}</span>
                                <span class="sidebar-normal">{{ __(' User Group ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'product-type' ? 'active' : '' }}">
                            <a href="{{ route('product.type.lists') }}">
                                <span class="sidebar-mini-icon">{{ __('PT') }}</span>
                                <span class="sidebar-normal">{{ __(' Product Type ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'product-owner' ? 'active' : '' }}">
                            <a href="{{ route('product.owner.lists') }}">
                                <span class="sidebar-mini-icon">{{ __('PO') }}</span>
                                <span class="sidebar-normal">{{ __(' Product Owner ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
