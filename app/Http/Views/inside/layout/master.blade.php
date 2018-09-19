<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{!! $title !!}</title>

        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/inside/js/jquery-2.1.1.min.js"></script>

        <!--STYLESHEET-->
        <!--=================================================-->

        <!--Open Sans Font [ OPTIONAL ] -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">


        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="/assets/inside/css/bootstrap.min.css" rel="stylesheet">


        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="/assets/inside/css/nifty.min.css" rel="stylesheet">


        <!--Font Awesome [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">


        <!--Animate.css [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/animate-css/animate.min.css" rel="stylesheet">


        <!--Morris.js [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/morris-js/morris.min.css" rel="stylesheet">


        <!--Switchery [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/switchery/switchery.min.css" rel="stylesheet">


        <!--Bootstrap Select [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">


        <!--Demo script [ DEMONSTRATION ]-->
        <link href="/assets/inside/css/demo/nifty-demo.min.css" rel="stylesheet">

        <!--Bootstrap Table [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">

        <!--Chosen [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/chosen/chosen.min.css" rel="stylesheet">

        <link href="/assets/inside/css/modify.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">

        <!--SCRIPT-->
        <!--=================================================-->

        <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="/assets/inside/plugins/pace/pace.min.css" rel="stylesheet">
        <script src="/assets/inside/plugins/pace/pace.min.js"></script>

        <script type="text/javascript" src="/assets/inside/plugins/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="/assets/inside/plugins/ckeditor/adapters/jquery.js"></script>

        <script src="/assets/inside/plugins/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="/assets/inside/plugins/uploadify/uploadify.css">

        <script src="/assets/inside/js/jquery.validate.min.js"></script>

        <script type="text/javascript" src="/assets/common/js/dateFormat.min.js"></script>
        <script type="text/javascript" src="/assets/common/js/jquery-dateFormat.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/assets/inside/plugins/data-tables/dataTables.responsive.css">

        @yield('head')
    </head>

    <body>
        <div id="container" class="effect mainnav-lg">

            <!--NAVBAR-->
            <!--===================================================-->
            <header id="navbar">
                <div id="navbar-container" class="boxed">

                    <!--Brand logo & name-->
                    <!--================================-->
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand">
                            <img src="/assets/inside/img/logo.png" alt="Inside" class="brand-icon">
                            <div class="brand-title">
                                <span class="brand-text">Inside</span>
                            </div>
                        </a>
                    </div>                <!--================================-->
                    <!--End brand logo & name-->



                    <!--Navbar Dropdown-->
                    <!--================================-->
                    <div class="navbar-content clearfix">
                        <ul class="nav navbar-top-links pull-left">
                            <!--Navigation toogle button-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="tgl-menu-btn">
                                <a class="mainnav-toggle" href="#">
                                    <i class="fa fa-navicon fa-lg"></i>
                                </a>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End Navigation toogle button-->
                        </ul>
                        <ul class="nav navbar-top-links pull-right">

                            <!--Language selector-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="dropdown">
                                <!--Language selector menu-->
                                <ul class="head-list dropdown-menu with-arrow">
                                    <li>
                                        <!--English-->
                                        <a href="#" class="active">
                                            <img class="lang-flag" src="/assets/inside/img/flags/united-kingdom.png" alt="English">
                                            <span class="lang-id">EN</span>
                                            <span class="lang-name">English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!--France-->
                                        <a href="#">
                                            <img class="lang-flag" src="/assets/inside/img/flags/france.png" alt="France">
                                            <span class="lang-id">FR</span>
                                            <span class="lang-name">Fran&ccedil;ais</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!--Germany-->
                                        <a href="#">
                                            <img class="lang-flag" src="/assets/inside/img/flags/germany.png" alt="Germany">
                                            <span class="lang-id">DE</span>
                                            <span class="lang-name">Deutsch</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!--Italy-->
                                        <a href="#">
                                            <img class="lang-flag" src="/assets/inside/img/flags/italy.png" alt="Italy">
                                            <span class="lang-id">IT</span>
                                            <span class="lang-name">Italiano</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!--Spain-->
                                        <a href="#">
                                            <img class="lang-flag" src="/assets/inside/img/flags/spain.png" alt="Spain">
                                            <span class="lang-id">ES</span>
                                            <span class="lang-name">Espa&ntilde;ol</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End language selector-->



                            <!--User dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li id="dropdown-user" class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                                    <span class="pull-right">
                                        <img class="img-circle img-user media-object" src="/assets/inside/img/av1.png" alt="Profile Picture">
                                    </span>
                                    <div class="username hidden-xs">{{ $user->fullname }}</div>
                                </a>


                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
                                    <!-- User dropdown menu -->
                                    <ul class="head-list">
                                        <li>
                                            <a href="/inside/users/profile">
                                                <i class="fa fa-user fa-fw fa-lg"></i> Thông tin cá nhân
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Dropdown footer -->
                                    <div class="pad-all text-right">
                                        <a href="/inside/users/logout" class="btn btn-primary">
                                            <i class="fa fa-sign-out fa-fw"></i> Thoát
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End user dropdown-->

                        </ul>
                    </div>
                    <!--================================-->
                    <!--End Navbar Dropdown-->

                </div>
            </header>
            <!--===================================================-->
            <!--END NAVBAR-->

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">@yield('content')</div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->



                <!--MAIN NAVIGATION-->
                <!--===================================================-->
                <nav id="mainnav-container">
                    <div id="mainnav">
                        <!--Menu-->
                        <!--================================-->
                        <div id="mainnav-menu-wrap">
                            <div class="nano">
                                <div class="nano-content">
                                    <ul id="mainnav-menu" class="list-group">

                                        <!--Category name-->
                                        <li class="list-header">Navigation</li>

                                        <!--Menu list item-->
                                        <li class="<?php echo (in_array($controllerName, array('users')) && in_array($actionNameDefault, array('getDashboard'))) ? 'active-link' : '' ?>">
                                            <a href="/">
                                                <i class="fa fa-dashboard"></i>
                                                <span class="menu-title">
                                                    <strong>Dashboard</strong>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="<?php echo (in_array($controllerName, array('staffs'))) ? 'active-link active open' : '' ?>">
                                            <a href="/inside/staffs/show-all">
                                                <i class="fa fa-table"></i>
                                                <span class="menu-title">
                                                    <strong>Quản lý User Login CMS</strong>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="<?php echo (in_array($controllerName, array('categories'))) ? 'active-link active open' : '' ?>">
                                            <a href="/inside/categories/show-all">
                                                <i class="fa fa-table"></i>
                                                <span class="menu-title">
                                                    <strong>Quản lý Category</strong>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="<?php echo (in_array($controllerName, array('videos'))) ? 'active-link active open' : '' ?>">
                                            <a href="/inside/videos/show-all">
                                                <i class="fa fa-table"></i>
                                                <span class="menu-title">
                                                    <strong>Quản lý Video</strong>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="<?php echo (in_array($controllerName, array('tags'))) ? 'active-link active open' : '' ?>">
                                            <a href="/inside/tags/show-all">
                                                <i class="fa fa-table"></i>
                                                <span class="menu-title">
                                                    <strong>Quản lý Tag</strong>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="<?php echo (in_array($controllerName, array('tag-groups'))) ? 'active-link active open' : '' ?>">
                                            <a href="/inside/tag-groups/show-all">
                                                <i class="fa fa-table"></i>
                                                <span class="menu-title">
                                                    <strong>Setting Home</strong>
                                                </span>
                                            </a>
                                        </li>
                                        <!--
                                        <li class="<?php echo (in_array($controllerName, array('notebook'))) ? 'active-link active open' : '' ?>">
                                            <a href="/inside/notebook/show-all">
                                                <i class="fa fa-table"></i>
                                                <span class="menu-title">
                                                    <strong>Sổ tay</strong>
                                                </span>
                                            </a>
                                        </li>
                                        -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--================================-->
                        <!--End menu-->

                    </div>
                </nav>
                <!--===================================================-->
                <!--END MAIN NAVIGATION-->
            </div>



            <!-- FOOTER -->
            <!--===================================================-->
            <footer id="footer">

                <!-- Visible when footer positions are fixed -->
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <div class="show-fixed pull-right">
                    <ul class="footer-list list-inline">
                        <li>
                            <p class="text-sm">SEO Proggres</p>
                            <div class="progress progress-sm progress-light-base">
                                <div style="width: 80%" class="progress-bar progress-bar-danger"></div>
                            </div>
                        </li>

                        <li>
                            <p class="text-sm">Online Tutorial</p>
                            <div class="progress progress-sm progress-light-base">
                                <div style="width: 80%" class="progress-bar progress-bar-primary"></div>
                            </div>
                        </li>
                        <li>
                            <button class="btn btn-sm btn-dark btn-active-success">Checkout</button>
                        </li>
                    </ul>
                </div>

                <!-- Visible when footer positions are static -->
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <!--<div class="hide-fixed pull-right pad-rgt">Currently v2.2</div>-->

                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

                <!--<p class="pad-lft">&#0169; 2015 Your Company</p>-->

            </footer>
            <!--===================================================-->
            <!-- END FOOTER -->


            <!-- SCROLL TOP BUTTON -->
            <!--===================================================-->
            <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
            <!--===================================================-->

        </div>

        <div class="modal fade" id="static" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="message">

                        </p>
                    </div>
                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="static-confirm" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="message">

                        </p>
                    </div>
                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">
                            Hủy
                        </button>
                        <button id="confirm-action" type="button" data-dismiss="modal" class="btn btn-primary">
                            Chấp nhận
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!--JAVASCRIPT-->
        <!--=================================================-->

        <!--BootstrapJS [ RECOMMENDED ]-->
        <script src="/assets/inside/js/bootstrap.min.js"></script>


        <!--Fast Click [ OPTIONAL ]-->
        <script src="/assets/inside/plugins/fast-click/fastclick.min.js"></script>


        <!--Nifty Admin [ RECOMMENDED ]-->
        <script src="/assets/inside/js/nifty.min.js"></script>


        <!--Morris.js [ OPTIONAL ]-->



        <!--Sparkline [ OPTIONAL ]-->
        <script src="/assets/inside/plugins/sparkline/jquery.sparkline.min.js"></script>

        <script src="/assets/inside/plugins/chosen/chosen.jquery.min.js"></script>


        <!--Skycons [ OPTIONAL ]-->
        <script src="/assets/inside/plugins/skycons/skycons.min.js"></script>


        <!--Switchery [ OPTIONAL ]-->
        <script src="/assets/inside/plugins/switchery/switchery.min.js"></script>


        <!--Bootstrap Select [ OPTIONAL ]-->
        <script src="/assets/inside/plugins/bootstrap-select/bootstrap-select.min.js"></script>


        <!--Demo script [ DEMONSTRATION ]-->
        <script src="/assets/inside/js/demo/nifty-demo.min.js"></script>

        <!--DataTables [ OPTIONAL ]-->
        <script src="/assets/inside/plugins/data-tables/jquery.dataTables.min.js"></script>
        <script src="/assets/inside/plugins/data-tables/dataTables.bootstrap.js"></script>
        <script src="/assets/inside/plugins/data-tables/dataTables.responsive.min.js"></script>

        @yield('foot')
        <!--Specify page [ SAMPLE ]-->
</body>
</html>
