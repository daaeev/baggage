<?php
use App\Services\UrlGen;
?>

@extends('layouts.inner')

@section('title')
    Авторизация
@endsection

@section('content')
    <!--/login -->
    <section class="banner-bottom py-5">
        <div class="container">
            <div class="content-grid">
                <div class="text-center icon">
                    <span class="fa fa-unlock-alt"></span>
                </div>
                <div class="content-bottom">
                    <form action="#" method="post">
                        <div class="field-group">

                            <div class="content-input-field">
                                <input name="text1" id="text1" type="text" value="" placeholder="User Name" required="">
                            </div>
                        </div>
                        <div class="field-group">
                            <div class="content-input-field">
                                <input name="password" id="myInput" type="Password" placeholder="Password">
                            </div>
                        </div>
                        <div class="content-input-field">
                            <button type="submit" class="btn">Sign In</button>
                        </div>
                        <ul class="list-login">
                            <li class="switch-slide">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                    keep Logged in
                                </label>
                            </li>
                            <li>
                                <a href="#" class="text-right">Forgot password?</a>
                            </li>
                            <li class="clearfix"></li>
                        </ul>
                        <ul class="list-login-bottom">
                            <li class="">
                                <a href="<?= UrlGen::register() ?>" class="">Don't have an Account?</a>
                            </li>
                            <li class="clearfix"></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /login -->
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
