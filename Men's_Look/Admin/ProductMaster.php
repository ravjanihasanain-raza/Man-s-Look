<?php include "Layouts/_Header.php" ?>
<?php include "Layouts/navbar.php" ?>

<style>
body {
  background-color: #f8f9fa;
  overflow-x: hidden;
}

#sidebar {
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  width: 260px;
  color: #fff;
  border-right: 1px solid #e1e1e1;
  z-index: 999;
  transition: width 0.3s ease;
}

#sidebar.collapsed {
  width: 80px;
}

#adminHeader {
  position: fixed;
  top: 0;
  left: 260px;
  right: 0;
  height: 60px;
  background: linear-gradient(90deg, #0E8388, #072E33);
  color: white;
  z-index: 1000;
  transition: all 0.3s ease;
}

#adminHeader.expanded {
  left: 80px;
}

.content {
  margin-left: 260px;
  margin-top: 70px;
  padding: 20px;
  transition: margin-left 0.3s ease;
}

.content.expanded {
  margin-left: 80px;
}

@media (max-width: 768px) {
  #sidebar {
    width: 0;
    overflow: hidden;
  }
  #adminHeader {
    left: 0 !important;
  }
  .content {
    margin-left: 0 !important;
  }
}
</style>

<div class="content" id="content">
  <div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>Manage Products</h3>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
        + Add Product
      </button>
    </div>

    <div class="card shadow">
      <div class="card-body">

        <!-- Products Table -->
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="products"></tbody>
        </table>

        <!-- Pagination Buttons -->
        <div class="d-flex justify-content-between mt-3">
          <button class="btn btn-secondary" id="btnPrev">Previous</button>
          <button class="btn btn-secondary" id="btnNext">Next</button>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Product Form Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Add / Edit Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <form id="productForm" enctype="multipart/form-data">
          <input type="hidden" name="product_id" id="product_id" value="0">

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Product Name</label>
              <input type="text" id="product_name" name="product_name" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label>Category</label>
              <select id="category_id" name="category_id" class="form-control">
                <option value="">-- Select Category --</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label>Description</label>
            <textarea id="description" name="description" class="form-control"></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Brand</label>
              <input type="text" id="brand" name="brand" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
              <label>Price</label>
              <input type="number" id="price" name="price" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
              <label>Discount</label>
              <input type="number" id="discount_price" name="discount_price" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label>Stock Quantity</label>
              <input type="number" id="stock_quantity" name="stock_quantity" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
              <label>Size</label>
              <input type="text" id="size" name="size" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
              <label>Color</label>
              <input type="text" id="color" name="color" class="form-control">
            </div>
          </div>

          <div class="row align-items-center mb-3">
            <div class="col-md-8">
              <label>Product Image</label>
              <input type="file" id="Photo" name="Photo" class="form-control">
            </div>
            <div class="col-md-4 text-center">
              <img id="previewImage" src="" class="img-thumbnail" style="max-width:100px; display:none;">
            </div>
          </div>

          <div class="mb-3">
            <label>Status</label>
            <select id="status" name="status" class="form-control">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" id="btnSaveProduct" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include "Layouts/_footer.php" ?>

<script>
$(document).ready(function () {
  loadCategories();
  loadProducts();
});

/* Pagination Variables */
let allProducts = [];
let currentPage = 1;
let itemsPerPage = 5;

let base64String = "";
let categoryMap = {};

/* Image Preview */
$('#Photo').on('change', function (e) {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function (event) {
    base64String = event.target.result;
    $("#previewImage").attr("src", base64String).show();
  };
  reader.readAsDataURL(file);
});

/* Load Categories */
function loadCategories() {
  $("#category_id").empty().append('<option value="">-- Select Category --</option>');

  $.ajax({
    url: "../Controllers/CategorieController.php",
    method: "GET",
    success: function (res) {
      res = JSON.parse(res);
      categoryMap = {};

      res.Result.forEach(cat => {
        $("#category_id").append(`<option value="${cat.Categorieid}">${cat.category_name}</option>`);
        categoryMap[cat.Categorieid] = cat.category_name;
      });
    }
  });
}

