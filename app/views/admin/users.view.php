<?php
loadPartial("head");
?>

<div class="container-fluid">
    <?php loadPartial('errors'); ?>
    <?php loadPartial('success'); ?>
    <div class="row">
        <div class="col-12 col-lg-2 bg-dark text-white p-3 min-vh-100">
            <!-- Admin Sidebar -->
            <?php loadPartial("admin/sidebar"); ?>
        </div>
        <div class="col-12 col-lg-10 p-4">
            <!-- Admin Content -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">User Management</h1>
            </div>

            <?php loadPartial('errors'); ?>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Users</h5>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No users found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>#<?= $user->user_id ?></td>
                                            <td><?= $user->name ?></td>
                                            <td><?= $user->email ?></td>
                                            <td><?= $user->phone ?? 'N/A' ?></td>
                                            <td><?= date('M d, Y', strtotime($user->created_at)) ?></td>
                                            <td>
                                                <a href="/admin/users/<?= $user->user_id ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
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

<script>
    // Simple client-side search functionality
    document.getElementById('userSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>