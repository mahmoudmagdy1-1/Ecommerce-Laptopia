<div class="admin-sidebar">
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-user-shield fa-2x me-2 mr-3"></i>
        <h4 class="mb-0">Admin Panel</h4>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="/admin/dashboard" class="nav-link text-white d-flex align-items-center">
                <p>
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="/admin/users" class="nav-link text-white d-flex align-items-center">
                <p>
                    <i class="fas fa-users me-2"></i>
                    Users
                </p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="/admin/products" class="nav-link text-white d-flex align-items-center">
                <p>
                    <i class="fas fa-box-open me-2"></i>
                    Products
                </p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="/admin/categories" class="nav-link text-white d-flex align-items-center">
                <p>
                    <i class="fas fa-tags me-2"></i>
                    Categories
                </p>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="/admin/orders" class="nav-link text-white d-flex align-items-center">
                <p>
                    <i class="fas fa-shopping-cart me-2"></i>
                    Orders
                </p>
            </a>
        </li>
        <li class="nav-item mt-4">
            <form action="/logout" method="POST">
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                    <p>
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Logout
                    </p>
                </button>
            </form>
        </li>
    </ul>
</div>