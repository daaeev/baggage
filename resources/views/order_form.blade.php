@extends('layouts.inner')

@section('title')
    Создание заказа
@endsection

@section('content')
    <section class="banner-bottom py-5">
        <div class="container">
            <div class="content-grid">
                <div class="text-center icon">
                    <h3>{{ __('Create order') }}</h3><br>
                </div>
                <div class="content-bottom">
                    <form method="post" action="{{ route('product.order.create') }}">
                        @csrf

                        <input type="hidden" name="bag" value="{{$bag_slug}}">
                        <div class="field-group">
                            <div class="content-input-field">
                                <input type="text" class="form-control" name="name" autofocus autocomplete="off" placeholder="How can we call you">
                            </div>
                        </div>
                        <div class="field-group">
                            <div class="content-input-field">
                                <input type="tel" pattern="^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$" class="form-control" name="number" required placeholder="Your phone number">
                            </div>
                        </div>
                        <div class="content-input-field">
                            <button type="submit" class="btn">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

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
