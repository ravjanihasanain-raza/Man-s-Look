<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

<!-- ✅ Stylesheets -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="./css/style.css">

<div class="content" id="content">

  <!-- 🏠 HERO SECTION -->
  <section class="hero">
    <div class="hero__slider owl-carousel">
      <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-7 col-md-8">
              <div class="hero__text">
                <h6>Men’s Look</h6>
                <h2>Fall / Winter Collection 2025</h2>
                <p>Luxury essentials crafted for style and comfort — redefining men’s fashion.</p>
                <a href="shop.php" class="primary-btn">Shop Now <span class="arrow_right"></span></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="hero__items set-bg" data-setbg="img/hero/hero-2.jpg">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-7 col-md-8">
              <div class="hero__text">
                <h6>New Arrivals</h6>
                <h2>Exclusive Men’s Styles</h2>
                <p>Discover the latest trends and timeless designs crafted with precision.</p>
                <a href="shop.php" class="primary-btn">Discover <span class="arrow_right"></span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<section class="py-5 bg-light">
  <div class="container" data-aos="fade-up">
    <!-- 🔹 Title Row -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
      <h2 class="fw-bold mb-3 mb-md-0 text-primary">
        <i class="fa-solid fa-layer-group me-2"></i>Shop by Category
      </h2>
      <div class="d-flex gap-2">
        <input type="text" id="searchCategory" class="form-control form-control-sm" placeholder="Search..." style="max-width:180px;">
        <select id="sortCategory" class="form-select form-select-sm" style="max-width:140px;">
          <option value="asc">A–Z</option>
          <option value="desc">Z–A</option>
        </select>
      </div>
    </div>

    <!-- 🔸 Category Grid -->
    <div id="categoryList" class="row g-3 justify-content-center">
      <!-- Example Static Template (Dynamic via JS) -->
      <!-- 
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="card border-0 shadow-sm category-card">
          <div class="card-body text-center p-3">
            <img src="img/icons/clothing.png" alt="Clothing" class="img-fluid mb-2" style="width:60px;height:60px;object-fit:contain;">
            <h6 class="fw-semibold text-dark mb-0">Clothing</h6>
          </div>
        </div>
      </div>
      -->
    </div>

    <!-- 👇 Show More Button -->
    <div class="text-center mt-4">
      <button id="toggleCategoriesBtn" class="btn btn-outline-primary btn-sm px-4 d-none" onclick="toggleCategories()">
        Show More
      </button>
    </div>
  </div>
</section>

<!-- 🆕 NEW ARRIVALS -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold text-dark"><i class="fa-solid fa-star text-warning me-2"></i>New Arrivals</h2>
      <p class="text-muted mb-0">Check out our latest and trending products!</p>
    </div>

    <!-- 🔹 Product Grid -->
    <div id="latestGrid" class="row g-4 justify-content-center">
      <!-- Example Product Card -->
      <!-- 
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm product-card">
          <img src="img/products/sample.jpg" class="card-img-top rounded-top" alt="">
          <div class="card-body text-center">
            <h6 class="fw-semibold">Stylish Jacket</h6>
            <p class="text-muted small mb-1">Men’s Wear</p>
            <p class="fw-bold text-dark">₹1,299</p>
          </div>
        </div>
      </div>
      -->
    </div>
  </div>
</section>

  <!-- 🌟 FEATURED PRODUCTS -->
  <section class="py-5">
    <div class="container">
      <h2 class="fw-bold text-center mb-5" data-aos="fade-up">Featured Products</h2>
      <div class="swiper featuredSwiper" data-aos="fade-up">
        <div class="swiper-wrapper" id="featuredGrid"></div>
        <div class="swiper-pagination mt-3"></div>
      </div>
    </div>
  </section>



  <!-- 💬 TESTIMONIAL SECTION -->
