@extends('layouts.inner')

@section('title')
    Profile
@endsection

@section('content')
    <!--/banner-bottom -->
    <section class="banner-bottom py-5">
        <div class="container py-md-5">
            <div class="row text-center">
                <div class="col-12">
                    <p><h3>{{$user->name}}</h3></p>
                    <p>
                        <strong>Email:</strong>
                        {{$user->email}}
                        @if (!$user->hasVerifiedEmail())
                            <strong><a href="{{route('verification.notice')}}" class="text-danger">Verify email</a></strong>
                        @else
                            <span class="text-success">Email verified</span>
                        @endif
                    </p>
                    <p>
                        <a class="text-primary" href="{{route('password.update')}}">Change password</a>
                    </p>
                    <br><p>
                        <a class="btn btn-danger" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- /banner-bottom -->
    <!--/shipping-->
    <section class="shipping-wthree">
        <div class="shiopping-grids d-lg-flex">
            <div class="col-lg-4 shiopping-w3pvt-gd text-center">
                <div class="icon-gd"><span class="fa fa-truck" aria-hidden="true"></span>
                </div>
                <div class="icon-gd-info">
                    <h3>FREE SHIPPING</h3>
                    <p>On all order over $2000</p>
                </div>
            </div>
            <div class="col-lg-4 shiopping-w3pvt-gd sec text-center">
                <div class="icon-gd"><span class="fa fa-bullhorn" aria-hidden="true"></span></div>
                <div class="icon-gd-info">
                    <h3>FREE RETURN</h3>
                    <p>On 1st exchange in 30 days</p>
                </div>
            </div>
            <div class="col-lg-4 shiopping-w3pvt-gd text-center">
                <div class="icon-gd"> <span class="fa fa-gift" aria-hidden="true"></span></div>
                <div class="icon-gd-info">
                    <h3>MEMBER DISCOUNT</h3>
                    <p>Register &amp; save up to $29%</p>
                </div>

            </div>
        </div>

    </section>
    <!--//shipping-->
@endsection
