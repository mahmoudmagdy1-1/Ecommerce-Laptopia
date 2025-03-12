<?php
loadPartial("head");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-2 bg-dark text-white p-3 min-vh-100">
            <?php loadPartial("admin/sidebar"); ?>
        </div>
        <div class="col-12 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Order Details #<?= $order->order_id ?></h1>
                <div>
                    <a href="/admin/orders" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>
            </div>

            <?php loadPartial('errors'); ?>
            <?php loadPartial('success'); ?>

            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order Date:</strong> <?= date('F j, Y, g:i a', strtotime($order->created_at)) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?= $user->name ?></p>
                            <p><strong>Email:</strong> <?= $user->email ?></p>
                            <p><strong>Phone:</strong> <?= $user->phone ?? 'N/A' ?></p>
                            <p><strong>Customer Since:</strong> <?= date('F j, Y', strtotime($user->created_at)) ?></p>
                            <a href="/admin/users/<?= $user->user_id ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-user me-1"></i> View Customer Profile
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Shipping Information</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($shipping): ?>
                                <p><strong>Address:</strong> <?= $shipping->address ?></p>
                                <p><strong>City:</strong> <?= $shipping->city ?></p>
                                <p>
                                    <strong>Shipping Status:</strong>
                                <form action="/admin/orders/status/<?= $order->order_id ?>" method="POST">
                                    <select name="shipping_status" class="form-select mb-2">
                                        <option value="Pending" <?= $shipping->status === 'Pending' ? 'selected' : '' ?>>
                                            Pending
                                        </option>
                                        <option value="Shipped" <?= $shipping->status === 'Shipped' ? 'selected' : '' ?>>
                                            Shipped
                                        </option>
                                        <option value="Delivered" <?= $shipping->status === 'Delivered' ? 'selected' : '' ?>>
                                            Delivered
                                        </option>
                                        <option value="Returned" <?= $shipping->status === 'Returned' ? 'selected' : '' ?>>
                                            Returned
                                        </option>
                                        <option value="Cancelled" <?= $shipping->status === 'Cancelled' ? 'selected' : '' ?>>
                                            Cancelled
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update Shipping Status</button>
                                </form>
                                </p>
                                <?php if (!empty($shipping->tracking_number)): ?>
                                    <p><strong>Tracking Number:</strong> <?= $shipping->tracking_number ?></p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted">No shipping information available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Payment Information</h5>
                </div>
                <div class="card-body">
                    <?php if ($payment): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Payment Method:</strong> <?= $payment->method ?? 'N/A' ?></p>
                                <?php if (!empty($payment->transaction_id)): ?>
                                    <p><strong>Transaction ID:</strong> <?= $payment->transaction_id ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <strong>Payment Status:</strong>
                                <form action="/admin/orders/status/<?= $order->order_id ?>" method="POST">
                                    <select name="payment_status" class="form-select mb-2">
                                        <option value="Pending" <?= $payment->status === 'Pending' ? 'selected' : '' ?>>
                                            Pending
                                        </option>
                                        <option value="Failed" <?= $payment->status === 'Failed' ? 'selected' : '' ?>>
                                            Failed
                                        </option>
                                        <option value="Success" <?= $payment->status === 'Success' ? 'selected' : '' ?>>
                                            Success
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update Payment Status</button>
                                </form>
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No payment information available.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $subtotal = 0;
                            if (!empty($products)):
                                foreach ($products as $product):
                                    $subtotal += $product['total'];
                                    ?>
                                    <tr>
                                        <td><?= $product['name'] ?></td>
                                        <td>$<?= number_format($product['price'], 2) ?></td>
                                        <td><?= $product['quantity'] ?></td>
                                        <td class="text-end">$<?= number_format($product['total'], 2) ?></td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">No items found for this order.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                <td class="text-end">$<?= number_format(20, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td class="text-end">
                                    <strong>$<?= number_format(($subtotal + 20), 2) ?></strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>