<section class="py-5 text-center text-white testimonial-section"
  style="background: linear-gradient(120deg, rgba(40,167,69,0.9), rgba(31,139,61,0.9)),
          url('img/bg/testimonial-bg.jpg') center/cover no-repeat;">
  <div class="container" data-aos="fade-up">
    <h2 class="fw-bold mb-4">What Our Customers Say</h2>
    <p class="mb-5 text-light">Real experiences from people who love shopping with us.</p>

    <div class="owl-carousel testimonial-slider">

      <!-- Single Testimonial -->
      <div class="testimonial-item px-3">
        <div class="testimonial-content bg-white text-dark rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center">
          <div class="testimonial-img mb-3">
            <img src="img/about/team-1.jpg" alt="Aarav K" class="rounded-circle shadow"
                 style="width: 90px; height: 90px; object-fit: cover; border: 4px solid #28a745;">
          </div>
          <p class="fst-italic text-center flex-grow-1">
            "Excellent product quality and delivery service! I love how quick the support team is."
          </p>
          <h6 class="fw-bold mt-3 mb-0">Aarav K.</h6>
          <small class="text-muted">Verified Buyer</small>
        </div>
      </div>

      <!-- Single Testimonial -->
      <div class="testimonial-item px-3">
        <div class="testimonial-content bg-white text-dark rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center">
          <div class="testimonial-img mb-3">
            <img src="img/about/team-2.jpg" alt="Priya D" class="rounded-circle shadow"
                 style="width: 90px; height: 90px; object-fit: cover; border: 4px solid #28a745;">
          </div>
          <p class="fst-italic text-center flex-grow-1">
            "Amazing experience! The products are top quality and the discounts are unbeatable."
          </p>
          <h6 class="fw-bold mt-3 mb-0">Priya D.</h6>
          <small class="text-muted">Frequent Shopper</small>
        </div>
      </div>

      <!-- Single Testimonial -->
      <div class="testimonial-item px-3">
        <div class="testimonial-content bg-white text-dark rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center">
          <div class="testimonial-img mb-3">
            <img src="img/about/team-3.jpg" alt="Rohan M" class="rounded-circle shadow"
                 style="width: 90px; height: 90px; object-fit: cover; border: 4px solid #28a745;">
          </div>
          <p class="fst-italic text-center flex-grow-1">
            "Fast shipping, great packaging, and premium quality — couldn’t ask for more!"
          </p>
          <h6 class="fw-bold mt-3 mb-0">Rohan M.</h6>
          <small class="text-muted">Happy Customer</small>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- 🆕 NEW COLLECTIONS SECTION -->
<section class="new-collection-section py-5 bg-light">
  <div class="container text-center" data-aos="fade-up">

    <!-- Heading -->
    <h2 class="fw-bold display-6 mb-3 text-dark">New Collections</h2>
    <p class="text-muted mb-5 mx-auto" style="max-width:700px;">
      Explore our latest fashion arrivals — blending comfort, luxury, and modern design. 
      Discover the perfect pieces to elevate your everyday look.
    </p>

    <!-- 🧩 Collection Grid -->
    <div class="row g-4 justify-content-center">

      <!-- 🧥 Men's Clothing -->
      <div class="col-lg-4 col-md-6">
        <div class="collection-card position-relative bg-white border-0 shadow-sm overflow-hidden">
          <img src="img/banner/banner-1.jpg" 
               alt="Men's Fashion Shirt" class="img-fluid w-100 collection-img">
          <div class="p-4 text-center">
            <h6 class="fw-semibold text-uppercase mb-2">Men’s Clothing</h6>
            <p class="text-muted small mb-3">
              Discover stylish and comfortable shirts and jackets — crafted for every modern man.
            </p>
            <a href="shop.php?category=clothing" class="text-decoration-none text-dark fw-semibold discover-link">
              Discover Now <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- 🕶️ Men's Accessories -->
      <div class="col-lg-4 col-md-6">
        <div class="collection-card position-relative bg-white border-0 shadow-sm overflow-hidden">
          <img src="img/banner/banner-2.jpg" 
               alt="Men's Accessories" class="img-fluid w-100 collection-img">
          <div class="p-4 text-center">
            <h6 class="fw-semibold text-uppercase mb-2">Men’s Accessories</h6>
            <p class="text-muted small mb-3">
              Premium watches, sunglasses, and leather goods that complete your unique style.
            </p>
            <a href="shop.php?category=accessories" class="text-decoration-none text-dark fw-semibold discover-link">
              Discover Now <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- 👖 Men's Pants -->
      <div class="col-lg-4 col-md-6">
        <div class="collection-card position-relative bg-white border-0 shadow-sm overflow-hidden">
          <img src="img/banner/banner-3.jpg" 
               alt="Men's Pants" class="img-fluid w-100 collection-img">
          <div class="p-4 text-center">
            <h6 class="fw-semibold text-uppercase mb-2">Men’s Pants</h6>
            <p class="text-muted small mb-3">
              Tailored trousers and casual chinos designed for comfort and confidence.
            </p>
            <a href="shop.php?category=pants" class="text-decoration-none text-dark fw-semibold discover-link">
              Discover Now <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- 📧 NEWSLETTER SECTION -->
