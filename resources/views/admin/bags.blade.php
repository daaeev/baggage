@extends('layouts.admin')

@section('title')
    Bags
@endsection

@section('content')

    @include('admin.errors')

    <form action="{{route('admin.bags.edit.form')}}" method="get" class="mb-5">
        <label>Edit</label>

        <input name="id" type="number" min="1" placeholder="Bag id" class="form-control mb-2" autocomplete="off">

        <input type="submit" class="btn btn-success" value="Edit">
    </form>

    <form action="{{route('admin.bags.delete')}}" method="get" class="mb-5">
        <label>Delete</label>

        <input name="id" type="number" min="1" placeholder="Bag id" class="form-control mb-2" autocomplete="off">

        <input type="submit" class="btn btn-danger" value="Delete">
    </form>

    <a href="{{route('admin.bags.create.form')}}" class="btn btn-success mb-1">Add bag</a>
    <?= $grid ?>
@endsection
