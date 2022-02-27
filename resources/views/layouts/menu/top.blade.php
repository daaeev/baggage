<?php

use App\Services\UrlGen;

?>

<div class="nav-top-wthree">
    <nav>
        <label for="drop" class="toggle"><span class="fa fa-bars"></span></label>
        <input type="checkbox" id="drop" />
        <ul class="menu">
            <li {{--class="active"--}}><a href="<?= UrlGen::index() ?>">Home</a></li>
            <li><a href="<?= UrlGen::about() ?>">About Us</a></li>
            <li>
                <!-- First Tier Drop Down -->
                <label for="drop-2" class="toggle">Dropdown <span class="fa fa-angle-down" aria-hidden="true"></span>
                </label>
                <a href="<?= UrlGen::catalog() ?>">Shop <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                <input type="checkbox" id="drop-2" />
                <ul>
                    <li><a href="coming.html" class="drop-text">Category</a></li>
                </ul>
            </li>

            <li><a href="<?= UrlGen::contact() ?>">Contact</a></li>
            <li><a href="<?= UrlGen::newsletter() ?>">Newsletter</a></li>
        </ul>
    </nav>
    <!-- //nav -->
    <div class="search-form ml-auto">
        <div class="form-w3layouts-grid">
            <form action="#" method="post" class="newsletter">
                <input class="search" type="search" placeholder="Search here..." required="">
                <button class="form-control btn" value=""><span class="fa fa-search"></span></button>
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
