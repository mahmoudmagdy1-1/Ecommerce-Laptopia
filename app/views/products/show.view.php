<?php
loadPartial("head");
loadPartial("navbar");
//inspectAndDie($product);
?>

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li><?= $product->name ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

<?php
loadPartial("errors");
loadPartial("success");
?>
    <!--product details start-->
    <div class="product_details mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="/assets/img/product/<?= explode(",", $product->images)[0] ?>"
                                     data-zoom-image="/assets/img/product/<?= explode(",", $product->images)[0] ?>"
                                     alt="<?= explode(",", $product->images_alt)[0] ?>">
                            </a>
                        </div>
                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">

                                <?php
                                $images = explode(",", $product->images);
                                for ($i = 0; $i < count($images); $i++):
                                    $image = $images[$i];
                                    $alt = explode(",", $product->images_alt)[$i];
                                    ?>
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update=""
                                           data-image="/assets/img/product/<?= $image ?>"
                                           data-zoom-image="/assets/img/product/<?= $image ?>">
                                            <img src="/assets/img/product/<?= $image ?>" alt="<?= $alt ?>">
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">

                        <h1><?= $product->name ?></h1>
                    </div>
                    <div class="price_box">
                        <?php if ($product->discount > 0): ?>
                            <span class="current_price">$<?= (int)($product->price - ($product->price * ($product->discount / 100))) ?></span>
                            <span class="old_price">$<?= (int)$product->price ?></span>
                        <?php else: ?>
                            <span class="current_price">$<?= (int)$product->price ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="product_desc">
                        <ul>
                            <li>In Stock</li>
                        </ul>
                        <p><?= $product->description ?></p>
                    </div>
                    <?php if(!\Core\Session::has('user') || (\Core\Session::has('user') && \Core\Session::get('user')['role'] !== 'admin')): ?>
                    <form method="post" action="/cart/add">
                        <div class="product_variant quantity">
                            <label>quantity</label>
                            <input type="hidden" name="product_id" value="<?= $product_id ?>">
                            <input min="1" max="100" name="quantity" value="1" type="number">
                            <button class="button" type="submit">add to cart</button>
                        </div>
                    </form>
                    <?php endif; ?>
                    <div class="product_meta">
                        <span>Category: <a href="#"><?= $product->category ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--product details end-->

    <!--product info start-->
    <div class="product_d_info mb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                                       aria-selected="false">Reviews (0)</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">


                            <div class="tab-pane fade show active" id="reviews" role="tabpanel">
                                <div class="reviews_wrapper">
                                    <div class="reviews_comment_box">
                                        <div class="comment_thmb">
                                            <img src="assets/img/blog/comment2" alt="">
                                        </div>
                                    </div>
                                    <div class="comment_title">
                                        <h2>Add a review </h2>
                                        <p>Your email address will not be published. Required fields are marked </p>
                                    </div>
                                    <div class="product_review_form">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="review_comment">Your review </label>
                                                    <textarea name="comment" id="review_comment"></textarea>
                                                </div>
                                            </div>
                                            <button type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product info end-->


<?php loadPartial("footer"); ?>