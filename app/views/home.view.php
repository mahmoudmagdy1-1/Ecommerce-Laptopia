<?php
loadPartial("head");
loadPartial("navbar");
?>

    <!--slider area start-->
    <section class="slider_section d-flex align-items-center">
        <div class="slider_area owl-carousel">
            <div class="single_slider d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="slider_content">
                                <h1>Next level of Laptops</h1>
                                <h2>Insane Quality for use</h2>
                                <p>Special offer <span> 20% off </span> this week</p>
                                <a class="button" href="/products">Buy now</a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="slider_content">
                                <img src="assets/img/home-2.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="single_slider d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="slider_content">
                                <h1>Best Hardware Included</h1>
                                <h2>100% Flexible</h2>
                                <p>exclusive offer <span> 20% off </span> this week</p>
                                <a class="button" href="/products">Shop now</a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="slider_content">
                                <img src="/assets/img/home-3.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_slider d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="slider_content">
                                <h1>With some gifts</h1>
                                <h2>Special one for you</h2>
                                <p>exclusive offer <span> 20% off </span> this week</p>
                                <a class="button" href="/products">shopping now</a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="slider_content">
                                <img src="assets/img/home-1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--slider area end-->

    <!--Tranding products-->
    <section class="pt-60 pb-30 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="section-title">
                        <h2>Trending Products</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <!--                --><?php //= inspect(); ?>
