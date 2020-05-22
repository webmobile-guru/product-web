<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{ url('/') }}">
                <img class="logo_hide"  src="{{ asset('/doch/img/logo.png') }}" alt="logo" /> </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
				{{--<li class="dropdown dropdown-user">
					<form>
						<div class="flag_right">
							<div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
						</div>
					</form>
				</li>--}}
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="username username-hide-on-mobile"> {{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
						<!--<li>
                            <a href="#">
                              <i class="icon-user"></i>{{trans('admin/layouts/partial/top-nav.My_Profile')}}</a>
                        </li>-->
                        <li>                            
                            <a onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                             <i class="icon-key"></i>
                                    {{trans('admin/layouts/partial/top-nav.Log_Out')}}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
