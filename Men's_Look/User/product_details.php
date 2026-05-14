<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Page Wrapper */
.product-wrapper {
    max-width: 1150px;
    margin: auto;
}

.product-image-box {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e1e1e1;
    background: #fff;
    padding: 10px;
}

.product-main-img {
    height: 420px;
    width: 100%;
    object-fit: contain;
    transition: .3s;
}
.product-main-img:hover {
    transform: scale(1.05);
}

.product-info-box {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
}

.product-title { font-size: 2rem; font-weight: 700; }

.old-price {
    text-decoration: line-through;
    color: gray;
}

.discount-badge {
    background: #d32f2f;
    color: white;
    padding: 4px 8px;
    border-radius: 5px;
}

.highlights-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
}
</style>

<div class="content" id="content">
  <div class="container py-5">
    <div id="productDetails" class="product-wrapper"></div>
  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<script>
$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    if (productId) loadProductDetails(productId);
});

/* LOAD SINGLE PRODUCT */
function loadProductDetails(id) {
    $.ajax({
        url: "../Controllers/ProductController.php",
        method: "GET",
        success: function (res) {

            res = JSON.parse(res);
            const product = res.Result.find(p => p.product_id == id);

            if (!product) {
                $("#productDetails").html("<h4 class='text-danger text-center'>Product Not Found</h4>");
                return;
            }

            let img = product.image_url 
                ? `../Content/Photo/${product.image_url}` 
                : `../Content/no-image.png`;

            let priceHTML = "";
            if (product.discount_price > 0) {
                let discount = Math.round(((product.price - product.discount_price) / product.price) * 100);
                priceHTML = `
                    <h4 class="text-danger">₹${product.discount_price}</h4>
                    <span class="old-price">₹${product.price}</span>
                    <span class="discount-badge ms-2">-${discount}% OFF</span>
                `;
            } else {
                priceHTML = `<h4 class="text-dark mb-3">₹${product.price}</h4>`;
            }

            $("#productDetails").html(`
                <div class="row g-4">

                    <div class="col-md-5">
                        <div class="product-image-box">
                            <img src="${img}" class="product-main-img">
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="product-info-box">

                            <h2 class="product-title">${product.product_name}</h2>
                            <p class="text-muted">${product.brand || "Brand Not Mentioned"}</p>

                            ${priceHTML}

                            <p class="text-secondary mt-3">${product.description || "No description available."}</p>

                            <div class="d-flex align-items-center mt-4 mb-3">
                                <label class="fw-bold me-3">Quantity:</label>
                                <input type="number" id="qty" class="form-control" value="1" min="1" style="width:90px;">
                            </div>

                            <button class="btn btn-success btn-lg px-4"
                                onclick="addToCart(${product.product_id}, '${product.product_name}')">
                                <i class="bi bi-cart"></i> Add to Cart
                            </button>

                        </div>
                    </div>

                </div>

                <div class="highlights-box mt-4">
                    <h5 class="fw-bold">Product Highlights</h5>
                    <ul class="mt-2">
                        <li>High quality guaranteed</li>
                        <li>Fast delivery across India</li>
                        <li>Secure payment options</li>
                        <li>7-day easy return policy</li>
                    </ul>
                </div>
            `);
        }
    });
}

/* SWEETALERT ADD TO CART */
function addToCart(productId, productName) {

    const qty = $("#qty").val();
    const userId = localStorage.getItem("UserId");

    if (!userId) {
        Swal.fire({
            icon: "warning",
            title: "Please Login First",
            text: "You need to login to add items to cart.",
            confirmButtonColor: "#0d6efd"
        });
        return;
    }

    $.ajax({
        url: "../Controllers/CartController.php",
        method: "POST",
        data: {
            product_id: productId,
            quantity: qty,
            UserId: userId
        },
        success: function () {

            Swal.fire({
                icon: "success",
                title: "Added to Cart!",
                html: `
                    <b>${productName}</b><br>
                    Quantity: <b>${qty}</b><br>
                    Successfully added to your cart.
                `,
                confirmButtonColor: "#198754",
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
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Unable to add product, please try again.",
                confirmButtonColor: "#d33"
            });
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
                if (res.Status === "OK") {
                    $("#cartCount").text(res.Result);
                }
            } catch {}
        }
    });
}
</script>
