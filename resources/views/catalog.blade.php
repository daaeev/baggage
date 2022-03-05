@extends('layouts.inner')

@section('title')
    Каталог
@endsection

@section('content')
<!--/banner-bottom -->
<section class="banner-bottom py-5">
    <div class="container py-5">
        <h3 class="title-wthree mb-lg-5 mb-4 text-center">Shop Now</h3>

        @if (!empty($search))
            <h5 class="mb-2 text-center">Search result for: '{{$search}}'</h5>
        @endif
        <!--/row-->
        <div class="row shop-wthree-info text-center">
            @foreach($catalog as $product)
                <div class="col-lg-3 shop-info-grid text-center mt-4">
                <div class="product-shoe-info shoe">
                    <div class="men-thumb-item">
                        <img src="{{asset('storage/' . $product->image)}}" class="img-fluid" alt="product_preview">

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
            @endforeach
        </div>
        <!--//row-->

        {{ $catalog->links() }}
    </div>
</section>
<!-- /banner-bottom -->
<!--/newsletter -->
<section class="newsletter-w3pvt py-5">
    <div class="container py-md-5">
        <form method="post" action="#">
            <p class="text-center">Subscribe to the Handbags Store mailing list to receive updates on new arrivals, special offers and other discount information.</p>
           <div class="row subscribe-sec">
                <div class="col-md-9">
                    <input type="email" class="form-control" id="email" placeholder="Enter Your Email.." name="email" required="">

                </div>
                <div class="col-md-3">

                    <button type="submit" class="btn submit">Subscribe</button>
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
