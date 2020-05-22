<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
    @include('admin.layouts.partial.htmlheader')
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <!-- BEGIN PAGE WRAPPER -->
        <div class="page-wrapper">
            @include('admin.layouts.partial.top-nav')
            
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->

            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                @include('admin.layouts.partial.sidebar')
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        @yield('page-bar')
                        <!-- END PAGE HEADER-->
                        @yield('contents')
                    </div>
                    
                    <!-- END CONTENT BODY -->
                </div>                
            </div>
            <!-- END CONTAINER -->
            @include('admin.layouts.partial.footer')
        </div>
        <!-- END PAGE WRAPPER -->
        @include('admin.layouts.partial.scripts')
    </body>
</html>
