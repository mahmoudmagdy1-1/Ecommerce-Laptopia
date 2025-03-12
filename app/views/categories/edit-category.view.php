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
                <h1 class="h3">Edit Category</h1>
                <div>
                    <a href="/admin/categories" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Categories
                    </a>
                </div>
            </div>

            <?php loadPartial('errors'); ?>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <form action="/admin/categories/edit/<?= $category->category_id ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $category->name ?>" required>
                            <div class="form-text">Enter a unique category name.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-light me-md-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>