<section class="newsletter-section py-5 text-white position-relative">
  <div class="overlay"></div>
  <div class="container position-relative" data-aos="fade-up">
    <div class="text-center mb-4">
      <h2 class="fw-bold mb-2"><i class="fa-solid fa-envelope-open-text me-2"></i>Stay Updated!</h2>
      <p class="text-light mb-0">Subscribe to get exclusive offers, new arrivals, and fashion updates straight to your inbox.</p>
    </div>

    <form class="newsletter-form mx-auto d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-4" onsubmit="return false;">
      <input type="email" class="form-control form-control-lg shadow-sm" placeholder="Enter your email address" required style="max-width:400px;">
      <button type="submit" class="btn btn-light btn-lg fw-semibold px-4 text-success shadow-sm">Subscribe</button>
    </form>

    <p class="text-light mt-3 small text-center">We respect your privacy — unsubscribe anytime.</p>
  </div>
</section>

</div>

<?php include "Layouts/_footer.php"; ?>

<!-- ✅ JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function(){
  $(".testimonial-slider").owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 4000,
    smartSpeed: 800,
    margin: 20,
    nav: false,
    dots: true,
    responsive: {
      768: { items: 2 },
      992: { items: 3 }
    }
  });
});
</script>
<script>
  let categories = [];
  let visibleCount = 8;
  let showAll = false;

  function renderCategories() {
    const list = $("#categoryList");
    list.empty();

    const sorted = [...categories];
    const sortOrder = $("#sortCategory").val();
    sorted.sort((a, b) => sortOrder === "asc" ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name));

    const searchTerm = $("#searchCategory").val().toLowerCase();
    const filtered = sorted.filter(c => c.name.toLowerCase().includes(searchTerm));

    const toShow = showAll ? filtered : filtered.slice(0, visibleCount);
    toShow.forEach(cat => {
      list.append(`
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
          <div class="card border-0 shadow-sm category-card">
            <div class="card-body text-center p-3">
              <img src="${cat.image || 'img/icons/default.png'}" class="img-fluid mb-2" alt="${cat.name}" style="width:60px;height:60px;object-fit:contain;">
              <h6 class="fw-semibold text-dark mb-0">${cat.name}</h6>
            </div>
          </div>
        </div>
      `);
    });

    $("#toggleCategoriesBtn").toggleClass("d-none", filtered.length <= visibleCount);
    $("#toggleCategoriesBtn").text(showAll ? "Show Less" : "Show More");
  }

  function toggleCategories() {
    showAll = !showAll;
    renderCategories();
  }

  // Example Fetch Simulation (Replace with your AJAX)
  $(document).ready(() => {
    categories = [
      { name: "Clothing", image: "img/icons/clothing.png" },
      { name: "Footwear", image: "img/icons/shoes.png" },
      { name: "Watches", image: "img/icons/watch.png" },
      { name: "Accessories", image: "img/icons/accessory.png" },
      { name: "Beauty", image: "img/icons/beauty.png" },
      { name: "Electronics", image: "img/icons/electronics.png" },
      { name: "Bags", image: "img/icons/bag.png" },
      { name: "Home Decor", image: "img/icons/home.png" },
      { name: "Sports", image: "img/icons/sports.png" },
    ];
    renderCategories();
  });

  $("#searchCategory, #sortCategory").on("input change", renderCategories);
</script>

<script>
AOS.init({ duration: 900, once: true });

// 🏠 HERO SLIDER
$(".set-bg").each(function () {
  const bg = $(this).data("setbg");
  $(this).css("background-image", "url(" + bg + ")");
});
$(".hero__slider").owlCarousel({
  items: 1,
  loop: true,
  autoplay: true,
  autoplayTimeout: 4000,
  smartSpeed: 800,
  nav: true,
  dots: false,
  navText: ['<span class="arrow_left"></span>', '<span class="arrow_right"></span>']
});

