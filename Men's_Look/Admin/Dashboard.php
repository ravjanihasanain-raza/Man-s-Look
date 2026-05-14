<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>
<style>
/* ✅ Layout Alignment Fix */
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
  
  color: #ffffffff;
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

/* ✅ Charts Auto Height */
.chart-container {
  position: relative;
  height: calc(100vh - 420px);
  min-height: 280px;
  width: 100%;
}

/* ✅ Responsive Fix */
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

    <!-- ✅ Welcome Banner -->
    <div class="alert alert-success text-center shadow-sm fade show" role="alert" id="welcomeAlert" style="display:none;">
      👋 Welcome back, <strong>Admin!</strong> Here’s your business summary.
    </div>

    <!-- ✅ Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-success">📊 Admin Dashboard</h2>
      <button class="btn btn-outline-primary btn-sm" id="refreshDashboard">
        <i class="bi bi-arrow-repeat"></i> Refresh
      </button>
    </div>

    <!-- ✅ Stats Cards -->
    <div class="row g-4" id="dashboardStats"></div>

    <!-- ✅ Charts Section -->
    <div class="row mt-5 g-4">
      <div class="col-lg-6">
        <div class="card shadow-sm p-3 h-100">
          <h5 class="text-center fw-bold text-success mb-3">📦 Orders Overview</h5>
          <div class="chart-container">
            <canvas id="orderChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card shadow-sm p-3 h-100">
          <h5 class="text-center fw-bold text-success mb-3">🛍️ Product vs Blog Ratio</h5>
          <div class="chart-container">
            <canvas id="dataChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Recent Activity Section -->
    <div class="mt-5">
      <h4 class="fw-bold text-success mb-3">🕓 Recent Activities</h4>
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="card shadow-sm activity-card">
            <div class="card-header bg-primary text-white">
              <i class="bi bi-cart-check"></i> Latest Orders
            </div>
            <div class="card-body p-2" id="recentOrders">
              <p class="text-muted text-center mb-0">Loading...</p>
            </div>
            <div class="card-footer text-center bg-light">
              <a href="manage_orders.php" class="btn btn-outline-primary btn-sm">View All Orders</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm activity-card">
            <div class="card-header bg-success text-white">
              <i class="bi bi-person-circle"></i> New Customers
            </div>
            <div class="card-body p-2" id="recentCustomers">
              <p class="text-muted text-center mb-0">Loading...</p>
            </div>
            <div class="card-footer text-center bg-light">
              <a href="Customers.php" class="btn btn-outline-success btn-sm">View All Customers</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm activity-card">
            <div class="card-header bg-danger text-white">
              <i class="bi bi-journal-text"></i> Recent Blogs
            </div>
            <div class="card-body p-2" id="recentBlogs">
              <p class="text-muted text-center mb-0">Loading...</p>
            </div>
            <div class="card-footer text-center bg-light">
              <a href="ManageBlog.php" class="btn btn-outline-danger btn-sm">View All Blogs</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<!-- ✅ Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function () {
  loadDashboard();
  $("#welcomeAlert").fadeIn(600).delay(3000).fadeOut(1000);
  $("#refreshDashboard").click(loadDashboard);
});

function loadDashboard() {
  $.ajax({
    url: "../Controllers/DashboardController.php",
    method: "GET",
    success: function (res) {
      res = JSON.parse(res);

      // ✅ Cards
      $("#dashboardStats").html(`
        ${makeCard("bi-box-seam", "Products", res.products, "text-success", "ProductMaster.php")}
        ${makeCard("bi-tags-fill", "Categories", res.categories, "text-primary", "ManageCategory.php")}
        ${makeCard("bi-cart-check-fill", "Orders", res.orders, "text-warning", "manage_orders.php")}
        ${makeCard("bi-people-fill", "Customers", res.customers, "text-info", "Customers.php")}
        ${makeCard("bi-journal-richtext", "Blogs", res.blogs, "text-danger", "ManageBlog.php")}
      `);

      // ✅ Render charts
      renderOrderChart(res.orderStats ?? []);
      renderDataChart(res.products ?? 0, res.blogs ?? 0);

      // ✅ Recent Data
      renderList("#recentOrders", res.recentOrders, "No recent orders found", "fullname", "order_date");
      renderList("#recentCustomers", res.recentCustomers, "No new customers", "name", "email");
      renderList("#recentBlogs", res.recentBlogs, "No blogs available", "Title", "Category");
    },
    error: () => $("#dashboardStats").html(`<div class='col-12 text-center text-danger'>⚠️ Failed to load data.</div>`),
  });
}

function makeCard(icon, title, count, color, link) {
  return `
    <div class="col-sm-6 col-md-4 col-lg-2">
      <div class="card stat-card shadow-sm border-0" onclick="window.location.href='${link}'">
        <div class="card-body text-center">
          <i class="bi ${icon} display-6 ${color}"></i>
          <h6 class="mt-2 text-muted">${title}</h6>
          <h4 class="fw-bold">${count ?? 0}</h4>
        </div>
      </div>
    </div>
  `;
}

function renderList(selector, data, emptyMsg, mainKey, subKey) {
  const container = $(selector);
  container.empty();

  if (!data || data.length === 0) {
    container.html(`<p class="text-muted text-center mb-0">${emptyMsg}</p>`);
    return;
  }

  data.slice(0, 5).forEach((item) => {
    container.append(`
      <div class="d-flex justify-content-between border-bottom py-1 small">
        <span>${item[mainKey]}</span>
        <span class="text-muted">${item[subKey]}</span>
      </div>
    `);
  });
}

// ✅ Charts
function renderOrderChart(orderData) {
  const ctx = document.getElementById("orderChart").getContext("2d");
  if (window.orderChartInstance) window.orderChartInstance.destroy();

  window.orderChartInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
      datasets: [
        {
          label: "Orders This Week",
          data: orderData.length ? orderData : [10, 15, 8, 18, 12, 20, 9],
          borderColor: "#198754",
          backgroundColor: "rgba(25, 135, 84, 0.2)",
          tension: 0.4,
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: "top" },
        tooltip: { mode: "index", intersect: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    },
  });
}

function renderDataChart(products, blogs) {
  const ctx = document.getElementById("dataChart").getContext("2d");
  if (window.dataChartInstance) window.dataChartInstance.destroy();

  window.dataChartInstance = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Products", "Blogs"],
      datasets: [
        {
          data: [products, blogs],
          backgroundColor: ["#0d6efd", "#dc3545"],
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: "top" },
      }
    },
  });
}
</script>

<style>
.stat-card {
  border-radius: 10px;
  transition: all 0.3s ease;
  cursor: pointer;
}
.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}
.activity-card {
  height: 100%;
  transition: 0.3s;
}
.activity-card:hover {
  transform: scale(1.02);
}
#welcomeAlert {
  max-width: 600px;
  margin: 0 auto;
}
.chart-container {
  position: relative;
  height: 300px;
  width: 100%;
}
@media (max-width: 768px) {
  .chart-container {
    height: 250px;
  }
}
.card canvas {
  max-width: 100%;
  height: 100% !important;
}
</style>
