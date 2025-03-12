<?php
loadPartial("head");
loadPartial("navbar");
?>

<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--shopping cart area start -->
<?php
loadPartial("errors");
loadPartial("success");
?>
<div class="shopping_cart_area mt-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table_desc">
                    <div class="cart_page table-responsive">
                        <table>
                            <?php
                            $cart_subtotal = 0;
                            $fixed_shipping = 20;
                            if (isset($cart) && isset($products) && !empty($cart)):
                            ?>
                            <thead>
                            <tr>
                                <th class="product_thumb">Image</th>
                                <th class="product_name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product_quantity">Quantity</th>
                                <th class="product_total">Total</th>
                                <th class="product_remove">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($cart as $items):
                                if (isset($products[$items["product_id"]])){
                                    $product = $products[$items["product_id"]];
                                    $product_images = explode(",", $product->images);
                                    $price = (float) $product->price;
                                    $discount = (float) $product->discount;
                                    $product_price = round($price - ($price * ($discount / 100)),2);
                                    $product_total = round($product_price * (float) $items["quantity"],2);
                                    }
                                ?>
                                <tr>
                                    <td class="product_thumb">
                                        <a href="/product/<?= $items["product_id"] ?>">
                                            <img src="/assets/img/product/<?= $product_images[0] ?>" alt="">
                                        </a>
                                    </td>
                                    <td class="product_name">
                                        <a href="/product/<?= $items["product_id"] ?>"><?= $product->name ?></a>
                                    </td>
                                    <td class="product-price">$<?= $product_price ?></td>
                                    <td class="product_quantity">
                                        <form method="post" action="/cart/edit/">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="product_id"
                                                   value="<?= $items["product_id"] ?>">
                                            <label>Quantity</label>
                                            <input min="1" max="100" name="quantity"
                                                   value="<?= $items["quantity"] ?>" type="number">
                                            <button type="submit" class="button_strip">Update</button>
                                        </form>
                                    </td>
                                    <td class="product_total">$<?= $product_total ?></td>
                                    <?php $cart_subtotal += $product_total ?>
                                    <td class="product_remove">
                                        <form method="post" action="/cart/remove/<?= $items["product_id"] ?>">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="button_strip"><i class="ion-android-close"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--coupon code area start-->
        <?php if(isset($cart) && empty($cart)): ?>
        <div class="empty_cart_message">
            <h2>Your Cart is Empty</h2>
            <p>Looks like you haven't added anything to your cart yet. <a href="/products">Go
                    Shopping</a> and start filling up your cart!</p>
        </div>
        <?php else: ?>
        <div class="coupon_area">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code right">
                        <h3>Cart Totals</h3>
                        <div class="coupon_inner">
                            <div class="cart_subtotal">
                                <p>Subtotal</p>
                                <p class="cart_amount">$<?= $cart_subtotal ?></p>
                            </div>
                            <div class="cart_subtotal">
                                <p>Shipping</p>
                                <p class="cart_amount"><span>Flat Rate:</span> $<?= $fixed_shipping ?></p>
                            </div>

                            <div class="cart_subtotal">
                                <p>Total</p>
                                <p class="cart_amount">$<?= $cart_subtotal + $fixed_shipping ?></p>
                            </div>
                            <div class="checkout_btn">
                                <a href="<?= \Core\Session::has('user') ? '/checkout' : '/login' ?>">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!--coupon code area end-->
    </div>
</div>
<!--shopping cart area end -->

<script>
</script>

<?php loadPartial("footer"); ?>
