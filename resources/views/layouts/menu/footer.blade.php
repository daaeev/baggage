<?php

use App\Services\UrlGen;

?>
<div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-4">
    <ul class="footer_wthree_gridf_list">
        <li>
            <a href="<?= UrlGen::index() ?>"><span class="fa fa-angle-right" aria-hidden="true"></span> Home</a>
        </li>
        <li>
            <a href="<?= UrlGen::about() ?>"><span class="fa fa-angle-right" aria-hidden="true"></span> About</a>
        </li>
        <li>
            <a href="<?= UrlGen::catalog() ?>"><span class="fa fa-angle-right" aria-hidden="true"></span> Shop</a>
        </li>

    </ul>
</div>
<div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-sm-4 mt-3">
    <ul class="footer_wthree_gridf_list">
        <li>
            <a href="#"><span class="fa fa-angle-right" aria-hidden="true"></span> Terms & Conditions</a>
        </li>
        <li>
            <a href="<?= UrlGen::contact() ?>"><span class="fa fa-angle-right" aria-hidden="true"></span> Contact Us</a>
        </li>
        <li>
            <a href="<?= UrlGen::newsletter() ?>"><span class="fa fa-angle-right" aria-hidden="true"></span> Newsletter</a>
        </li>
    </ul>
</div>

<div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-sm-4 mt-3">
    <ul class="footer_wthree_gridf_list">
        <li>
            <a href="login.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Login </a>
        </li>

        <li>
            <a href="register.html"><span class="fa fa-angle-right" aria-hidden="true"></span>Register</a>
        </li>
        <li>
            <a href="#"><span class="fa fa-angle-right" aria-hidden="true"></span>Privacy & Policy</a>
        </li>
    </ul>
</div>
