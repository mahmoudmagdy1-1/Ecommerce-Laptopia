<?php
loadPartial("head");
//inspectAndDie($user);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-2 bg-dark text-white p-3 min-vh-100">
            <?php loadPartial("admin/sidebar"); ?>
        </div>
        <div class="col-12 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">User Details</h1>
                <div>
                    <a href="/admin/users" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Users
                    </a>
                </div>
            </div>

            <?php loadPartial('errors'); ?>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">User Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 text-center">
                                <div class="avatar-placeholder bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    <?= strtoupper(substr($user->name, 0, 1)) ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="<?= $user->name ?>"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= $user->email ?>"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control"
                                    value="<?= $user->phone ?? 'N/A' ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Registered On</label>
                                <input type="text" class="form-control"
                                    value="<?= date('F j, Y, g:i a', strtotime($user->created_at)) ?>"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">User Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-4">
                                    <div class="card bg-light">
                                        <div class="card-body py-3">
                                            <h3 class="display-4 mb-0"><?= count($userOrders) ?></h3>
                                            <p class="text-muted mb-0">Total Orders</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($userOrders)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found for this user.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($userOrders as $order): ?>
                                        <tr>
                                            <td>#<?= $order->order_id ?></td>
                                            <td><?= date('M d, Y', strtotime($order->created_at)) ?></td>
                                            <td>
                                                <a href="/admin/orders/<?= $order->order_id ?>"
                                                    class="btn btn-sm btn-primary">
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