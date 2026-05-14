<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 🌄 Hero / Breadcrumb -->
<section class="shop-hero text-white d-flex align-items-center"
  style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)),
          url('img/about/about-us.jpg') center/cover no-repeat; height:250px;">
  <div class="container text-center">
    <h1 class="fw-bold mb-2">Our Shop</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="home.php" class="text-white text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active text-light" aria-current="page">Shop</li>
      </ol>
    </nav>
  </div>
</section>

<!-- MAIN -->
<div class="content" id="content">
  <div class="container-fluid py-5">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
      <h3 class="fw-bold mb-3 mb-md-0">
        <i class="fa-solid fa-store me-2 text-primary"></i>Shop Products
      </h3>

      <div class="d-flex gap-2 flex-wrap">
        <input type="text" id="searchBox" class="form-control form-control-sm" placeholder="Search..." style="max-width:200px;">
        <select id="sortBy" class="form-select form-select-sm" style="max-width:160px;">
          <option value="">Sort By</option>
          <option value="low">Price: Low → High</option>
          <option value="high">Price: High → Low</option>
          <option value="az">Name: A–Z</option>
        </select>
        <button class="btn btn-primary btn-sm" onclick="applyFilters()"><i class="fa-solid fa-filter"></i></button>
      </div>
    </div>

    <div class="row">

      <!-- FILTER SIDEBAR -->
      <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body small">

            <h5 class="fw-bold mb-3"><i class="fa-solid fa-sliders me-2 text-primary"></i>Filters</h5>

            <!-- Category -->
            <div class="mb-3">
              <h6 class="text-secondary mb-2"><i class="fa-solid fa-list-ul me-1 text-primary"></i>Category</h6>
              <div id="categoryList" class="d-flex flex-wrap gap-2"></div>
            </div>

            <!-- Brand -->
            <div class="mb-3">
              <h6 class="text-secondary mb-2"><i class="fa-solid fa-tags me-1 text-primary"></i>Brand</h6>
              <select id="brandFilter" class="form-select form-select-sm">
                <option value="">All Brands</option>
              </select>
            </div>

            <!-- Price Filter -->
            <div class="mb-3">
              <h6 class="text-secondary mb-2"><i class="fa-solid fa-indian-rupee-sign me-1 text-primary"></i>Price</h6>
              <div class="d-flex gap-2">
                <input type="number" id="minPrice" class="form-control form-control-sm" placeholder="Min">
                <input type="number" id="maxPrice" class="form-control form-control-sm" placeholder="Max">
              </div>
            </div>

            <!-- Availability -->
            <div class="mb-3">
              <h6 class="text-secondary mb-2"><i class="fa-solid fa-box me-1 text-primary"></i>Status</h6>
              <select id="statusFilter" class="form-select form-select-sm">
                <option value="">All</option>
                <option value="Available">Available</option>
                <option value="Out of Stock">Out of Stock</option>
              </select>
            </div>

            <div class="d-grid gap-2 mt-3">
              <button class="btn btn-primary btn-sm" onclick="applyFilters()"><i class="fa-solid fa-check"></i> Apply</button>
              <button class="btn btn-outline-secondary btn-sm" onclick="resetFilters()"><i class="fa-solid fa-rotate-left"></i> Reset</button>
            </div>

          </div>
        </div>
      </div>

      <!-- PRODUCT GRID -->
      <div class="col-lg-9">
        <div id="productGrid" class="row g-4"></div>
      </div>

    </div>
  </div>
</div>

<?php include "Layouts/_Footer.php"; ?>

<!-- ========================= -->
<!--     SHOP PAGE JS          -->
<!-- ========================= -->
<script>
let allProducts = [];
let activeCategory = null;

$(document).ready(() => {
  loadCategories();
  loadProducts();
});

/* CATEGORY LOAD */
function loadCategories() {
  $.ajax({
    url: "../Controllers/CategorieController.php",
    method: "GET",
    success: function (res) {
      res = JSON.parse(res);
      $("#categoryList").html(`
        <button class="btn btn-outline-primary active" id="cat_all" onclick="selectCategory(null)">All</button>
      `);

      res.Result.forEach(cat => {
        $("#categoryList").append(`
          <button class="btn btn-outline-primary" 
            id="cat_${cat.Categorieid}" 
            onclick="selectCategory(${cat.Categorieid})">${cat.category_name}</button>
        `);
      });
    }
  });
}

/* LOAD PRODUCTS */
function loadProducts() {
  $("#productGrid").html(`<div class="text-center p-5"><div class="spinner-border text-primary"></div></div>`);

  $.ajax({
    url: "../Controllers/ProductController.php",
    method: "GET",
    success: function (res) {
      res = JSON.parse(res);
      allProducts = res.Result;
      displayProducts(allProducts);
    }
  });
}

