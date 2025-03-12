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
                <h1 class="h3">Admin Dashboard</h1>
                <div>
                    <span class="badge bg-primary">Admin: <?= $currentAdmin['name'] ?? 'Admin' ?></span>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Users</h5>
                                <h2 class="display-4"><?= $totalUsers ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <div class="card-footer bg-primary border-top border-light border-opacity-25">
                            <a href="/admin/users" class="text-white text-decoration-none">View All Users <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Products</h5>
                                <h2 class="display-4"><?= $totalProducts ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-box-open fa-3x"></i>
                        </div>
                        <div class="card-footer bg-success border-top border-light border-opacity-25">
                            <a href="/admin/products" class="text-white text-decoration-none">View All Products <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Orders</h5>
                                <h2 class="display-4"><?= $totalOrders ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-shopping-cart fa-3x"></i>
                        </div>
                        <div class="card-footer bg-info border-top border-light border-opacity-25">
                            <a href="/admin/orders" class="text-white text-decoration-none">View All Orders <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentOrders)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td>#<?= $order->order_id ?></td>
                                            <td><?= $order->user_name ?></td>
                                            <td><?= $order->created_at ?></td>
                                            <td>
                                                <a href="/admin/orders/<?= $order->order_id ?>" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="/admin/orders" class="btn btn-outline-primary">View All Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>