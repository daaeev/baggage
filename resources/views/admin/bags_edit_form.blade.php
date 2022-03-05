@extends('layouts.admin')

@section('title')
    Create bag
@endsection

@section('content')

    @include('admin.errors')

    <form action="{{route('admin.bags.edit', ['id' => $bag->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        <label>Edit bag with id {{$bag->id}}</label>

        <input name="name" type="text" placeholder="Name" class="form-control mb-2" autocomplete="off" required value="{{$bag->name}}">
        <textarea name="description" placeholder="Description" class="form-control mb-2" autocomplete="off">{{$bag->description}}</textarea>
        <input name="price" type="number" step="any" min="0" placeholder="Price (grivna)" class="form-control mb-2" autocomplete="off" required value="{{$bag->price}}">
        <input name="discount_price" type="number" step="any" min="0" placeholder="Discount price (grivna)" class="form-control mb-2" autocomplete="off" value="{{$bag->discount_price}}">
        <input name="count" type="number" min="0" placeholder="Count" class="form-control mb-2" autocomplete="off" required value="{{$bag->count}}">
        <input name="image" type="file" class="form-control mb-2" autocomplete="off" accept="image/*">

        <input type="submit" class="btn btn-success" value="Set">
    </form>
@endsection
