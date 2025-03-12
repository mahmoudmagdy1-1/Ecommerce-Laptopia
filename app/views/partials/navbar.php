<body>

<!--header area start-->
<!--Offcanvas menu area start-->
<div class="off_canvars_overlay">

</div>
<div class="Offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="Offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>
                    <div class="support_info">
                        <p>Any Enquiry: <a href="tel:">+56985475235</a></p>
                    </div>
                    <div class="top_right text-right">
                        <ul>
                            <li><a href="/login"> My Account </a></li>
                            <li><a href="/checkout"> Checkout </a></li>
                        </ul>
                    </div>
                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class="menu-item-has-children active">
                                <a href="/">Home</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="/products">product</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="/login">my account</a>
                            </li>
                        </ul>
                    </div>

                    <div class="Offcanvas_footer">
                        <span><a href="#"><i class="fa fa-envelope-o"></i> info@drophunt.com</a></span>
                        <ul>
                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Offcanvas menu area end-->

<header>
    <div class="main_header">
        <!--header top start-->
        <div class="header_top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="support_info">
                            <p>Email: <a href="mailto:">support@laptopia.com</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="top_right text-right">
                            <ul>
                                <?php
                                    if (\Core\Session::has('user')) :
                                ?>
                                    <li><a href="/profile"><?= \Core\Session::get('user')['name'] ?></a></li>
                                    <li><form method="post" action="/logout"><button class="button_strip logout-button">Logout</button></form></li>
                                <?php else: ?>
                                <li><a href="/login">Login</a></li>
                                <li><a href="/register">Register</a></li>
                                <?php endif; ?>
                                <?php if (!\Core\Session::has('user') || (\Core\Session::has('user') && \Core\Session::get('user')['role'] !== 'admin')):?>
                                <li><a href="/checkout">Checkout</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--header top start-->
        <!--header middel start-->
        <div class="header_middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="logo">
                            <a href="/"><img src="/assets/img/logo/logo.png" alt="" style="width: 100px;"></a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-6">
                        <div class="middel_right">
                            <div class="middel_right_info">
                                <div class="header_wishlist">
                                    <?php if (\Core\Session::has('user')): ?>
                                    <a href="/profile"><img src="/assets/img/user.png" alt=""></a>
                                    <?php else: ?>
                                    <a href="/login"><img src="/assets/img/user.png" alt=""></a>
                                    <?php endif; ?>
                                </div>
                                <div class="mini_cart_wrapper">
                                    <?php if (!\Core\Session::has('user') || (\Core\Session::has('user') && \Core\Session::get('user')['role'] !== 'admin')):?>
                                    <a href="/cart"><img src="/assets/img/shopping-bag.png" alt=""></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--header middel end-->
        <!--header bottom start-->
        <div class="main_menu_area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="main_menu menu_position">
                            <nav>
                                <ul>
                                    <li><a href="/">home</a></li>
                                    <li><a href="/products">Products</a></li>
                                        <?php
                                            if(\Core\Session::has('user') && \Core\Session::get('user')['role'] == 'admin'):
                                        ?>
                                    <li><a href="/admin">Admin Dashboard</a></li>
                                    <?php else: ?>
                                    <li><a href="/orders"> Orders</a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--header bottom end-->
    </div>
</header>
<!--header area end-->
