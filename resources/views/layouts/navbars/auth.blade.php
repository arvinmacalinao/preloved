<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href=""><img src="{{ asset('img') }}/Cherry.png"></a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('order.lists') }}">
                    <i class="fa fa-shopping-bag"></i>
                    <p>{{ __('Orders') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('product.lists') }}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>{{ __('Products') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="false" href="#laravelExamples">
                    <i class="fa fa-user-circle-o"></i>
                    <p>
                            {{ __('User') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __('UP') }}</span>
                                <span class="sidebar-normal">{{ __(' User Profile ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon">{{ __('UM') }}</span>
                                <span class="sidebar-normal">{{ __(' User Management ') }}</span>
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
                <div class="collapse show" id="laravelExamples2">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'users' ? 'active' : '' }}">
                            <a href="{{ route('user.lists') }}">
                                <span class="sidebar-mini-icon">{{ __('UP') }}</span>
                                <span class="sidebar-normal">{{ __(' Users ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'usergroup' ? 'active' : '' }}">
                            <a href="{{ route('usergroup.lists') }}">
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
