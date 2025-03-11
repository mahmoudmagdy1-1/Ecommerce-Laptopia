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
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

<?php loadPartial("errors"); ?>

    <!--Checkout page section-->
    <div class="Checkout_section mt-60">
        <div class="container">
            <div class="checkout_form">
                <form method="POST" action="/checkout/order">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <label>Street address<span>*</span></label>
                                    <input placeholder="House number and street name" type="text" name="address" required>
                                </div>
                                <div class="col-12 mb-20">
                                    <label>Town / City <span>*</span></label>
                                    <input type="text" name="city" required>
                                </div>
                                <div class="col-12 mb-20">
                                    <label>State / County <span>*</span></label>
                                    <input type="text" name="state" required>
                                </div>
                                <div class="col-12">
                                    <div class="order-notes">
                                        <label for="order_note">Order Notes</label>
                                        <textarea id="order_note" rows="2" placeholder="Notes about your order, e.g. special notes for delivery." name="order_note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <h3>Your order</h3>
                            <div class="order_table table-responsive">
                                <table>
                                    <?php
                                    $cart_subtotal = 0;
                                    $fixed_shipping = 20;
                                    ?>
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (isset($products) && is_array($products) && !empty($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <?php $product_total = round($product['price'] * $product['quantity'], 2); ?>
                                            <tr>
                                                <td><?= $product['name'] ?> <strong> × <?= $product['quantity'] ?></strong></td>
                                                <td>$<?= $product_total ?></td>
                                            </tr>
                                            <?php $cart_subtotal += $product_total; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2">No items in cart</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Cart Subtotal</th>
                                        <td>$<?= $cart_subtotal ?></td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td><strong>$<?= $fixed_shipping ?></strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td><strong>$<?= $cart_subtotal + $fixed_shipping ?></strong></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="payment_method">
                                <div class="panel-default">
                                    <input id="payment" name="payment_method" value="Cash On Delivery" type="radio" checked />
                                    <label for="payment">COD (Cash On Delivery)</label>
                                </div>
                                <div class="order_button">
                                    <button type="submit">Proceed to buy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Checkout page section end-->

<?php loadPartial("footer"); ?>