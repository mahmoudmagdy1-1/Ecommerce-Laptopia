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
                        <li><a href="/">Home</a></li>
                        <li>404</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->


<!--error section area start-->
<div class="error_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="error_form">
                    <img src="/assets/img/404.jpg" alt=""/>
                    <h2>Oops! PAGE NOT BE FOUND</h2>
                    <p>It might have been removed, changed, or is temporarily unavailable.</p>
                    <a href="/">Back to home page</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--error section area end-->

<?php loadPartial("footer"); ?>
