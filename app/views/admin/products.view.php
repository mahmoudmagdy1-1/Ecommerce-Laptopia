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
                <h1 class="h3">Product Management</h1>
                <div>
                    <a href="/product/add" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i> Add New Product
                    </a>
                </div>
            </div>

            <?php loadPartial('errors'); ?>

            <!-- Filter Options -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="productSearch" class="form-control"
                                       placeholder="Search products...">
                                <button class="btn btn-outline-secondary" type="button" id="searchButton"
                                        aria-label="Search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="categoryFilter" class="form-select">
                                <option value="">All Categories</option>
                                <?php if (isset($categories) && is_array($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->name ?>">
                                            <?= $category->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="stockFilter" class="form-select">
                                <option value="">All Stock Levels</option>
                                <option value="low">Low Stock (≤ 10)</option>
                                <option value="out">Out of Stock</option>
                                <option value="in">In Stock (> 10)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="resetFilters" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">All Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!isset($products) || !is_array($products) || empty($products)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No products found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>#<?= $product->product_id ?></td>
                                        <td>
                                            <?php if (!empty($product->image)): ?>
                                                <img src="/assets/img/product/<?= $product->image ?>"
                                                     alt="<?= $product->name ?>" width="50" height="50"
                                                     class="img-thumbnail">
                                            <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $product->name ?></td>
                                        <td><?= $product->category ?? 'Uncategorized' ?></td>
                                        <td>$<?= number_format($product->price, 2) ?></td>
                                        <td>
                                            <?php if ($product->discount > 0): ?>
                                                <span class="badge bg-success"><?= $product->discount ?>%</span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($product->quantity <= 0): ?>
                                                <span class="badge bg-danger">Out of Stock</span>
                                            <?php elseif ($product->quantity <= 10): ?>
                                                <span class="badge bg-warning"><?= $product->quantity ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?= $product->quantity ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="/product/<?= $product->product_id ?>" class="btn btn-sm btn-info"
                                               target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="/product/edit/<?= $product->product_id ?>"
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
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
    // Client-side filtering functionality
    document.addEventListener('DOMContentLoaded', function () {
        const productSearch = document.getElementById('productSearch');
        const categoryFilter = document.getElementById('categoryFilter');
        const stockFilter = document.getElementById('stockFilter');
        const resetFilters = document.getElementById('resetFilters');
        const searchButton = document.getElementById('searchButton');
        const tableRows = document.querySelectorAll('tbody tr');

        function applyFilters() {
            const searchValue = productSearch.value.toLowerCase();
            const categoryValue = categoryFilter.value.toLowerCase();
            const stockValue = stockFilter.value;

            tableRows.forEach(row => {
                const productName = row.children[2].textContent.toLowerCase();
                const category = row.children[3].textContent.toLowerCase();
                const stockBadge = row.children[6].querySelector('.badge');
                const stockText = stockBadge ? stockBadge.classList.contains('bg-warning') ? 'low' : stockBadge.classList.contains('bg-danger') ? 'out' : 'in' : '';

                let showRow = true;

                // Apply search filter
                if (searchValue && !productName.includes(searchValue)) {
                    showRow = false;
                }

                // Apply category filter
                if (categoryValue && category !== categoryValue) {
                    showRow = false;
                }

                // Apply stock filter
                if (stockValue && stockText !== stockValue) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }

        productSearch.addEventListener('keyup', applyFilters);
        categoryFilter.addEventListener('change', applyFilters);
        stockFilter.addEventListener('change', applyFilters);
        searchButton.addEventListener('click', applyFilters);

        resetFilters.addEventListener('click', function () {
            productSearch.value = '';
            categoryFilter.value = '';
            stockFilter.value = '';

            tableRows.forEach(row => {
                row.style.display = '';
            });
        });
    });
</script>