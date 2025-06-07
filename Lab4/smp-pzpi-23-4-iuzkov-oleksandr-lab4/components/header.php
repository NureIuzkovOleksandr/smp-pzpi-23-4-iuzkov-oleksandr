<header>
    <nav class="main-nav">
        <div class="nav-item">
            <a href="/">
                <span class="nav-icon">🏡</span><span class="nav-label">Home</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="/products">
                <span class="nav-icon">🛍️</span><span class="nav-label">Products</span>
            </a>
        </div>

        <?php if (isset($_SESSION['username'])) : ?>
            <div class="nav-item">
                <a href="/cart">
                    <span class="nav-icon">🛒</span><span class="nav-label">Cart</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="/myprofile">
                    <span class="nav-icon">🧑</span><span class="nav-label">Profile</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="/logout">
                    <span class="nav-icon">🔓</span><span class="nav-label">Logout</span>
                </a>
            </div>
        <?php else : ?>
            <div class="nav-item">
                <a href="/login">
                    <span class="nav-icon">🔐</span><span class="nav-label">Login</span>
                </a>
            </div>
        <?php endif; ?>

    </nav>
</header>
