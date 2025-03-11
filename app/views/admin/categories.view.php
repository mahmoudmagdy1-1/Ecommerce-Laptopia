<?php
loadPartial("head");
?>

<div class="container-fluid">
    <?php
    loadPartial('errors');
    loadPartial('success');
    ?>
    <div class="row">
        <div class="col-12 col-lg-2 bg-dark text-white p-3 min-vh-100">
            <!-- Admin Sidebar -->
            <?php loadPartial("admin/sidebar"); ?>
        </div>
        <div class="col-12 col-lg-10 p-4">
            <!-- Admin Content -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Category Management</h1>
                <div>
                    <a href="/admin/categories/add" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i> Add New Category
                    </a>
                </div>
            </div>

            <?php loadPartial('errors'); ?>

            <!-- Categories Table -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Categories</h5>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" id="categorySearch" class="form-control" placeholder="Search categories...">
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
                                <th>Products</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($categories)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No categories found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td>#<?= $category->category_id ?></td>
                                        <td><?= $category->name ?></td>
                                        <td>
                                            <?php
                                            // This would need to be implemented in the controller
                                            $productCount = 0; // Placeholder
                                            ?>
                                            <span class="badge bg-info"><?= $productCount ?></span>
                                        </td>
                                        <td>
                                            <a href="/admin/categories/edit/<?= $category->category_id ?>"
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <!--                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-->
                                            <?php //= $category->category_id ?><!--">-->
                                            <!--                                                    <i class="fas fa-trash"></i> Delete-->
                                            <!--                                                </button>-->
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
    document.getElementById('categorySearch').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const categoryName = row.children[1].textContent.toLowerCase();

            if (categoryName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>