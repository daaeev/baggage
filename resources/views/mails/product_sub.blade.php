<div class="container">
    <p>Sorry, this <a href="{{route('single', ['bag' => $bag->slug])}}">{{$bag->name}}</a> is currently out of stock</p>
    <p>You can subscribe to a product. You will receive an email notification when the product becomes available</p>
    <p><a href="{{route('single', ['bag' => $bag->slug])}}#sub">Subscribe</a></p>
</div>
