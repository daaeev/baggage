<?php

use App\Models\User

?>

@extends('layouts.admin')

@section('title')
    Users
@endsection

@section('content')

    @include('admin.errors')

    <form action="{{route('admin.users.role')}}" method="get" class="mb-5">
        <label>Set role</label>

        <input name="id" type="number" min="1" placeholder="User id" class="form-control mb-2" autocomplete="off" value="{{old('id')}}">

        <select name="role" class="form-control h-50 mb-2">
            <option value="{{User::STATUS_USER}}">User</option>
            <option value="{{User::STATUS_ADMIN}}">Admin</option>
            <option value="{{User::STATUS_BANNED}}">Banned</option>
        </select>

        <input type="submit" class="btn btn-success" value="Set">
    </form>

    <?= $grid ?>
@endsection
