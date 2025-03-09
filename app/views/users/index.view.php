<?php
loadPartial("head");
loadPartial("navbar");
//inspectAndDie($user);
?>


<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li>My Account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
<?php loadPartial('errors'); ?>


<div class="container py-5" style="font-size: 1.25rem; letter-spacing: 0.05em;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">My Account</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Account Information -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h3 class="h5">Account Information</h3>
                            <ul class="list-unstyled">
                                <li><strong>Name:</strong> <?= $user->name ?></li>
                                <li><strong>Email:</strong> <?= $user->email ?></li>
                                <li><strong>Phone:</strong> <?= $user->phone ?></li>
                            </ul>
                        </div>
                        <!-- Order History -->
                        <div class="col-md-6">
                            <h3 class="h5">Order History</h3>
                            <?php if (!empty($orders)) : ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($orders as $order) : ?>
                                            <tr>
                                                <td><?= $order->id ?></td>
                                                <td><?= date('Y-m-d', strtotime($order->created_at)) ?></td>
                                                <td><?= $order->status ?></td>
                                                <td>$<?= number_format($order->total, 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <p>You have not placed any orders yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<div class="container">-->
<!--    <h1>My Account</h1>-->
<!--    <div class="row">-->
<!--        <div class="col-md-6">-->
<!--            <h2>Account Information</h2>-->
<!--                <p>Name: --><?php //= $user->name ?><!--</p>-->
<!--                <p>Email: --><?php //= $user->email ?><!--</p>-->
<!--                <p>Phone: --><?php //= $user->phone ?><!--</p>-->
<!--        </div>-->
<!--        <div class="col-md-6">-->
<!--            <h2>Order History</h2>-->
<!--            <ul>-->
<!---->
<!--                --><?php //if (isset($orders)): ?>
<!--                    --><?php //foreach ($orders as $order): ?>
<!--                        <li>-->
<!--                            <p>Order #--><?php //= $order->id ?><!--</p>-->
<!--                            <p>Date: --><?php //= $order->created_at ?><!--</p>-->
<!--                            <p>Total: --><?php //= $order->total ?><!--</p>-->
<!--                            <p>Status: --><?php //= $order->status ?><!--</p>-->
<!--                        </li>-->
<!--                    --><?php //endforeach; ?>
<!--                --><?php //endif; ?>
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="row">-->
<!--        <div class="col-md-12">-->
<!--            <h2>Wishlist</h2>-->
<!--            <ul>-->
<!--                --><?php //if (isset($wishlist)): ?>
<!--                    --><?php //foreach ($wishlist as $product): ?>
<!--                        <li>-->
<!--                            <p>Product: --><?php //= $product->name ?><!--</p>-->
<!--                            <p>Price: --><?php //= $product->price ?><!--</p>-->
<!--                        </li>-->
<!--                    --><?php //endforeach; ?>
<!--                --><?php //endif; ?>
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php loadPartial("footer"); ?>
