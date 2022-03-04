@extends('layouts.admin')

@section('title')
    Bags
@endsection

@section('content')

    @if (session('status_success'))
        <div class="alert alert-danger" role="alert">
            {{ __(session('status_success')) }}
        </div>
    @endif

    <form action="" method="get" class="mb-5">
        <label>Set discount price</label>

        <input name="id" type="text" id="bagId" placeholder="Bag id" class="form-control mb-2" autocomplete="off">
        <input name="id" type="number" id="discountPrice" placeholder="Discount price (grivna)" class="form-control mb-2" autocomplete="off">

        <input type="submit" class="btn btn-success" value="Set">
    </form>

    <a href="{{route('admin.bags.create.form')}}" class="btn btn-success mb-1">Add bag</a>
    <?= $grid ?>
@endsection
