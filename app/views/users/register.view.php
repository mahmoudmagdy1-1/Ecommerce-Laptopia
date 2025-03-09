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
                        <li>Register</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
<?php loadPartial("errors");?>

<section class="account">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="account-contents">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="account-thumb">
                                <h2>Register</h2>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="account-content">
                                <form action="/register" method="post">
                                    <div class="single-acc-field">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" placeholder="Enter Your Name" required>
                                    </div>
                                    <div class="single-acc-field">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" placeholder="Enter your Email" required>
                                    </div>
                                    <div class="single-acc-field">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" name="phone" id="phone" placeholder="Enter your Phone Number" required>
                                    </div>
                                    <div class="single-acc-field">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" placeholder="At least 6 Characters" required>
                                    </div>
                                    <div class="single-acc-field">
                                        <button type="submit">Register now</button>
                                    </div>
                                    <a href="/login">Already have an account? Click here</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php loadPartial("footer"); ?>
