<?php
loadPartial("head");
loadPartial("navbar");
?>
    <div class="container order-container py-5">
        <div class="card order-card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Order #<?php echo $orderID; ?></h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="section-header">Order Summary</h5>
                        <p><strong>Date:</strong> <?php echo $orderDate; ?></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p><?php echo $currentUser['name']; ?></p>
                        <p><?php echo $currentUser['email']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card order-card mb-4">
            <div class="card-header">
                <h5 class="section-header mb-0">Items Ordered</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $subtotal = 0;
                        foreach ($products as $product):
                            $subtotal += $product['total'];
                            ?>
                            <tr>
                                <td><?php echo $product['name']; ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td>$<?php echo number_format($product['total'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card order-card mb-4">
                    <div class="card-header">
                        <h5 class="section-header mb-0">Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <?php echo $shipping->address ?? 'No address provided'; ?><br>
                            <?php echo $shipping->city ?? ''; ?>,
                            <?php echo $shipping->state ?? ''; ?>
                        </p>
                        <p><strong>Status:</strong> <span class="badge <?php
                            $status = $shipping->status ?? 'Processing';
                            if ($status === 'Delivered') {
                                echo 'bg-success';
                            } elseif ($status === 'Shipped') {
                                echo 'bg-primary';
                            } elseif ($status === 'Pending') {
                                echo 'bg-info';
                            } else {
                                echo 'bg-secondary';
                            }
                            ?>"><?php echo $status; ?></span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card order-card mb-4">
                    <div class="card-header">
                        <h5 class="section-header mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Method:</strong> <?php echo $payment->method ?? 'Not specified'; ?></p>
                        <p><strong>Status:</strong> <span
                                    class="badge <?php
                                    $paymentStatus = $payment->status ?? 'Pending';
                                    if ($paymentStatus === 'Success') {
                                        echo 'bg-success';
                                    } elseif ($paymentStatus === 'Failed') {
                                        echo 'bg-danger';
                                    } elseif ($paymentStatus === 'Pending') {
                                        echo 'bg-info';
                                    } else {
                                        echo 'bg-warning';
                                    }
                                    ?>"><?php echo $paymentStatus; ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card order-card">
            <div class="card-body text-end">
                <h5 class="section-header">Order Total</h5>
                <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
                <p><strong>Shipping:</strong> $<?php echo number_format($shippingCost, 2); ?></p>
                <p><strong>Total:</strong> <span
                            class="fs-4">$<?php echo number_format($subtotal + $shippingCost, 2); ?></span></p>
            </div>
        </div>

        <div class="mt-4">
            <a href="/orders" class="btn btn-secondary">Back to Orders</a>
        </div>
    </div>

<?php loadPartial("footer"); ?>