// 🧠 CATEGORY LOGIC (Search + Sort + Show More)
let allCategories = [];
let activeCategory = null;
let showAllCategories = false;

$(document).ready(function () {
  loadCategories();
  loadProducts("featuredGrid", false, true);
  loadProducts("latestGrid", true);
});

function loadCategories() {
  $.ajax({
    url: "../Controllers/CategorieController.php",
    method: "GET",
    success: function (res) {
      res = JSON.parse(res);
      allCategories = res.Result || [];
      renderCategories(allCategories);
    }
  });
}

function renderCategories(categories) {
  const $list = $("#categoryList");
  $list.empty();

  if (!categories.length) {
    $list.html(`<p class="text-muted">No categories found.</p>`);
    $("#toggleCategoriesBtn").addClass("d-none");
    return;
  }

  const visibleCount = showAllCategories ? categories.length : 8;
  const visibleCategories = categories.slice(0, visibleCount);

  visibleCategories.forEach(cat => {
    $list.append(`
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm category-card h-100" onclick="selectCategory(${cat.Categorieid}, '${cat.category_name}')">
          <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
            <i class="fa-solid fa-shirt fa-2x text-success mb-3"></i>
            <h6 class="fw-bold mb-0">${cat.category_name}</h6>
          </div>
        </div>
      </div>
    `);
  });

  if (categories.length > 8) {
    $("#toggleCategoriesBtn").removeClass("d-none");
    $("#toggleCategoriesBtn").text(showAllCategories ? "Show Less" : "Show More");
  } else {
    $("#toggleCategoriesBtn").addClass("d-none");
  }
}

function toggleCategories() {
  showAllCategories = !showAllCategories;
  renderCategories(allCategories);
}

// 🔍 Search + Sort
$("#searchCategory").on("input", function () {
  const query = $(this).val().toLowerCase();
  const filtered = allCategories.filter(c => c.category_name.toLowerCase().includes(query));
  renderCategories(filtered);
});

$("#sortCategory").on("change", function () {
  const order = $(this).val();
  const sorted = [...allCategories].sort((a, b) =>
    order === "asc"
      ? a.category_name.localeCompare(b.category_name)
      : b.category_name.localeCompare(a.category_name)
  );
  renderCategories(sorted);
});

function selectCategory(id, name) {
  activeCategory = id;
  $(".category-card").removeClass("active");
  $(`.category-card:contains('${name}')`).addClass("active");
  loadProducts("latestGrid", false, false, id);
}

