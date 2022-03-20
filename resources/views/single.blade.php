@extends('layouts.inner')

@section('title')
    Сумка
@endsection

@section('content')
    <!--/banner-bottom -->
    <section class="banner-bottom py-5">
        <div class="container py-md-5">
            <!-- product right -->
            <div class="left-ads-display wthree">
                <div class="row">
                    <div class="desc1-left col-md-6">
                        <img src="{{asset('storage/bags_preview/' . $bag->image)}}" class="img-fluid" alt="bag_preview">
                    </div>
                    <div class="desc1-right col-md-6 pl-lg-3">
                        <h3>{{$bag->name}}</h3>
                        <h5>
                            @if ($bag->discount_price)
                                {{$bag->discount_price}}грн <span>{{$bag->price}}</span>
                            @else
                                {{$bag->price}}грн
                            @endif

                        </h5>

                        <div class="available mt-3">
                            @auth
                                <form action="{{route('product.check', ['id' => $bag->id])}}" method="get" class="w3pvt-newsletter subscribe-sec">
                                    <input type="email" name="email" placeholder="Enter your email..." required>
                                    <button class="btn submit">Check</button>

                                    @if (session('email_send'))
                                        <span class="alert alert-success">{{session('email_send')}}</span>
                                    @endif
                                </form>
                            @else
                                <h2><a href="{{route('login')}}">Login to offer </a></h2>
                            @endauth

                            <p class="mt-5">{{substr($bag->description, 0, 90)}}.. </p>
                        </div>

                        <div class="share-desc mt-5">
                            <div class="share text-left">
                                <h4>Share Product :</h4>
                                <div class="social-ficons mt-4">
                                    <ul>
                                        <li><a href="#"><span class="fa fa-facebook"></span> Facebook</a></li>
                                        <li><a href="#"><span class="fa fa-twitter"></span> Twitter</a></li>
                                        <li><a href="#"><span class="fa fa-google"></span>Google</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>


                </div>
                <div class="sub-para-w3pvt my-5">
                    <h3 class="shop-sing">{{$bag->name}}</h3>
                    <p>{{$bag->description}}</p>
                </div>


                <!--/row-->
                <h3 class="title-wthree-single my-lg-5 my-4 text-left">Featured Bags</h3>

                @if(!$featured->isEmpty())
                    @foreach($featured as $product)
                        <div class="row shop-wthree-info text-center">
                            <div class="col-md-3 shop-info-grid text-center mt-4">
                                <div class="product-shoe-info shoe">
                                    <div class="men-thumb-item">
                                        <img src="{{asset('storage/bags_preview/' . $product->image)}}" class="img-fluid" alt="product_preview">

                                    </div>
                                    <div class="item-info-product">
                                        <h4>
                                            <a href="{{route('single', ['bag' => $product->slug])}}"><?= mb_substr($product->name, 0, 20) ?>... </a>
                                        </h4>

                                        <div class="product_price">
                                            <div class="grid-price">
                                        <span class="money">
                                            @if ($product->discount_price)
                                                <span class="line">{{$product->price}}грн</span> {{$product->discount_price}}грн
                                            @else
                                                {{$product->price}}грн
                                            @endif
                                        </span>
                                            </div>
                                        </div>
                                        <ul class="stars">
                                            <li><a href="#"><span class="fa fa-star" aria-hidden="true"></span></a></li>
                                            <li><a href="#"><span class="fa fa-star" aria-hidden="true"></span></a></li>
                                            <li><a href="#"><span class="fa fa-star-half-o" aria-hidden="true"></span></a></li>
                                            <li><a href="#"><span class="fa fa-star-half-o" aria-hidden="true"></span></a></li>
                                            <li><a href="#"><span class="fa fa-star-o" aria-hidden="true"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No result</p>
                @endif
                <!--//row-->

            </div>
        </div>
    </section>
    <!-- /banner-bottom -->
    <!--/newsletter -->
    <a name="sub"></a>
    <section class="newsletter-w3pvt py-5">
        <div class="container py-md-5">
            <form method="post" action="{{route('product.sub')}}">
                @csrf
                <p class="text-center">If the product is out of stock - you can subscribe to a product. You will receive an email notification when the product becomes available</p>
                <div class="row subscribe-sec">
                    <div class="col-md-12 text-center">
                        <input type="hidden" name="slug" value="{{$bag->slug}}">
                        <button type="submit" class="btn submit">Subscribe</button>

                        @if (session('sub_status'))
                            <span class="alert alert-primary">{{session('sub_status')}}</span>
                        @endif

                        @if ($errors->has('slug'))
                            <span class="alert alert-danger">{{$errors->get('slug')[0]}}</span>
                        @endif

                    </div>
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
