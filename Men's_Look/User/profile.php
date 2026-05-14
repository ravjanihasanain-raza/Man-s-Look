<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include_once "Layouts/_Header.php";
include_once "Layouts/navbar.php";

$userId = $_SESSION['user']['id'];
?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* UI & DESIGN */
body { background: #f5f7fa; }

.card { border-radius: 14px !important; }
.nav-link { border-radius: 8px; padding: 8px 12px; }
.nav-link:hover { background: #eef4ff; }

#profileImagePreview {
  border: 4px solid #fff;
  box-shadow: 0px 3px 10px rgba(0,0,0,0.15);
}

/* E-commerce Orders */
.order-card {
  background: #fff;
  border-radius: 14px;
  padding: 16px;
  display: flex;
  gap: 20px;
  border: 1px solid #e3e6ea;
  margin-bottom: 16px;
  transition: 0.2s;
}
.order-card:hover {
  transform: scale(1.01);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.order-img {
  width: 90px;
  height: 90px;
  object-fit: contain;
  border-radius: 8px;
  background: #fff;
  border: 1px solid #ddd;
}

.order-status {
  font-weight: bold;
  padding: 3px 8px;
  border-radius: 6px;
  display: inline-block;
}
.status-pending { background: #fff3cd; color: #856404; }
.status-shipped { background: #d1ecf1; color: #0c5460; }
.status-delivered { background: #d4edda; color: #155724; }
.status-cancelled { background: #f8d7da; color: #721c24; }

.text-error { color: red; font-size: 13px; display: none; }
</style>

<div class="container py-5">
  <div class="row g-4">

    <!-- Sidebar -->
    <div class="col-lg-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">

          <div class="position-relative mb-3">
            <img id="profileImagePreview"
              src="../assets/default-user.png"
              class="rounded-circle"
              style="width:120px; height:120px; object-fit:cover;">

            <label for="profileImage" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1" style="cursor:pointer;">
              <i class="fa-solid fa-camera"></i>
            </label>
            <input type="file" id="profileImage" accept="image/*" hidden>
          </div>

          <h5 id="userName" class="fw-bold mb-1">Loading...</h5>
          <p id="userEmail" class="text-muted small mb-2">Loading...</p>

          <hr>
          <ul class="nav flex-column text-start">
            <li class="nav-item mb-2"><a href="#overview" class="nav-link active"><i class="fa-solid fa-user me-2 text-primary"></i>Overview</a></li>
            <li class="nav-item mb-2"><a href="#edit-profile" class="nav-link"><i class="fa-solid fa-user-pen me-2 text-info"></i>Edit Profile</a></li>
            <li class="nav-item mb-2"><a href="#change-password" class="nav-link"><i class="fa-solid fa-lock me-2 text-warning"></i>Change Password</a></li>
            <li class="nav-item mb-2"><a href="order_list.php" class="nav-link"><i class="fa-solid fa-box me-2 text-success"></i>My Orders</a></li>
            <li class="nav-item mb-2"><a href="cart.php" class="nav-link"><i class="fa-solid fa-cart-shopping me-2 text-danger"></i>My Cart</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-danger fw-bold" onclick="logoutUser()"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-lg-9">

      <!-- Overview -->
      <div id="overview" class="card shadow-sm mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3"><i class="fa-solid fa-id-badge text-primary me-2"></i>Profile Overview</h5>
          <div id="profileOverview" class="row">
            <div class="col-12 text-center text-muted">Loading profile...</div>
          </div>
        </div>
      </div>

      <!-- Edit Profile -->
      <div id="edit-profile" class="card shadow-sm mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3"><i class="fa-solid fa-user-pen text-info me-2"></i>Edit Profile</h5>

          <form id="editProfileForm">
            <div class="row g-3">
              <div class="col-md-6">
                <label>Full Name</label>
                <input type="text" id="editName" class="form-control">
                <small id="nameError" class="text-error">Enter valid name</small>
              </div>

              <div class="col-md-6">
                <label>Email</label>
                <input type="email" id="editEmail" class="form-control">
                <small id="emailError" class="text-error">Enter valid email</small>
              </div>

              <div class="col-md-6">
                <label>Mobile</label>
                <input type="text" id="editMobile" class="form-control" maxlength="10">
                <input type="hidden" id="UserID">
                <small id="mobileError" class="text-error">Enter 10 digit mobile</small>
              </div>
            </div>

            <div class="text-end mt-3">
              <button class="btn btn-primary btn-sm"><i class="fa-solid fa-save me-1"></i>Save</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Change Password -->
      <div id="change-password" class="card shadow-sm mb-4">
        <div class="card-body">

          <h5 class="fw-bold mb-3"><i class="fa-solid fa-lock text-warning me-2"></i>Change Password</h5>

          <form id="changePasswordForm">
            <input type="hidden" id="UserPassID">

            <div class="row g-3">
              <div class="col-md-6">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control">
              </div>

              <div class="col-md-6">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control">
              </div>

              <div class="col-md-6">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
              </div>
            </div>

            <div class="mt-3 text-end">
              <button class="btn btn-warning btn-sm"><i class="fa-solid fa-key me-1"></i> Update Password</button>
            </div>
          </form>

        </div>
      </div>

      <!-- My Orders -->
      <!-- <div id="orders" class="card shadow-sm mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3"><i class="fa-solid fa-box text-success me-2"></i>My Orders</h5>
          <div id="ordersList">Loading orders...</div>
        </div>
      </div>

        My Cart -->
      <!-- <div id="cart" class="card shadow-sm mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3"><i class="fa-solid fa-cart-shopping text-danger me-2"></i>My Cart</h5>
          <div id="cartList">Loading cart...</div>
        </div>
      </div> --> 
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

  const userId = localStorage.getItem("UserId");
  $("#UserID").val(userId);
  $("#UserPassID").val(userId);

  /* ------------------- Load Profile ------------------- */
  function loadProfile() {
    $.get(`../Controllers/UserController.php?Choice=Profile&UserId=${userId}`, function(res) {
      res = JSON.parse(res);

      const u = res.User;
      $("#userName").text(u.name);
      $("#userEmail").html(`<i class="fa-solid fa-envelope me-1"></i>${u.email}`);
      $("#profileImagePreview").attr("src", u.profile_image ? 
        `../uploads/profile/${u.profile_image}` : "../assets/default-user.png");

      $("#profileOverview").html(`
        <div class="col-md-6"><b>Name:</b> ${u.name}</div>
        <div class="col-md-6"><b>Email:</b> ${u.email}</div>
        <div class="col-md-6"><b>Mobile:</b> ${u.ContactNo}</div>
        <div class="col-md-6"><b>Joined:</b> ${new Date(u.created_at).toLocaleDateString()}</div>
      `);

      $("#editName").val(u.name);
      $("#editEmail").val(u.email);
      $("#editMobile").val(u.ContactNo);
    });
  }
  loadProfile();


  /* ------------------- Edit Profile + SweetAlert ------------------- */
  $("#editProfileForm").on("submit", function(e) {
    e.preventDefault();

    let name = $("#editName").val().trim();
    let email = $("#editEmail").val().trim();
    let mobile = $("#editMobile").val().trim();

    let valid = true;

    if (!/^[A-Za-z ]{3,}$/.test(name)) { $("#nameError").show(); valid = false; }
    else $("#nameError").hide();

    if (!/^\S+@\S+\.\S+$/.test(email)) { $("#emailError").show(); valid = false; }
    else $("#emailError").hide();

    if (!/^\d{10}$/.test(mobile)) { $("#mobileError").show(); valid = false; }
    else $("#mobileError").hide();

    if (!valid) return;

    let data = {
      action: "updateProfile",
      UserID: $("#UserID").val(),
      name,
      email,
      mobile
    };

    $.post("../Controllers/UserController.php", data, function(res) {
      res = JSON.parse(res);

      if (res.Status === "Ok") {
        Swal.fire("Success!", "Profile updated successfully!", "success");
        loadProfile();
      } else {
        Swal.fire("Error", res.Message, "error");
      }
    });
  });


  /* ------------------- Change Password + SweetAlert ------------------- */
  $("#changePasswordForm").on("submit", function(e) {
    e.preventDefault();

    let fd = new FormData(this);
    fd.append("action", "changePassword");

    $.ajax({
      url: "../Controllers/UserController.php",
      type: "POST",
      data: fd,
      contentType: false,
      processData: false,
      success: function(res) {
        res = JSON.parse(res);

        if (res.Status === "Ok") {
          Swal.fire("Password Changed!", res.Message, "success");
          $("#changePasswordForm")[0].reset();
        } else {
          Swal.fire("Error", res.Message, "error");
        }
      }
    });
  });


  /* ------------------- Profile Image Upload + SweetAlert ------------------- */
  $("#profileImage").on("change", function() {
    let file = this.files[0];
    let reader = new FileReader();
    reader.onload = e => $("#profileImagePreview").attr("src", e.target.result);
    reader.readAsDataURL(file);

    let fd = new FormData();
    fd.append("profile_image", file);

    $.ajax({
      url: "../Controllers/UploadProfileImageController.php",
      type: "POST",
      data: fd,
      contentType: false,
      processData: false,
      success: function(res) {
        res = JSON.parse(res);

        if (res.Status === "Ok") {
          Swal.fire("Updated!", "Profile picture updated!", "success");
          loadProfile();
        } else {
          Swal.fire("Error", res.Message, "error");
        }
      }
    });
  });


  /* ------------------- Load Orders ------------------- */
  function loadOrders() {
    $.get("../Controllers/OrderController.php?Choice=UserOrder&user_id=" + userId, function(res) {
      res = JSON.parse(res);

      if (res.Status !== "OK" || res.Result.length === 0) {
        $("#ordersList").html("<p class='text-muted'>No orders found.</p>");
        return;
      }

      let html = "";
      res.Result.forEach(o => {
        let statusClass =
          o.status === "Shipped" ? "status-shipped" :
          o.status === "Delivered" ? "status-delivered" :
          o.status === "Cancelled" ? "status-cancelled" : "status-pending";

        html += `
          <div class="order-card">
            <img src="../Content/Photo/${o.image_url}" class="order-img">

            <div class="flex-grow-1">
              <h6>${o.product_name}</h6>
              <span class="order-status ${statusClass}">${o.status}</span>
              <div class="mt-2">
                <small><b>Order ID:</b> ${o.order_id}</small><br>
                <small><b>Date:</b> ${new Date(o.order_date).toLocaleString()}</small><br>
                <small><b>Qty:</b> ${o.quantity}</small>
              </div>
            </div>

            <div class="text-end">
              <p class="price-text">₹${o.price}</p>
            </div>
          </div>`;
      });

      $("#ordersList").html(html);
    });
  }
  loadOrders();


  /* ------------------- Load Cart ------------------- */
  function loadCart() {
    $.get("../Controllers/CartController.php", function(res) {
      res = JSON.parse(res);

      if (res.Status !== "Ok" || res.Result.length === 0) {
        $("#cartList").html("<p class='text-muted'>Your cart is empty.</p>");
        return;
      }

      let html = "";
      res.Result.forEach(c => {
        html += `
        <div class="d-flex justify-content-between border-bottom py-2">
          <span>${c.product_name} (x${c.quantity})</span>
          <span class="fw-bold">₹${c.price}</span>
        </div>`;
      });

      $("#cartList").html(html);
    });
  }
  loadCart();


  /* ------------------- Logout ------------------- */
  window.logoutUser = function() {
    Swal.fire({
      title: "Logout?",
      text: "Are you sure you want to logout?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Logout",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("../Controllers/LogoutController.php", function() {
          window.location.href = "login.php";
        });
      }
    });
  };

});
</script>

<?php include_once "Layouts/_Footer.php"; ?>
