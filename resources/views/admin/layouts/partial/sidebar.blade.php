<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 9px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->

            <li class="nav-item {{request()->is('admin')?' start active':''}} ">
                <a href="{{ route('admin.dashboard') }}" class="nav-link nav-toggle">
                    <i class="icon-speedometer"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Dashboard')}}</span>
                    {{-- <span class="arrow"></span> --}}
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/news-and-announcement')?' active start':''}} ">
                <a href="{{ route('admin.news.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-bullhorn"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Announcement')}}</span>
                    {{-- <span class="arrow"></span> --}}
                </a>
            </li>
             {{--<li class="heading">
                <h3 class="uppercase">{{trans('admin/layouts/partial/sidebar.Manage_ICO')}}</h3>
            </li>--}}
            <li class="nav-item {{request()->is('admin/ico') || request()->is('admin/ico/*')?' start active':''}} ">
                <a href="{{ route('admin.ico.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-cube"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Manage_ICO')}}</span>
                    {{-- <span class="arrow"></span> --}}
                </a>
            </li>

            <li class="nav-item {{request()->is('admin/user')?' start active':''}} ">
                <a href="{{ route('admin.user.index') }}" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.User')}}</span>
                    {{-- <span class="arrow"></span> --}}
                </a>
            </li>
            <li class="nav-item {{request()->is('admin/accounts')?' start active':''}} ">
                <a href="{{ route('admin.account.index') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Accounts')}}</span>
                    {{-- <span class="arrow"></span> --}}
                </a>
            </li>
            <li class="nav-item {{request()->is('admin/approve/*')?' active open':''}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-check"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Approve')}}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
					<!--<li class="nav-item {{request()->is('admin/approve/kyc-document')?' start active':''}} ">
                        <a href="{{route('admin.approve.kyc')}}" class="nav-link ">
                            <i class="fa fa-file-text"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.kyc')}}</span>
                        </a>
                    </li>-->
                    <li class="nav-item {{request()->is('admin/approve/withdraw')?' start active':''}} ">
                        <a href="{{route('admin.approve.withdraw')}}" class="nav-link ">
                            <i class="fa fa-level-up"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Withdraw')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{request()->is('admin/trades')?' active start':''}} ">
                <a href="{{ route('admin.trade.index') }}" class="nav-link nav-toggle">
                    <i class="icon-graph"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Trades')}}</span>
                    {{-- <span class="arrow"></span> --}}
                </a>
            </li>
            {{-- <li class="heading">
                <h3 class="uppercase">{{trans('admin/layouts/partial/sidebar.Features')}}</h3>
            </li>         --}}
            <li class="nav-item {{request()->is('admin/coin/request')?' active start':''}} ">
				<a href="{{route('admin.coin.request')}}" class="nav-link ">
					<i class="icon-graph"></i>
					<span class="title"> {{trans('admin/layouts/partial/sidebar.Coin_List_Request')}}</span>
				</a>
            </li>
            
            <li class="nav-item {{((request()->is('admin/coin') || request()->is('admin/coin-pair') || request()->is('admin/coin/transaction') || request()->is('admin/coin/request')) && (!(request()->is('admin/coin/request'))))?' active open':''}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Coin')}}</span>
                    <span class="arrow{{((request()->is('admin/coin') || request()->is('admin/coin-pair')) && (!(request()->is('admin/coin/request'))))?' open':''}}"></span>
                </a>
                <ul class="sub-menu">
                    
                    <li class="nav-item {{request()->is('admin/coin')?' active start':''}} ">
                        <a href="{{route('admin.coin.index')}}" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Manage_Coin')}} </span>
                        </a>
                    </li>
                    <li class="nav-item {{request()->is('admin/coin-pair')?' active start':''}} ">
                        <a href="{{route('admin.coinpair.index')}}" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Manage_Coin_Pair')}}</span>
                        </a>
                    </li>
                    <li class="nav-item {{request()->is('admin/coin/transaction')?' active start':''}} ">
                        <a href="{{route('admin.coin.transaction')}}" class="nav-link ">
                            <i class="icon-bulb"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Coin_Transaction')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{((request()->is('admin/coin') || request()->is('admin/coin-pair') || request()->is('admin/coin/transaction') || request()->is('admin/coin/request')) && (!(request()->is('admin/coin/request'))))?' active open':''}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-bookmark-o"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Tokens')}}</span>
                    <span class="arrow{{((request()->is('admin/coin') || request()->is('admin/coin-pair')) && (!(request()->is('admin/coin/request'))))?' open':''}}"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item{{request()->is('admin/doch_withdrawal_management')?' active start':''}} ">
                        <a href="{{ route('admin.dochManagement.addressBalanced') }}" class="nav-link ">
                            <i class="fa fa-crosshairs"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Doch')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item{{(request()->is('admin/setting/*'))?' active open':''}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-cog"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Settings')}}</span>
                    <span class="arrow{{(request()->is('admin/setting/*'))?' open':''}}"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item{{request()->is('admin/setting/coins')?' active start':''}} ">
                        <a href="{{ route('admin.setting.coins.get') }}" class="nav-link ">
                            <i class="fa fa-money"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Coins')}}</span>
                        </a>
                    </li>
                    <li class="nav-item{{request()->is('admin/setting/commission')?' active start':''}} ">
                        <a href="{{ route('admin.setting.commission.get') }}" class="nav-link ">
                            <i class="fa fa-crosshairs"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Commission')}}</span>
                        </a>
                    </li>
                    
                   
                </ul>
            </li>
            <!-- start menus for reports section -->
            <li class="nav-item{{(request()->is('admin/report/*'))?' active open':''}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-bar-chart"></i>
                    <span class="title">{{trans('admin/layouts/partial/sidebar.Report')}}</span>
                    <span class="arrow{{(request()->is('admin/report/*'))?' open':''}}"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{request()->is('admin/report/transaction')?' start active':''}} ">
                        <a href="{{ route('admin.report.transaction') }}" class="nav-link nav-toggle">
                            <i class="fa fa-exchange"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Transactions')}}</span>
                            {{-- <span class="arrow"></span> --}}
                        </a>
                    </li>
                    <li class="nav-item {{request()->is('admin/report/trade-summary')?' start active':''}} ">
                        <a href="{{ route('admin.report.tsummary') }}" class="nav-link nav-toggle">
                            <i class="fa fa-exchange"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Trade_Summary')}}</span>
                        </a>
                    </li>
                    <li class="nav-item {{request()->is('admin/report/payback')?' start active':''}} ">
                        <a href="{{ route('admin.report.payback') }}" class="nav-link nav-toggle">
                            <i class="fa fa-exchange"></i>
                            <span class="title">{{trans('admin/layouts/partial/sidebar.Payback')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- end menus for reports section -->
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
