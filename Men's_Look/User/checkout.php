<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content" id="content">
  <div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">🧾 Checkout</h2>

    <div class="row">
      <!-- LEFT SIDE BILLING FORM -->
      <div class="col-md-7">
        <div class="card shadow-sm p-4">
          <h5 class="mb-3 fw-bold">Billing Information</h5>

          <form id="checkoutForm">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullname" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" id="email" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" class="form-control" id="phone" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Address</label>
              <textarea class="form-control" id="address" rows="2" required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Payment Method</label>
              <select class="form-select" id="payment" required>
                <option value="Cash on Delivery">Cash on Delivery</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
              </select>
            </div>

            <button type="submit" class="btn btn-success w-100 mt-3">Place Order</button>
          </form>
        </div>
      </div>

      <!-- RIGHT SIDE ORDER SUMMARY -->
      <div class="col-md-5">
        <div class="card shadow-sm p-4">
          <h5 class="fw-bold mb-3">Order Summary</h5>

          <ul id="orderItems" class="list-group mb-3"></ul>

          <h5 class="text-end fw-bold">
            Total: ₹<span id="orderTotal">0</span>
          </h5>
        </div>
      </div>

    </div>
  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<!-- 🟢 SWEETALERT + VALIDATION + ORDER SCRIPT -->
<script>
$(document).ready(function () {
  loadCart();

  // ===========================
  // LOAD CART ITEMS IN SUMMARY
  // ===========================
  function loadCart() {
    $.ajax({
      url: "../Controllers/CartController.php?UserId=" + localStorage.getItem("UserId"),
      method: "GET",

      success: function (res) {
        try { res = JSON.parse(res); } 
        catch (e) {
          Swal.fire("Error", "Invalid response from server!", "error");
          return;
        }

        if (res.Status !== "Ok" && res.Status !== "OK") {
          $("#orderItems").html(`
            <li class='list-group-item text-center text-muted'>Your cart is empty</li>
          `);
          $("#orderTotal").text("0");
          return;
        }

        let total = 0;
        $("#orderItems").empty();

        res.Result.forEach(item => {
          let price = item.discount_price > 0 ? item.discount_price : item.price;
          let subtotal = price * item.quantity;
          total += subtotal;

          $("#orderItems").append(`
            <li class="list-group-item d-flex justify-content-between align-items-center">
              ${item.product_name} × ${item.quantity}
              <span>₹${subtotal}</span>
            </li>
          `);
        });

        $("#orderTotal").text(total);
      },

      error: function () {
        Swal.fire("Error", "Unable to load cart items!", "error");
      }
    });
  }

  // ===========================
  // FORM VALIDATION
  // ===========================
  function validateForm(data) {

    if (!data.fullname.trim()) {
      Swal.fire("Missing Info", "Please enter full name.", "warning");
      return false;
    }

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(data.email)) {
      Swal.fire("Invalid Email", "Please enter a valid email.", "warning");
      return false;
    }

    let phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(data.phone)) {
      Swal.fire("Invalid Phone", "Phone number must be 10 digits.", "warning");
      return false;
    }

    if (!data.address.trim()) {
      Swal.fire("Missing Address", "Please enter address.", "warning");
      return false;
    }

    return true;
  }

  // ===========================
  // PLACE ORDER
  // ===========================
  $("#checkoutForm").on("submit", function (e) {
    e.preventDefault();

    const orderData = {
      fullname: $("#fullname").val(),
      email: $("#email").val(),
      phone: $("#phone").val(),
      address: $("#address").val(),
      payment: $("#payment").val(),
      userId: localStorage.getItem("UserId")
    };

    // Validate fields
    if (!validateForm(orderData)) return;

    // Confirm order before placing
    Swal.fire({
      title: "Confirm Order?",
      html: `
        <b>${orderData.fullname}</b><br>
        Payment method: <b>${orderData.payment}</b><br><br>
        Do you want to place this order?
      `,
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Place Order",
    }).then((result) => {

      if (result.isConfirmed) {

        $.ajax({
          url: "../Controllers/OrderController.php",
          method: "POST",
          contentType: "application/json",
          data: JSON.stringify(orderData),

          success: function (res) {

            try { res = JSON.parse(res); } catch (e) {}

            if (res.Status === "OK") {
              Swal.fire({
                icon: "success",
                title: "Order Placed!",
                text: "Your order has been placed successfully.",
                confirmButtonColor: "#28a745",
              }).then(() => {
                window.location.href = "order_list.php?orderid=" + res.OrderID;
              });
            } else {
              Swal.fire("Error", res.Message || "Failed to place order", "error");
            }
          },

          error: function () {
            Swal.fire("Error", "Cannot place order right now, please try again.", "error");
          }
        });

      }

    });

  });

});
</script>
