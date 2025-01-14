<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>

    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Baggage Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <!-- //Meta tag Keywords -->

    <!-- Custom-Files -->
    <link rel="stylesheet" href="/css/bootstrap.css">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />
    <!-- Style-CSS -->
    <!-- font-awesome-icons -->
    <link href="/css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome-icons -->
    <!-- /Fonts -->
    <link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
    <!-- //Fonts -->

</head>

<body>
    <div class="main-sec">
        <!-- //header -->
        <header class="py-sm-3 pt-3 pb-2" id="home">
            <div class="container">
                <!-- nav -->
                <div class="top-w3pvt d-flex">
                    <div id="logo">
                        <h1> <a href="{{route('home')}}"><span class="log-w3pvt">B</span>aggage</a> <label class="sub-des">Online Store</label></h1>
                    </div>

                    <div class="forms ml-auto">

                        @auth
                            <a class="btn" href="{{ route('profile') }}">
                                <span class="fa fa-user-circle-o"></span> Profile
                            </a>

                            @admin
                                <a class="btn" href="{{ route('admin.users') }}">
                                    <span class="fa fa-pencil-square-o"></span> Admin panel
                                </a>
                            @endadmin
                        @else
                            <a href="{{route('login')}}" class="btn"><span class="fa fa-user-circle-o"></span> Sign In</a>
                            <a href="{{route('register')}}" class="btn"><span class="fa fa-pencil-square-o"></span> Sign Up</a>
                        @endauth

                    </div>
                </div>

                @include('layouts.menu.top')

            </div>
        </header>
        <!-- //header -->
        <!--/banner-->
        <div class="banner-wthree-info container">
            <div class="row">
                <div class="col-lg-5 banner-left-info">
                    <h3>The Largest Range <span>of HandBags</span></h3>
                    <a href="{{route('catalog')}}" class="btn shop">Shop Now</a>
                </div>

                <div class="col-lg-7 banner-img">
                    <img src="images/bag.png" alt="part image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <!-- //banner-->

    @yield('content')

        <!-- footer -->
        <div class="footer_agileinfo_topf py-5">
        <div class="container py-md-5">
            <div class="row">
                <div class="col-lg-3 footer_wthree_gridf mt-lg-5">
                    <h2><a href="{{route('home')}}"><span>B</span>aggage
                        </a> </h2>
                    <label class="sub-des2">Online Store</label>
                </div>

                @include('layouts.menu.footer')

            </div>

            <div class="w3ls-fsocial-grid">
                <h3 class="sub-w3ls-headf">Follow Us</h3>
                <div class="social-ficons">
                    <ul>
                        <li><a href="#"><span class="fa fa-facebook"></span> Facebook</a></li>
                        <li><a href="#"><span class="fa fa-twitter"></span> Twitter</a></li>
                        <li><a href="#"><span class="fa fa-google"></span>Google</a></li>
                    </ul>
                </div>
            </div>
            <div class="move-top text-center mt-lg-4 mt-3">
                <a href="#home"><span class="fa fa-angle-double-up" aria-hidden="true"></span></a>
            </div>
        </div>
    </div>
    <!-- //footer -->

    <!-- copyright -->
    <div class="cpy-right text-center py-3">
        <p>© 2019 Baggage. All rights reserved | Design by
            <a href="http://w3layouts.com"> W3layouts.</a>
        </p>

    </div>
    <!-- //copyright -->

</body>

</html>
