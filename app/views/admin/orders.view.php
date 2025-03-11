<?php
loadPartial("head");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-2 bg-dark text-white p-3 min-vh-100">
            <!-- Admin Sidebar -->
            <?php loadPartial("admin/sidebar"); ?>
        </div>
        <div class="col-12 col-lg-10 p-4">
            <!-- Admin Content -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Order Management</h1>
            </div>

            <?php loadPartial('errors'); ?>

            <!-- Orders Table -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">All Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($orders)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No orders found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?= $order->order_id ?></td>
                                            <td><?= $order->user_name ?></td>
                                            <td><?= $order->user_email ?></td>
                                            <td><?= date('M d, Y', strtotime($order->created_at)) ?></td>
                                            <td>
                                                <a href="/admin/orders/<?= $order->order_id ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
