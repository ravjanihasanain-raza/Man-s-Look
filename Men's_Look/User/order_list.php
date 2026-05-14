<?php
include "Layouts/_Header.php";
include "Layouts/navbar.php";
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4 text-center">📦 My Orders</h2>

  <div class="table-responsive shadow-sm bg-white rounded p-3">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Full Name</th>
          <th>Address</th>
          <th>Payment</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="orderTableBody">
        <tr>
          <td colspan="6" class="text-center text-muted py-3">Loading orders...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- 🧾 Modal for Order Details -->
  <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderDetailsLabel">Order Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered text-center">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody id="orderItemsBody">
              <tr>
                <td colspan="4" class="text-muted">Loading...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const userId = localStorage.getItem("UserId"); // Or dynamically from session/localStorage

    // ✅ Load user orders
    fetch(`../Controllers/OrderController.php?user_id=${userId}&Choice=UserOrder`, {
        method: 'GET',
        credentials: 'include'
      })
      .then(res => res.json())
      .then(data => {
        const tableBody = document.getElementById('orderTableBody');
        tableBody.innerHTML = '';

        if (data.Status === "Fail") {
          tableBody.innerHTML = `<tr><td colspan="6" class="text-danger py-3">${data.Result}</td></tr>`;
          return;
        }

        console.log(data);

        const orders = data.Result;
        if (!orders || orders.length === 0) {
          tableBody.innerHTML = `<tr><td colspan="6" class="text-muted py-3">No orders found.</td></tr>`;
          return;
        }


        orders.forEach((order, index) => {
          const row = `
          <tr>
            <td>${index + 1}</td>
            <td>${order.fullname}</td>
            <td>${order.address}</td>
            <td>${order.payment_method}</td>
            <td>${order.order_date}</td>
            <td>
              <button class="btn btn-sm btn-primary" onclick="viewOrderDetails(${order.order_id})">
                View Details
              </button>
            </td>
          </tr>`;
          tableBody.insertAdjacentHTML('beforeend', row);
        });
      })
      .catch(err => {
        console.error(err);
        document.getElementById('orderTableBody').innerHTML =
          `<tr><td colspan="6" class="text-danger text-center py-3">Failed to load orders.</td></tr>`;
      });
  });


  // 🧾 View Order Details Function
  function viewOrderDetails(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
    const tableBody = document.getElementById('orderItemsBody');
    tableBody.innerHTML = `<tr><td colspan="4" class="text-muted py-3">Loading...</td></tr>`;

    fetch(`../Controllers/GetOrderDetails.php?order_id=${orderId}`)
      .then(res => res.json())
      .then(data => {
        tableBody.innerHTML = '';
        console.log(data);
        if (data.Status !== "OK" || data.Result.length === 0) {
          tableBody.innerHTML = `<tr><td colspan="4" class="text-muted py-3">No items found.</td></tr>`;
          return;
        }

        data.Result.forEach(item => {
          const row = `
          <tr>
            <td>${item.product_name}</td>
            <td><img src="../Content/Photo/${item.image_url}" width="60" class="rounded shadow-sm" /></td>
            <td>${item.quantity}</td>
            <td>₹${item.price}</td>
          </tr>
        `;
          tableBody.insertAdjacentHTML('beforeend', row);
        });
      })
      .catch(err => {
        console.error(err);
        tableBody.innerHTML = `<tr><td colspan="4" class="text-danger">Error loading details</td></tr>`;
      });

    modal.show();
  }
</script>

<?php include "Layouts/_Footer.php"; ?>