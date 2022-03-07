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

</head>
<body>
<header>
    @include('layouts.menu.admin_top')
</header>

<div class="container mt-5">
    @yield('content')
</div>

</body>
</html>
