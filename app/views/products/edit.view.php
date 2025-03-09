<?php
loadPartial("head");
loadPartial("navbar");
//inspectAndDie($product_id);
?>


<div class="form-wrapper">
    <div class="form-container">
        <h2>Edit Product</h2>
        <?php loadPartial('errors'); ?>
        <form action="/product/edit/<?= $product_id ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="The name of the product" value="<?= $product->name ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Description</label>
                <textarea id="message" name="description" rows="4" placeholder="Description of the product" required><?= $product->description ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" placeholder="Price in $" value="<?= $product->price ?>" required step="any">
            </div>
            <div class="form-group">
                <label for="discount">Discount Percentage</label>
                <input type="number" id="discount" name="discount" placeholder="Discount in %" value="<?= $product->discount ?>" required step="any"    >
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" placeholder="Quantity of the product" value="<?= $product->quantity ?>" required step="any">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-select" required>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?=$category->category_id; ?>" <?= $category->name == $product->category ? "selected" : "" ?>><?= $category->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="images">Product Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
            </div>
            <button type="submit" class="form-submit">Edit Product</button>
        </form>
    </div>
</div>



<?php loadPartial("footer"); ?>
