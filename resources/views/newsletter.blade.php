@extends('layouts.inner')

@section('title')
    Рассылка
@endsection

@section('content')
    <!--/newsletter -->
    <section class="newsletter-w3pvt py-5 text-center">
        <div class="container py-md-5">
            <form method="post" class="py-md-5" action="#">
                <h3 class="title-wthree my-lg-5 my-4 text-center">Under Construction</h3>
                <p class="text-center">Our Services page is currently undergoing scheduled maintenance. We should be back shortly. Thank you for your patience.</p>
                <div class="row subscribe-sec pb-md-5">
                    <div class="col-sm-9 pl-md-0">
                        <input type="email" class="form-control" id="email" placeholder="Enter Your Email.." name="email" required="">

                    </div>
                    <div class="col-sm-3">

                        <button type="submit" class="btn submit">Subscribe</button>
                    </div>
                    <p class="mt-3 get-inf">Sign up now to get early notification!</p>
                </div>

            </form>
        </div>
    </section>
    <!--//newsletter -->
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
