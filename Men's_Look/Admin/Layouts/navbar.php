<!-- ✅ Block access if NOT logged in -->
<script>
  if (!localStorage.getItem("adminToken")) {
    window.location.href = "AdminLogin.php";
  }
</script>

<!-- ✅ Include Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- ✅ Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header text-center py-4">
    <h5 id="sidebarName" class="mt-2 text-white fw-bold mb-0">Admin</h5>
    <p id="sidebarUser" class="text-light small opacity-75 mb-0">@username</p>
  </div>

  <hr class="text-white opacity-25">

  <a href="Dashboard.php" class="sidebar-link"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
  <a href="ManageCategory.php" class="sidebar-link"><i class="bi bi-tags me-2"></i> Categories</a>
  <a href="ProductMaster.php" class="sidebar-link"><i class="bi bi-bag-check me-2"></i> Products</a>
  <a href="manage_orders.php" class="sidebar-link"><i class="bi bi-box-seam me-2"></i> Orders</a>
  <a href="manage_contact.php" class="sidebar-link"><i class="bi bi-envelope-paper me-2"></i> Contact Messages</a>
  <a href="ManageBlog.php" class="sidebar-link"><i class="bi bi-journal-text me-2"></i> Blogs</a>
  <a href="Customers.php" class="sidebar-link"><i class="bi bi-people me-2"></i> Customers</a>
  <a href="Profile.php" class="sidebar-link"><i class="bi bi-gear me-2"></i> Settings</a>

  <hr class="text-white opacity-25 mt-4 mb-3">
  <a href="#" id="logoutBtn" class="sidebar-link text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
</div>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient shadow-sm" id="topNavbar">
  <div class="container-fluid px-4">
    <button class="btn btn-outline-light btn-sm" id="toggleSidebar"><i class="bi bi-list"></i></button>
    <span class="navbar-brand ms-3 fw-bold">Admin Dashboard</span>
  </div>
</nav>

<!-- ✅ Logout Popup -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-box-arrow-right"></i> Confirm Logout</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-muted">Are you sure you want to log out?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmLogout">Logout</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ MAIN JAVASCRIPT -->
<script>
$(document).ready(function(){

  // 🧩 If token missing → force logout
  if (!localStorage.getItem("adminToken")) {
    localStorage.clear();
    window.location.href = "AdminLogin.php";
  }

  // 🧩 Sidebar toggle
  $("#toggleSidebar").click(function(){
    $("#sidebar").toggleClass("collapsed");
  });

  // 🧩 Load admin info from localStorage
  const adminName = localStorage.getItem("adminName");
  const adminUser = localStorage.getItem("adminUser");

  if (!adminName || !adminUser) {
    localStorage.clear();
    window.location.href = "AdminLogin.php";
  }

  $("#sidebarName").text(adminName);
  $("#sidebarUser").text("@" + adminUser);

  // 🧩 Logout popup
  $("#logoutBtn").click(function(){
    $("#logoutModal").modal("show");
  });

  // 🧩 Confirm logout
  $("#confirmLogout").click(function(){
    localStorage.clear();
    window.location.href = "AdminLogin.php";
  });

});
</script>

<!-- 🎨 STYLING -->
<style>
/* 🎨 SIDEBAR */
.sidebar {
  background: linear-gradient(180deg, #072E33, #0E8388);
  color: white;
  position: fixed;
  width: 260px;
  height: 100vh;
  overflow-y: auto;
  transition: all 0.3s ease;
  z-index: 100;
}
.sidebar.collapsed {
  width: 80px;
}
.sidebar-link {
  display: block;
  padding: 10px 15px;
  margin: 4px 0;
  border-radius: 8px;
  font-size: 15px;
  transition: all 0.25s ease;
}
.sidebar-link:hover {
  background: rgba(255,255,255,0.15);
  transform: translateX(5px);
}
.sidebar.collapsed .sidebar-link {
  text-align: center;
  padding: 10px 0;
}
.sidebar.collapsed .sidebar-link i {
  margin-right: 0;
}

/* 🎨 NAVBAR */
#topNavbar {
  background: linear-gradient(90deg, #0E8388, #072E33);
  padding: 10px 20px;
}

/* 🎨 POPUP */
.modal-content {
  border-radius: 15px;
  animation: fadeIn 0.3s ease;
}
@keyframes fadeIn {
  from {opacity: 0; transform: scale(0.9);}
  to {opacity: 1; transform: scale(1);}
}

/* Scrollbar */
.sidebar::-webkit-scrollbar {
  width: 6px;
}
.sidebar::-webkit-scrollbar-thumb {
  background: rgba(255,255,255,0.3);
  border-radius: 10px;
}
</style>
