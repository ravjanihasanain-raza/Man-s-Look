<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

<!-- ✅ Manage Orders Page -->
<div class="content" id="content">
  <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-success">
        <i class="bi bi-cart4 me-2"></i> Manage Orders
      </h2>
      <button class="btn btn-outline-success btn-sm" id="refreshOrders">
        <i class="bi bi-arrow-repeat"></i> Refresh
      </button>
    </div>

    <!-- ✅ Orders Table -->
    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-container">
          <table class="table align-middle text-center table-hover mb-0">
            <thead class="table-success text-dark sticky-top">
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="adminOrderTable">
              <tr>
                <td colspan="8" class="text-muted py-3">Loading orders...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- ✅ Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-receipt-cutoff me-2"></i> Order Details
        </h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="table-responsive">
          <table class="table table-bordered text-center">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Qty</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody id="adminOrderDetails">
              <tr>
                <td colspan="4" class="text-muted py-3">Loading...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ JS Logic -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  loadOrders();
  document.getElementById("refreshOrders").addEventListener("click", loadOrders);
});

/* ---------------- Load Orders ---------------- */
function loadOrders() {
  fetch('../Controllers/OrderController.php?Choice=AdminOrder')
    .then(res => res.json())
    .then(data => {
      const table = document.getElementById('adminOrderTable');
      table.innerHTML = '';

      if (data.Status !== "OK" || !data.Result?.length) {
        table.innerHTML = `<tr><td colspan="8" class="text-muted py-3">No orders found</td></tr>`;
        return;
      }

      data.Result.forEach((o, i) => {
        table.insertAdjacentHTML('beforeend', `
          <tr>
            <td>${i + 1}</td>
            <td>${o.fullname}</td>
            <td>${o.email}</td>
            <td>${o.phone}</td>
            <td>${o.payment_method}</td>

            <!-- 🔥 Status Dropdown -->
            <td>
              <select class="form-select form-select-sm fw-bold"
                      onchange="adminChangeStatus(${o.order_id}, this.value)"
                      style="min-width:120px;">
                <option value="Pending"   ${o.status === "Pending" ? "selected" : ""}>Pending</option>
                <option value="Shipped"   ${o.status === "Shipped" ? "selected" : ""}>Shipped</option>
                <option value="Delivered" ${o.status === "Delivered" ? "selected" : ""}>Delivered</option>
                <option value="Cancelled" ${o.status === "Cancelled" ? "selected" : ""}>Cancelled</option>
              </select>
            </td>

            <td>${o.order_date}</td>

            <td>
              <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-outline-primary" onclick="viewDetails(${o.order_id})">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </td>
          </tr>
        `);
      });
    })
    .catch(err => {
      console.error(err);
      document.getElementById('adminOrderTable').innerHTML =
        `<tr><td colspan="8" class="text-danger py-3">⚠️ Failed to load orders.</td></tr>`;
    });
}

/* ---------------- Update Status ---------------- */
function adminChangeStatus(orderId, newStatus) {
  fetch('../Controllers/AdminOrderController.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ order_id: orderId, status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
      if (data.Status === "OK") {
        showToast("✅ Status Updated to: " + newStatus, "success");
        loadOrders();
      } else {
        showToast("❌ Failed: " + data.Result, "danger");
      }
    })
    .catch(() => showToast("⚠️ Server error", "danger"));
}

/* ---------------- View Details ---------------- */
function viewDetails(orderId) {
  const modal = new bootstrap.Modal(document.getElementById('orderModal'));
  const body = document.getElementById('adminOrderDetails');
  body.innerHTML = `<tr><td colspan="4" class="text-muted py-3">Loading...</td></tr>`;

  fetch(`../Controllers/GetOrderDetails.php?order_id=${orderId}`)
    .then(res => res.json())
    .then(data => {
      body.innerHTML = '';

      if (data.Status !== "OK" || !data.Result?.length) {
        body.innerHTML = `<tr><td colspan="4" class="text-muted py-3">No items found.</td></tr>`;
        return;
      }

      data.Result.forEach(item => {
        body.insertAdjacentHTML('beforeend', `
          <tr>
            <td>${item.product_name}</td>
            <td><img src="../Content/Photo/${item.image_url}" width="60" class="rounded shadow-sm" /></td>
            <td>${item.quantity}</td>
            <td>₹${item.price}</td>
          </tr>
        `);
      });
    })
    .catch(() => {
      body.innerHTML = `<tr><td colspan="4" class="text-danger py-3">Error loading details.</td></tr>`;
    });

  modal.show();
}

/* ---------------- Toast ---------------- */
function showToast(message, type = "info") {
  const toast = document.createElement("div");
  toast.className = `toast align-items-center text-bg-${type} border-0 show position-fixed top-0 end-0 m-3 shadow`;
  toast.role = "alert";
  toast.innerHTML = `<div class="d-flex">
    <div class="toast-body">${message}</div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
  </div>`;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}
</script>

<style>
/* Layout Fix */
#content {
  margin-left: 260px;
  margin-top: 70px;
}
#content.expanded {
  margin-left: 80px;
}

/* Scrollable table */
.table-container {
  max-height: calc(100vh - 220px);
  overflow-y: auto;
}

/* Sticky header */
.table-container thead th {
  position: sticky;
  top: 0;
  z-index: 10;
}

/* Hover */
.table-hover tbody tr:hover {
  background-color: rgba(14,131,136,0.05);
}
</style>

<?php include "Layouts/_Footer.php"; ?>