<!--                                --><?php //inspectAndDie($products); ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="single-tranding">
                            <!--                        --><?php //= inspectAndDie($products) ?>
                            <!--                        <form action="/products/-->
                            <?php //= $products->product_id; ?><!--"></form>-->
                            <a href="/product/<?= $product->product_id; ?>">
                                <div class="tranding-pro-img">
                                    <img src="/assets/img/product/<?= explode(",", $product->images)[0] ?>"
                                         alt="<?= explode(",", $product->images_alt)[0] ?>">
                                </div>
                                <div class="tranding-pro-title">
                                    <h3><?= $product->name; ?></h3>
                                    <h4><?= $product->category; ?></h4>
                                </div>
                                <div class="tranding-pro-price">
                                    <div class="price_box">
                                        <?php if ($product->discount > 0): ?>
                                        <span class="current_price">$<?= (int)($product->price - ($product->price * ($product->discount / 100))) ?></span>
                                        <span class="old_price">$<?= (int)$product->price ?></span>
                                        <?php else: ?>
                                        <span class="current_price">$<?= (int)$product->price ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section><!--Tranding products-->

    <!--Features area-->
    <section class="features-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="section-title">
                        <h2>Awesome Features</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-features">
                        <img src="assets/img/icon/1.png" alt="">
                        <h3>Blazing Fast Performance</h3>
                        <p>Experience cutting-edge speed with our carefully selected laptops, powered by the latest
                            processors, high-speed SSD storage, and optimized RAM. Whether you're gaming, editing, or
                            multitasking, Laptopia ensures smooth, lag-free performance every time.</p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-features">
                        <img src="assets/img/icon/2.png" alt="">
                        <h3>All-Day Battery Life</h3>
                        <p>Stay productive without worrying about charging! Our laptops are designed to last, featuring
                            energy-efficient processors and long-lasting batteries that keep you powered throughout your
                            workday, study sessions, or travel adventures.
                        </p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-features">
                        <img src="assets/img/icon/3.png" alt="">
                        <h3>Handpicked for Quality</h3>
                        <p>We take the guesswork out of laptop shopping by curating only the best, high-performance
                            models. Every laptop on Laptopia undergoes a strict selection process to ensure reliability,
                            durability, and top-tier functionality—so you get the best, every time.
                        </p>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                    <a href="#"><img src="assets/img/product/2.png" alt=""></a>
                </div>
            </div>
        </div>
    </section><!--Features area-->
    <!--Testimonials-->
    <section class="pb-60 pt-60 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="testimonial_are">
                        <div class="testimonial_active owl-carousel">
                            <article class="single_testimonial">
                                <figure>
                                    <div class="testimonial_thumb">
                                        <a href="#"><img src="assets/img/about/team-2.jpg" alt=""></a>
                                    </div>
                                    <figcaption class="testimonial_content">
                                        <p>Perfect for working on the go! It’s fast, lightweight, and the battery is
                                            amazing. Couldn’t be happier!"</p>
                                        <h3>Kathy Young<span> - Content Creator</span></h3>
                                    </figcaption>

                                </figure>
                            </article>
                            <article class="single_testimonial">
                                <figure>
                                    <div class="testimonial_thumb">
                                        <a href="#"><img src="assets/img/about/team-1.jpg" alt=""></a>
                                    </div>
                                    <figcaption class="testimonial_content">
                                        <p>This laptop is a beast! Super fast, handles all my tasks effortlessly, and
                                            the battery lasts all day. Perfect for work and gaming!</p>
                                        <h3>David Carter<span> - Customer</span></h3>
                                    </figcaption>

                                </figure>
                            </article>
                            <article class="single_testimonial">
                                <figure>
                                    <div class="testimonial_thumb">
                                        <a href="#"><img src="assets/img/about/team-3.jpg" alt=""></a>
                                    </div>
                                    <figcaption class="testimonial_content">
                                        <p>Runs every game I throw at it with no lag. The display is crisp, and the
                                            cooling system works great. Definitely worth it!</p>
                                        <h3>John Sullivan<span> - Gamer & Twitch Streamer</span></h3>
                                    </figcaption>

                                </figure>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/Testimonials-->

    <!--Blog-->
    <section class="pt-60">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="section-title">
                        <h2>Blog Posts</h2>
                    </div>
                </div>
            </div>
            <div class="row blog_wrapper">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                    <article class="single_blog mb-60">
                        <figure>
                            <div class="blog_thumb">
                                <a href="blog-details.html"><img src="assets/img/blog/blog2.jpg" alt=""></a>
                            </div>
                            <figcaption class="blog_content">
                                <h3><a href="blog-details.html">How to start drone</a></h3>
                                <div class="blog_meta">
                                    <span class="author">Posted by : <a href="#">Rahul</a> / </span>
                                    <span class="post_date"><a href="#">Sep 20, 2019</a></span>
                                </div>
                                <div class="blog_desc">
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout. The point of using Lorem Ipsum is
                                        that it has a more-or-less</p>
                                </div>
                                <footer class="readmore_button">
                                    <a href="blog-details.html">read more</a>
                                </footer>
                            </figcaption>
                        </figure>
                    </article>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                    <article class="single_blog blog_bidio mb-60">
                        <figure>
                            <div class="blog_thumb">
                                <a href="blog-details.html"><img src="assets/img/blog/blog1.jpg" alt=""></a>
                            </div>
                            <figcaption class="blog_content">
                                <h3><a href="blog-details.html">See the tutorial</a></h3>
                                <div class="blog_meta">
                                    <span class="author">Posted by : <a href="#">Rahul</a> / </span>
                                    <span class="post_date">On : <a href="#">Aug 25, 2019</a></span>
                                </div>
                                <div class="blog_desc">
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout. The point of using Lorem Ipsum is
                                        that it has a more-or-less</p>
                                </div>
                                <footer class="readmore_button">
                                    <a href="blog-details.html">read more</a>
                                </footer>
                            </figcaption>
                        </figure>
                    </article>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                    <article class="single_blog mb-60">
                        <figure>
                            <div class="blog_thumb">
                                <a href="blog-details.html"><img src="assets/img/blog/blog-details.jpg" alt=""></a>
                            </div>
                            <figcaption class="blog_content">
                                <h3><a href="blog-details.html">How to start drone</a></h3>
                                <div class="blog_meta">
                                    <span class="author">Posted by : <a href="#">Rahul</a> / </span>
                                    <span class="post_date"><a href="#">Sep 20, 2019</a></span>
                                </div>
                                <div class="blog_desc">
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout. The point of using Lorem Ipsum is
                                        that it has a more-or-less</p>
                                </div>
                                <footer class="readmore_button">
                                    <a href="blog-details.html">read more</a>
                                </footer>
                            </figcaption>
                        </figure>
                    </article>
                </div>
            </div>
        </div>
    </section><!--/Blog-->

    <!--shipping area start-->
    <section class="shipping_area">
        <div class="container">
            <div class=" row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="assets/img/about/shipping1.png" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>Free Shipping</h2>
                            <p>Free shipping on all US order</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="assets/img/about/shipping2.png" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>Support 24/7</h2>
                            <p>Contact us 24 hours a day</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="assets/img/about/shipping3.png" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>100% Money Back</h2>
                            <p>You have 30 days to Return</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="assets/img/about/shipping4.png" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>Payment Secure</h2>
                            <p>We ensure secure payment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--shipping area end-->

<?php loadPartial("footer"); ?>