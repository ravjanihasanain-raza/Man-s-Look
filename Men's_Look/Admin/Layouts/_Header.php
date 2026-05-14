<!-- ✅ Header (Topbar) -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" id="adminHeader">
  <div class="container-fluid px-4">
    <!-- Sidebar Toggle Button -->
    <button class="btn btn-outline-light btn-sm" id="toggleSidebar">
      <i class="bi bi-list"></i>
    </button>

    <!-- Brand Title -->
    <a class="navbar-brand ms-3 fw-bold" href="Dashboard.php">
      <i class="bi bi-speedometer2"></i> Men’s Look Admin
    </a>

    <!-- Admin Profile Info -->
    <!-- <div class="ms-auto d-flex align-items-center">
      <img id="headerAdminPhoto" src="../Content/Photo/default-avatar.png"
           class="rounded-circle me-2 border border-light shadow-sm"
           width="36" height="36" style="object-fit:cover;">
      <span id="headerAdminName" class="text-white fw-semibold"></span>
    </div> -->
  </div>
</nav>

<!-- ✅ Script -->
<script>
$(document).ready(function(){
  // 🟢 Load Admin Info from LocalStorage
  const adminName = localStorage.getItem("adminName") || "Admin";
  const adminPhoto = localStorage.getItem("adminPhoto") || "default-avatar.png";

  // $("#headerAdminName").text(adminName);
  // $("#headerAdminPhoto").attr("src", "../Content/Photo/" + adminPhoto);

  // 🟢 Sidebar Toggle
  $("#toggleSidebar").click(function(){
    $("#sidebar").toggleClass("collapsed");
    $("#content").toggleClass("expanded");
    $("#footer").toggleClass("expanded");
    $("#adminHeader").toggleClass("expanded");
  });
});
</script>

<!-- ✅ Style -->
<style>
#adminHeader {
  position: fixed;
  top: 0;
  left: 260px;
  right: 0;
  height: 60px;
  z-index: 1000;
  background: linear-gradient(90deg, #0E8388, #072E33);
  box-shadow: 0 3px 10px rgba(0,0,0,0.3);
  transition: all 0.3s ease;
}

#adminHeader.expanded {
  left: 80px;
}

#adminHeader .navbar-brand {
  color: #fff !important;
  font-weight: 600;
  letter-spacing: 0.5px;
}

#adminHeader .btn-outline-light {
  border-color: rgba(255,255,255,0.4);
}

#adminHeader .btn-outline-light:hover {
  background-color: rgba(255,255,255,0.2);
}

#headerAdminPhoto {
  border: 2px solid #fff;
}

@media (max-width: 768px) {
  #adminHeader {
    left: 0 !important;
  }
}

.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  width: 250px;
  height: 100vh;
  background: var(--sidebar-bg);
  color: var(--sidebar-text);
  box-shadow: 2px 0 10px rgba(0,0,0,0.08);
  padding-top: 60px;
  display: flex;
  flex-direction: column;
  transition: all 0.3s ease;
  z-index: 999;
}

/* 🧩 Sidebar Links */
.sidebar a {
  color: var(--sidebar-text);
  text-decoration: none;
  display: block;
  padding: 12px 20px;
  font-size: 15px;
  border-radius: 8px;
  margin: 4px 10px;
  transition: all 0.25s ease;
}

.sidebar a:hover {
  background: var(--sidebar-hover);
  color: #0E8388;
  transform: translateX(4px);
}

.sidebar a i {
  color: #0E8388;
}

/* 🧩 Collapsed Sidebar */
.sidebar.collapsed {
  width: 80px;
  overflow: hidden;
}

.sidebar.collapsed a {
  text-align: center;
  padding: 12px 0;
}

.sidebar.collapsed a i {
  margin-right: 0;
}

/* 🧩 Logout Link */
.logout-link {
  color: var(--logout-color);
  font-weight: 600;
  display: inline-block;
  transition: all 0.3s ease;
}

.logout-link:hover {
  background: rgba(220, 53, 69, 0.1);
  color: var(--logout-color);
  transform: translateY(-2px);
  border-radius: 8px;
}

/* 🧩 Profile Section */
.sidebar-header img {
  border: 2px solid #0E8388;
  transition: 0.3s;
}
.sidebar-header img:hover {
  transform: scale(1.05);
}

/* 🧩 Mobile Responsive */
@media (max-width: 768px) {
  .sidebar {
    width: 0;
    overflow: hidden;
  }
}
.sidebar a i {
  color: var(--icon-color);
  transition: color 0.3s ease, transform 0.2s ease;
}
</style>
