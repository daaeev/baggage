<?php

use App\Models\User

?>

@extends('layouts.admin')

@section('title')
    Users
@endsection

@section('content')

    @if (session('status_failed'))
        <div class="alert alert-danger" role="alert">
            {{ __(session('status_failed')) }}
        </div>
    @endif

    @if (session('status_success'))
        <div class="alert alert-success" role="alert">
            {{ __(session('status_success')) }}
        </div>
    @endif

    <form action="{{route('admin.users.role')}}" method="get" class="mb-5">
        <label>Set role</label>

        <input name="id" type="text" id="userId" placeholder="user id" class="form-control">

        <select name="role" id="setRole" class="form-control h-50 mt-2">
            <option value="{{User::STATUS_USER}}">User</option>
            <option value="{{User::STATUS_ADMIN}}">Admin</option>
            <option value="{{User::STATUS_BANNED}}">Banned</option>
        </select>

        <input type="submit" class="btn btn-success mt-2" value="Set">
    </form>

    <?= $grid ?>
@endsection