/* Load Products */
function loadProducts() {
  $.ajax({
    url: "../Controllers/ProductController.php",
    method: "GET",
    success: function (res) {
      res = JSON.parse(res);
      allProducts = res.Result;

      renderProducts();
    }
  });
}

/* Render Page-Wise Products */
function renderProducts() {
  $("#products").empty();

  let start = (currentPage - 1) * itemsPerPage;
  let end = start + itemsPerPage;

  let pageProducts = allProducts.slice(start, end);

  pageProducts.forEach((p) => {
    let imgTag = p.image_url
      ? `<img src="../Content/Photo/${p.image_url}" style="width:60px;height:60px;object-fit:cover;" />`
      : "";

    $("#products").append(`
      <tr>
        <td>${imgTag}</td>
        <td>${p.product_name}</td>
        <td>${categoryMap[p.category_id] || ""}</td>
        <td>${p.price}</td>
        <td>${p.stock_quantity}</td>
        <td>${p.status}</td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="editProduct(${p.product_id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.product_id})">Delete</button>
        </td>
      </tr>
    `);
  });

  $("#btnPrev").prop("disabled", currentPage === 1);
  $("#btnNext").prop("disabled", end >= allProducts.length);
}

/* Next Button */
$("#btnNext").click(function () {
  if ((currentPage * itemsPerPage) < allProducts.length) {
    currentPage++;
    renderProducts();
  }
});

/* Previous Button */
$("#btnPrev").click(function () {
  if (currentPage > 1) {
    currentPage--;
    renderProducts();
  }
});

/* Edit Product */
function editProduct(id) {
  $.ajax({
    url: "../Controllers/ProductController.php",
    method: "GET",
    data: { ID: id },
    dataType: "json",
    success: function (response) {
      if (response.Status === "Ok") {
        const p = response.Result;

        $("#product_id").val(p.product_id);
        $("#product_name").val(p.product_name);
        $("#category_id").val(p.category_id);
        $("#description").val(p.description);
        $("#brand").val(p.brand);
        $("#price").val(p.price);
        $("#discount_price").val(p.discount_price);
        $("#stock_quantity").val(p.stock_quantity);
        $("#size").val(p.size);
        $("#color").val(p.color);
        $("#status").val(p.status);

        $("#previewImage").attr("src", "../Content/Photo/" + p.image_url).show();
        base64String = "";

        new bootstrap.Modal(document.getElementById("productModal")).show();
      }
    }
  });
}

/* Save / Update Product */
$("#btnSaveProduct").click(function () {
  const reqJSON = {
    product_id: $("#product_id").val(),
    category_id: $("#category_id").val(),
    product_name: $("#product_name").val(),
    description: $("#description").val(),
    brand: $("#brand").val(),
    price: $("#price").val(),
    discount_price: $("#discount_price").val(),
    stock_quantity: $("#stock_quantity").val(),
    size: $("#size").val(),
    color: $("#color").val(),
    status: $("#status").val(),
    base64String: base64String
  };

  $.ajax({
    url: "../Controllers/ProductController.php",
    method: ($("#product_id").val() == "0" ? "POST" : "PUT"),
    contentType: "application/json",
    data: JSON.stringify(reqJSON),
    success: function (res) {
      res = JSON.parse(res);

      if (res.Status == "Ok") {
        alert(res.Result);
        $("#productModal").modal("hide");
        loadProducts();
      } else {
        alert(res.Result);
      }
    }
  });
});

/* Delete Product */
function deleteProduct(id) {
  if (confirm("Are you sure to delete this product?")) {
    $.ajax({
      url: "../Controllers/ProductController.php?ID=" + id,
      method: "DELETE",
      success: function (res) {
        res = JSON.parse(res);
        alert(res.Result);
        loadProducts();
      }
    });
  }
}
</script>
