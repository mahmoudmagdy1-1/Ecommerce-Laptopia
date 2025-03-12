<?php
loadPartial("head");
loadPartial("navbar");
?>


    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>My Account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->


    <div class="container py-5" style="font-size: 1.25rem; letter-spacing: 0.05em;">
        <?php loadPartial('errors'); ?>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h4 mb-0">My Account</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Account Information -->
                            <div class="col-md-6 mb-4 mb-md-0">
                                <h3 class="h5">Account Information</h3>
                                <ul class="list-unstyled">
                                    <li><strong>Name:</strong> <?= $user->name ?></li>
                                    <li><strong>Email:</strong> <?= $user->email ?></li>
                                    <li><strong>Phone:</strong> <?= $user->phone ?></li>
                                </ul>
                            </div>
                            <!-- Order History -->
                            <div class="col-md-6">
                                <h3 class="h5">
                                    <a href="/orders" class="text-primary d-flex align-items-center"
                                       style="text-decoration: underline; transition: all 0.3s ease;">
                                        <!-- <i class="fas fa-history me-2"></i>  -->
                                        <p>Order History <i class="fas fa-external-link-alt ms-2"
                                                            style="font-size: 0.8em;"></i>
                                        </p>
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php loadPartial("footer"); ?>