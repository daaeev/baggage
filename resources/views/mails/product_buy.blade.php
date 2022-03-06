<div class="container" style="text-align: center">
    <p>Product <a href="{{route('single', ['bag' => $bag->slug])}}">{{$bag->name}}</a> in stock</p>
    <p>Description: {{$bag->description}}</p>
    <p>
        Price:
        @if ($bag->discount_price)
            {{$bag->discount_price}}грн
        @else
            {{$bag->price}}грн
        @endif
    </p>
    <p>Order a product: <a href="{{route('product.order.form', ['bag_slug' => $bag->slug])}}">Create order</a></p>
</div>
