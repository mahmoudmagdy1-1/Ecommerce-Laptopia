<?php
loadPartial("head");
loadPartial("navbar");
?>


<div class="form-wrapper">
    <div class="form-container">
        <h2>Add Product</h2>

        <?php loadPartial("errors"); ?>

        <form action="/product/add" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="The name of the product" >
            </div>
            <div class="form-group">
                <label for="message">Description</label>
                <textarea id="message" name="description" rows="4" placeholder="Description of the product"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" placeholder="Price in $"  step="any">
            </div>
            <div class="form-group">
                <label for="discount">Discount Percentage</label>
                <input type="number" id="discount" name="discount" placeholder="Discount in %" value="0"  step="any">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" placeholder="Quantity of the product" value="1"  step="any">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-select" >
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?=$category->category_id; ?>"><?= $category->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="images">Product Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*" >
            </div>
            <button type="submit" class="form-submit">Add Product</button>
        </form>
    </div>
</div>



<?php loadPartial("footer"); ?>
