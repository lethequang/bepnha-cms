<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>


    <!--STYLESHEET-->
    <!--=================================================-->

    <!--Open Sans Font [ OPTIONAL ] -->
     <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">

    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="/assets/inside/css/bootstrap.min.css" rel="stylesheet">

    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="/assets/inside/css/nifty.min.css" rel="stylesheet">

    <!--Font Awesome [ OPTIONAL ]-->
    <link href="/assets/inside/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!--Demo [ DEMONSTRATION ]-->
    <link href="/assets/inside/css/demo/nifty-demo.min.css" rel="stylesheet">

    <link href="/assets/inside/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="/assets/inside/plugins/pace/pace.min.js"></script>

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
    <div id="container" class="cls-container">

        <!-- BACKGROUND IMAGE -->
        <!--===================================================-->
        <div id="bg-overlay" class="bg-img img-balloon" style="background-image: none;"></div>


        <!-- LOGIN FORM -->
        <!--===================================================-->
        <div class="cls-content">
            @yield('content')
        </div>
        <!--===================================================-->

    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->



    <!--JAVASCRIPT-->
    <!--=================================================-->

    <!--jQuery [ REQUIRED ]-->
    <script src="/assets/inside/js/jquery-2.1.1.min.js"></script>


    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="/assets/inside/js/bootstrap.min.js"></script>


    <!--Fast Click [ OPTIONAL ]-->
    <script src="/assets/inside/plugins/fast-click/fastclick.min.js"></script>


    <!--Nifty Admin [ RECOMMENDED ]-->
    <script src="/assets/inside/js/nifty.min.js"></script>


    <!--Background Image [ DEMONSTRATION ]-->
    <script src="/assets/inside/js/demo/bg-images.js"></script>

</body>
</html>