// 🛒 PRODUCTS + CART
function loadProducts(targetGrid, latest = false, featured = false, categoryId = null) {
  let $target = $("#" + targetGrid);
  $target.html(`<div class="text-center py-5"><div class="spinner-border text-success"></div></div>`);

  $.ajax({
    url: "../Controllers/ProductController.php",
    method: "GET",
    success: function (res) {
      res = JSON.parse(res);
      let products = res.Result;
      if (featured) products = products.slice(0, 8);
      if (latest) products = products.slice(-8).reverse();
      if (categoryId) products = products.filter(p => p.category_id == categoryId);

      $target.empty();
      if (!products.length) {
        $target.html(`<p class="text-center text-muted">No products found.</p>`);
        return;
      }

      if (targetGrid === "featuredGrid") {
        let html = "";
        products.forEach(p => {
          let img = p.image_url ? `../Content/Photo/${p.image_url}` : `../Content/no-image.png`;
          let price = p.discount_price > 0
            ? `<span class="text-danger"><s>₹${p.price}</s> ₹${p.discount_price}</span>`
            : `<span>₹${p.price}</span>`;
          html += `
            <div class="swiper-slide">
              <div class="card border-0 shadow-sm product-card">
                <img src="${img}" class="card-img-top" alt="${p.product_name}">
                <div class="card-body text-center">
                  <h6 class="fw-bold">${p.product_name}</h6>
                  <p class="small text-muted">${p.brand || ""}</p>
                  <p class="fw-bold">${price}</p>
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-outline-success btn-sm" onclick="viewDetails(${p.product_id})">View</button>
                    <button class="btn btn-success btn-sm" onclick="addToCart(${p.product_id})"><i class="fa-solid fa-cart-plus"></i></button>
                  </div>
                </div>
              </div>
            </div>`;
        });
        $(".featuredSwiper .swiper-wrapper").html(html);
        new Swiper(".featuredSwiper", {
          slidesPerView: 1,
          spaceBetween: 10,
          pagination: { el: ".swiper-pagination", clickable: true },
          breakpoints: { 576: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 992: { slidesPerView: 4 } }
        });
      } else {
        products.slice(0, 8).forEach(p => {
          let img = p.image_url ? `../Content/Photo/${p.image_url}` : `../Content/no-image.png`;
          let price = p.discount_price > 0
            ? `<span class="text-danger"><s>₹${p.price}</s> ₹${p.discount_price}</span>`
            : `<span>₹${p.price}</span>`;
          $target.append(`
            <div class="col-xl-3 col-lg-4 col-md-6 fade-in" data-aos="zoom-in">
              <div class="card border-0 shadow-sm h-100 product-card">
                <img src="${img}" class="card-img-top">
                <div class="card-body text-center">
                  <h6 class="fw-bold">${p.product_name}</h6>
                  <p class="small text-muted">${p.brand || ""}</p>
                  <p class="fw-bold">${price}</p>
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-outline-success btn-sm" onclick="viewDetails(${p.product_id})">View</button>
                    <button class="btn btn-success btn-sm" onclick="addToCart(${p.product_id})"><i class="fa-solid fa-cart-plus"></i></button>
                  </div>
                </div>
              </div>
            </div>`);
        });
      }
    }
  });
}

function addToCart(productId, productName = "") {

  const userId = localStorage.getItem("UserId");

  // 🔐 LOGIN CHECK
  if (!userId) {
    Swal.fire({
      icon: "warning",
      title: "Login Required",
      text: "Please login to add products in your cart.",
      showCancelButton: true,
      confirmButtonColor: "#0d6efd",
      confirmButtonText: "Login Now",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "login.php";
      }
    });
    return;
  }

  $.ajax({
    url: "../Controllers/CartController.php",
    method: "POST",
    data: {
      product_id: productId,
      quantity: 1,
      UserId: userId
    },

    success: function (res) {

      Swal.fire({
        icon: "success",
        title: "Added to Cart!",
        html: `
          <b>${productName}</b><br>
          Quantity: <b>1</b><br>
          Successfully added to your cart.
        `,
        confirmButtonColor: "#28a745",
        confirmButtonText: "Continue Shopping",
        showCancelButton: true,
        cancelButtonColor: "#0d6efd",
        cancelButtonText: "Go to Cart"
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.cancel) {
          window.location.href = "cart.php";
        }
      });

      // Update navbar cart count
      updateCartCount();
    },

    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error!",
        text: "Failed to add product. Please try again.",
        confirmButtonColor: "#d33"
      });
    }
  });
}

function updateCartCount() {
  const userId = localStorage.getItem("UserId");
  $.ajax({
    url: "../Controllers/CartController.php",
    method: "GET",
    data: { Choice: "GetCartCount", user_id: userId },
    success: function (res) {
      try {
        res = JSON.parse(res);
        if (res.Status === "OK") {
          $("#cartCount").text(res.Result);
        }
      } catch (e) {}
    }
  });
}

function viewDetails(id) {
  window.location.href = `product_details.php?id=${id}`;
}
</script>

<style>
.hero__items {
  height: 90vh;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  position: relative;
}
.hero__items::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
}
.hero__text { position: relative; z-index: 2; color: #fff; }
.hero__text h6 { color: #28a745; font-weight: 700; text-transform: uppercase; }
.hero__text h2 { font-size: 3rem; font-weight: 800; margin: 15px 0; }
.primary-btn { background: #28a745; color: #fff; padding: 12px 30px; border-radius: 50px; font-weight: 600; }
.primary-btn:hover { background: #1f8b3d; }

.category-card {
  cursor: pointer;
  border-radius: 15px;
  transition: all 0.3s ease;
  background: #fff;
}
.category-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
.category-card.active {
  border: 2px solid #28a745;
  box-shadow: 0 0 10px rgba(40,167,69,0.4);
}
</style>
