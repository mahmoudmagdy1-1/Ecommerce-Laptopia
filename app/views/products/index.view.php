<?php
loadPartial("head");
loadPartial("navbar");
?>

<section class="pt-60 pb-30 gray-bg">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section-title">
                    <h2>All Products</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <!--                --><?php //= inspect(); ?>
            <!--                --><?php //inspectAndDie($products); ?>
            <?php foreach ($products as $product): ?>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding">
                        <!--                        --><?php //= inspectAndDie($products) ?>
                        <!--                        <form action="/products/-->
                        <?php //= $products->product_id; ?><!--"></form>-->
                        <a href="/product/<?= $product->product_id; ?>">
                            <div class="tranding-pro-img">
                                <img src="/assets/img/product/<?= explode(",", $product->images)[0] ?>"
                                     alt="<?= explode(",", $product->images_alt)[0] ?>">
                            </div>
                            <div class="tranding-pro-title">
                                <h3><?= $product->name; ?></h3>
                                <h4><?= $product->category; ?></h4>
                            </div>
                            <div class="tranding-pro-price">
                                <div class="price_box">
                                    <?php if ($product->discount > 0): ?>
                                        <span class="current_price">$<?= (int)($product->price - ($product->price * ($product->discount / 100))) ?></span>
                                        <span class="old_price">$<?= (int)$product->price ?></span>
                                    <?php else: ?>
                                        <span class="current_price">$<?= (int)$product->price ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <nav aria-label="Page navigation">
    <ul class="pagination pagination-custom justify-content-center">
        <?php
        $start_page = max(1, $id - 2);
        $end_page = min($last_page, $start_page + 4);
        ?>
        <?php if($id > 1): ?>
            <li class="page-item">
                <a class="page-link" href="/products/<?= $id - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        <?php endif; ?>
        <?php for($i = $start_page; $i <= $end_page; $i++): ?>
            <li class="page-item <?= $id == $i ? "active" : "" ?>">
                <a class="page-link" href="/products/<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <?php if($id < $last_page): ?>
            <li class="page-item">
                <a class="page-link" href="/products/<?= $id + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    </nav>
</section>

<?php loadPartial("footer"); ?>