/* SELECT CATEGORY */
function selectCategory(id) {
  $("#categoryList .btn").removeClass("active");
  $(`#cat_${id || 'all'}`).addClass("active");
  activeCategory = id;
  applyFilters();
}

/* FILTER PRODUCTS */
function applyFilters() {
  let data = [...allProducts];
  const key = $("#searchBox").val().toLowerCase();
  const brand = $("#brandFilter").val();
  const status = $("#statusFilter").val();
  const min = $("#minPrice").val() || 0;
  const max = $("#maxPrice").val() || 999999;

  if (activeCategory) data = data.filter(p => p.category_id == activeCategory);
  if (key) data = data.filter(p => p.product_name.toLowerCase().includes(key));
  if (brand) data = data.filter(p => p.brand == brand);
  if (status) data = data.filter(p => p.status == status);
  data = data.filter(p => p.price >= min && p.price <= max);

  displayProducts(data);
}

function resetFilters() {
  activeCategory = null;
  $("#categoryList .btn").removeClass("active");
  $("#cat_all").addClass("active");
  $("#searchBox,#minPrice,#maxPrice").val("");
  $("#brandFilter,#statusFilter,#sortBy").val("");
  displayProducts(allProducts);
}

/* DISPLAY PRODUCTS */
function displayProducts(list) {
  $("#productGrid").html("");

  if (list.length === 0) {
    $("#productGrid").html(`<div class="text-center text-danger py-5">No Products Found</div>`);
    return;
  }

  list.forEach(p => {
    let img = p.image_url ? `../Content/Photo/${p.image_url}` : `../Content/no-image.png`;
    let price = p.discount_price > 0
      ? `<span class="fw-bold text-danger"><strike>₹${p.price}</strike> ₹${p.discount_price}</span>`
      : `<span class="fw-bold text-dark">₹${p.price}</span>`;

    $("#productGrid").append(`
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm rounded-4 product-card">
          <img src="${img}" class="card-img-top" style="height:250px;object-fit:cover;">
          <div class="card-body text-center">
            <h6 class="fw-bold">${p.product_name}</h6>
            <p class="text-muted small">${p.brand || ''}</p>
            <p>${price}</p>

            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-outline-primary btn-sm" onclick="viewDetails(${p.product_id})">
                <i class="fa-solid fa-eye"></i>
              </button>

              <button class="btn btn-success btn-sm" onclick="addToCart(${p.product_id}, '${p.product_name}')">
                <i class="fa-solid fa-cart-plus"></i>
              </button>
            </div>

          </div>
        </div>
      </div>
    `);
  });
}

/* VIEW DETAILS */
function viewDetails(id) {
  window.location.href = `product_details.php?id=${id}`;
}

/* SWEET ALERT ADD TO CART */
function addToCart(id, name) {

  const userId = localStorage.getItem("UserId");

  if (!userId) {
    Swal.fire({
      icon: "warning",
      title: "Login Required",
      text: "Please login before adding products to cart",
      confirmButtonColor: "#0d6efd"
    });
    return;
  }

  $.ajax({
    url: "../Controllers/CartController.php",
    method: "POST",
    data: { product_id: id, quantity: 1, UserId: userId },

    success: function () {

      Swal.fire({
        icon: "success",
        title: "Added to Cart!",
        html: `<b>${name}</b><br>Added successfully.`,
        confirmButtonColor: "#28a745",
        confirmButtonText: "Continue",
        showCancelButton: true,
        cancelButtonText: "Go to Cart",
        cancelButtonColor: "#0d6efd"
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.cancel) {
          window.location.href = "cart.php";
        }
      });

      updateCartCount();
    },

    error: function () {
      Swal.fire("Error", "Unable to add item.", "error");
    }
  });
}

/* UPDATE CART COUNT */
function updateCartCount() {
  const userId = localStorage.getItem("UserId");

  $.ajax({
    url: "../Controllers/CartController.php",
    method: "GET",
    data: { Choice: "GetCartCount", user_id: userId },
    success: function (res) {
      try {
        res = JSON.parse(res);
        if (res.Status === "OK") $("#cartCount").text(res.Result);
      } catch {}
    }
  });
}
</script>

<style>
.product-card { transition: .3s; }
.product-card:hover {
  transform: translateY(-6px);
  box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

#categoryList .btn { border-radius:20px; font-size:12px; }
#categoryList .btn.active { background:#0d6efd; color:#fff; }
</style>

