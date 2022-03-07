@extends('layouts.admin')

@section('title')
    Orders
@endsection

@section('content')

    @include('admin.errors')

    <form action="" method="post" class="mb-5">
        @csrf
        <label>Accept order</label>

        <input name="id" type="number" min="1" placeholder="User id" class="form-control mb-2" autocomplete="off" value="{{old('id')}}">

        <input type="submit" class="btn btn-success" value="Accept">
    </form>

    <form action="{{route('admin.orders.decline')}}" method="post" class="mb-5">
        @csrf
        <label>Decline order</label>

        <input name="order_id" type="number" min="1" placeholder="User id" class="form-control mb-2" autocomplete="off" value="{{old('id')}}">

        <input type="submit" class="btn btn-danger" value="Decline">
    </form>

    <?= $grid ?>
@endsection
