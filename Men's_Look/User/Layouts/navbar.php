<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Men's Look - Modern E-commerce</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    :root {
      --color-primary: #28a745;
      --color-danger: #dc3545;
      --color-dark: #1f2121;
      --color-light: #f8f9fa;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--color-light);
    }

    /* 🔹 Top Bar */
    .topbar {
      background: var(--color-dark);
      color: white;
      font-size: 14px;
      padding: 8px 0;
    }

    .topbar a {
      color: white;
      text-decoration: none;
      margin-left: 18px;
      font-weight: 500;
      letter-spacing: 0.5px;
    }

    /* 🔹 Navbar */
    .main-navbar {
      background: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      padding: 14px 0;
      z-index: 1000;
    }

    .navbar-brand {
      font-size: 26px;
      font-weight: 700;
      color: var(--color-dark);
      text-decoration: none;
    }

    .navbar-brand span {
      color: var(--color-primary);
    }

    .nav-menu {
      display: flex;
      align-items: center;
      gap: 30px;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .nav-menu li a {
      color: var(--color-dark);
      text-decoration: none;
      font-weight: 500;
      position: relative;
      transition: color 0.2s;
    }

    .nav-menu li a:hover,
    .nav-menu li a.active {
      color: var(--color-primary);
    }

    .nav-menu li a.active::after {
      content: "";
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--color-primary);
      border-radius: 2px;
    }

    /* 🔹 Dropdown menu */
    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .dropdown-menu a {
      font-weight: 500;
    }

    /* 🔹 Actions */
    .navbar-actions {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .icon-btn {
      background: transparent;
      border: none;
      font-size: 18px;
      color: var(--color-dark);
      position: relative;
      cursor: pointer;
      transition: color 0.2s;
    }

    .icon-btn:hover {
      color: var(--color-primary);
    }

    .cart-badge {
      position: absolute;
      top: -6px;
      right: -8px;
      background: var(--color-danger);
      color: white;
      font-size: 11px;
      padding: 2px 5px;
      border-radius: 10px;
    }

    .user-avatar {
      width: 38px;
      height: 38px;
      background: var(--color-primary);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }

    /* 🔹 Mobile menu */
    @media (max-width: 991px) {
      .nav-menu {
        display: none;
        flex-direction: column;
        background: white;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }

      .nav-menu.active {
        display: flex;
      }

      .mobile-toggle {
        display: block;
        border: none;
        background: transparent;
        font-size: 24px;
      }
    }

    .mobile-toggle {
      display: none;
    }

    /* 🔹 Popup Overlay */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .popup-box {
      background: white;
      border-radius: 16px;
      padding: 28px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
      from {
        transform: translateY(30px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
  </style>
</head>

<body>

  <!-- 🔸 Top Bar -->
  <div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
      <span>Free shipping, 30-day return or refund guarantee.</span>
      <div>
        <a href="#">SIGN IN</a>
        <a href="#">FAQS</a>
        <a href="#">USD <i class="fa-solid fa-chevron-down small"></i></a>
      </div>
    </div>
  </div>

  <!-- 🔸 Navbar -->
  <nav class="main-navbar">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="home.php" class="navbar-brand">Men’s <span>Look</span></a>

      <ul class="nav-menu" id="navMenu">
        <li><a href="home.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>

        <!-- Dropdown Pages -->
        <li class="nav-item dropdown">
          <a href="#" class="dropdown-toggle text-dark" data-bs-toggle="dropdown" id="pagesDropdown">Pages</a>
          <ul class="dropdown-menu shadow-sm border-0 rounded-3">
            <li><a class="dropdown-item" href="about.php">About Us</a></li>
            <li><a class="dropdown-item" href="order_list.php">Orders</a></li>
            <!-- <li><a class="dropdown-item" href="faq.php">FAQs</a></li>
            <li><a class="dropdown-item" href="returns.php">Return Policy</a></li>
            <li><a class="dropdown-item" href="terms.php">Terms & Conditions</a></li> -->
          </ul>
        </li>

        <li><a href="blog.php">Blog</a></li>
        <li><a href="contact.php">Contacts</a></li>
      </ul>

      <div class="navbar-actions">
        <button class="icon-btn" onclick="openPopup('searchPopup')"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button class="icon-btn" onclick="openCartPopup()">
          <i class="fa-solid fa-cart-shopping"></i>
          <span class="cart-badge" id="cartCount">0</span>
        </button>

        <!-- Authenticated User -->
        <div class="dropdown AuthenticateUser">
          <button class="btn border-0 bg-transparent" data-bs-toggle="dropdown">
            <div class="user-avatar" id="userAvatar"></div>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user me-2 text-success"></i> Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" id="logoutBtn"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
          </ul>
        </div>

        <!-- Guest User -->
        <a href="login.php" class="btn btn-outline-success btn-sm guestUser">Login</a>
        <a href="register.php" class="btn btn-success btn-sm guestUser">Register</a>

        <button class="mobile-toggle d-lg-none" onclick="toggleMobileMenu()">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- 🔹 Search Popup -->
  <div id="searchPopup" class="popup-overlay" onclick="closePopupOnOverlay(event, 'searchPopup')">
    <div class="popup-box">
      <h5><i class="fa-solid fa-search text-success me-2"></i> Search Products</h5>
      <div class="input-group mt-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Type product name..." />
        <button class="btn btn-success" onclick="searchProducts()">Search</button>
      </div>
      <button class="btn btn-outline-secondary w-100 mt-3" onclick="closePopup('searchPopup')">Close</button>
    </div>
  </div>

  <!-- 🔹 Cart Popup -->
  <div id="cartPopup" class="popup-overlay" onclick="closePopupOnOverlay(event, 'cartPopup')">
    <div class="popup-box">
      <h5><i class="fa-solid fa-cart-shopping text-success me-2"></i> Your Cart</h5>
      <div id="cartItems" class="mt-3 text-muted text-center">Loading...</div>
      <div class="d-flex justify-content-end gap-2 mt-3">
        <button class="btn btn-success btn-sm" onclick="goToCartPage()">Go to Cart</button>
        <button class="btn btn-outline-danger btn-sm" onclick="closePopup('cartPopup')">Close</button>
      </div>
    </div>
  </div>

  <!-- ✅ JS -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function () {
      checkLoginStatus();
      updateCartCount(); // ✅ Load cart count on page load
      setInterval(updateCartCount, 20000); // 🔁 Auto-refresh every 20 sec

      $("#logoutBtn").on("click", function (e) {
        e.preventDefault();
        logoutUser();
      });
    });

    // ✅ Check login
    function checkLoginStatus() {
      const userId = localStorage.getItem("UserId");
      const userName = localStorage.getItem("CustomerName");

      if (userId && userName) {
        $(".guestUser").hide();
        $(".AuthenticateUser").show();
        $("#userAvatar").text(userName.trim().charAt(0).toUpperCase());
      } else {
        $(".AuthenticateUser").hide();
        $(".guestUser").show();
      }
    }

    // ✅ Logout
    function logoutUser() {
      if (!confirm("Are you sure you want to logout?")) return;

      $.ajax({
        url: "../Controllers/LogoutController.php",
        method: "POST",
        data: { UserId: localStorage.getItem("UserId") },
        success: function () {
          localStorage.clear();
          $("#cartCount").text("0");
          window.location.href = "home.php";
        },
        error: function () {
          localStorage.clear();
          $("#cartCount").text("0");
          window.location.href = "home.php";
        }
      });
    }

    // ✅ Popup
    function openPopup(id) { $("#" + id).fadeIn(200); }
    function closePopup(id) { $("#" + id).fadeOut(200); }
    function closePopupOnOverlay(e, id) { if (e.target.classList.contains("popup-overlay")) closePopup(id); }
    function toggleMobileMenu() { $("#navMenu").toggleClass("active"); }

    // ✅ Search
    function searchProducts() {
      const keyword = $("#searchInput").val().trim();
      if (keyword) window.location.href = "shop.php?search=" + encodeURIComponent(keyword);
    }

    // ✅ Cart Popup
    function openCartPopup() {
      openPopup("cartPopup");
      loadCartItems();
    }

    // ✅ Load Cart Items
    function loadCartItems() {
      const userId = localStorage.getItem("UserId");
      if (!userId) {
        $("#cartItems").html("<p class='text-muted'>Please login to view your cart.</p>");
        return;
      }

      $.ajax({
        url: "../Controllers/CartController.php",
        method: "GET",
        data: { UserId: userId },
        success: function (res) {
          res = JSON.parse(res);
          if (res.Status === "Ok" && res.Result.length > 0) {
            let html = "";
            res.Result.forEach((item) => {
              html += `<div class='d-flex justify-content-between align-items-center border-bottom py-2'>
                        <div><strong>${item.product_name}</strong><br><small>Qty: ${item.quantity}</small></div>
                        <span class='text-success fw-bold'>₹${item.price}</span>
                      </div>`;
            });
            $("#cartItems").html(html);
            $("#cartCount").text(res.Result.length);
          } else {
            $("#cartItems").html("<p class='text-muted'>Your cart is empty.</p>");
            $("#cartCount").text("0");
          }
        },
        error: function () {
          $("#cartItems").html("<p class='text-danger'>Failed to load cart items.</p>");
        }
      });
    }

    // ✅ Auto update cart count in navbar
    function updateCartCount() {
      const userId = localStorage.getItem("UserId");
      if (!userId) {
        $("#cartCount").text("0");
        return;
      }

      $.ajax({
        url: "../Controllers/CartController.php",
        method: "GET",
        data: { UserId: userId },
        success: function (res) {
          try {
            res = JSON.parse(res);
            if (res.Status === "Ok" && res.Result.length > 0) {
              $("#cartCount").text(res.Result.length);
            } else {
              $("#cartCount").text("0");
            }
          } catch {
            $("#cartCount").text("0");
          }
        },
        error: function () {
          $("#cartCount").text("0");
        }
      });
    }

    // ✅ Go to Cart
    function goToCartPage() {
      if (!localStorage.getItem("UserId")) {
        alert("Please login to access your cart!");
        window.location.href = "login.php";
      } else {
        window.location.href = "cart.php";
      }
    }

    // ✅ Auto highlight current page link
    document.addEventListener("DOMContentLoaded", function () {
      const currentPage = window.location.pathname.split("/").pop();
      const navLinks = document.querySelectorAll(".nav-menu li a, .dropdown-menu a");
      const pagesDropdown = document.getElementById("pagesDropdown");

      let isPageChildActive = false;

      navLinks.forEach(link => {
        const linkPage = link.getAttribute("href");
        if (linkPage === currentPage) {
          link.classList.add("active");

          // If this link is inside dropdown -> highlight the "Pages" parent too
          if (link.closest(".dropdown-menu")) {
            pagesDropdown.classList.add("active");
            isPageChildActive = true;
          }
        }
      });
    });
  </script>
</body>

</html>
