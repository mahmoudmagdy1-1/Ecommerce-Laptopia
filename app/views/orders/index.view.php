<?php
loadPartial("head");
loadPartial("navbar");
?>

<div class="container order-container py-5">

    <?php
    loadPartial("errors");
    ?>
    <div class="card order-card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">All Orders</h2>
        </div>
    </div>

    <?php ?>
    <div class="card order-card mb-4">
        <div class="card-header">
            <h5 class="section-header mb-0">Order History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Shipping Status</th>
                        <th>Payment Status</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (empty($orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No orders found.</td>
                        </tr>
                    <?php else:
                        foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo $order['date']; ?></td>
                                <td>
                                        <span class="badge <?php
                                        $status = $order['shipping_status'];
                                        if ($status === 'Delivered') {
                                            echo 'bg-success';
                                        } elseif ($status === 'Shipped') {
                                            echo 'bg-primary';
                                        } elseif ($status === 'Pending') {
                                            echo 'bg-info';
                                        } else {
                                            echo 'bg-secondary';
                                        }
                                        ?>"><?php echo $status; ?>
                                        </span>
                                </td>
                                <td>
                                        <span class="badge <?php
                                        $paymentStatus = $order['payment_status'];
                                        if ($paymentStatus === 'Success') {
                                            echo 'bg-success';
                                        } elseif ($paymentStatus === 'Failed') {
                                            echo 'bg-danger';
                                        } elseif ($paymentStatus === 'Pending') {
                                            echo 'bg-info';
                                        } else {
                                            echo 'bg-warning';
                                        }
                                        ?>"><?php echo $paymentStatus; ?>
                                        </span>
                                </td>
                                <td>$<?php echo number_format($order['total'], 2); ?></td>
                                <td>
                                    <a href="/order/<?php echo $order['id']; ?>"
                                       class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="/" class="btn btn-secondary">Back to Home</a>
    </div>
</div>
<?php loadPartial("footer"); ?>