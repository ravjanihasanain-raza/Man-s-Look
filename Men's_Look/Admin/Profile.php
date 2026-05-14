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
  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-success"><i class="bi bi-person-circle"></i> Admin Profile</h3>
    </div>

    <div class="row g-4">
      <!-- ✅ Profile Card -->
      <div class="col-lg-4">
        <div class="card shadow-sm text-center p-3">
          <img id="adminPhoto" src="../Content/Photo/default-avatar.png" 
               class="rounded-circle mx-auto mb-3" width="120" height="120" style="object-fit:cover;">
          <h5 id="adminName" class="fw-bold text-success">Loading...</h5>
          <p id="adminEmail" class="text-muted small"></p>
          <button class="btn btn-outline-success btn-sm mt-2" 
                  data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil"></i> Edit Profile
          </button>
        </div>
      </div>

      <!-- ✅ Account Details -->
      <div class="col-lg-8">
        <div class="card shadow-sm p-4">
          <h5 class="fw-bold mb-3 text-success"><i class="bi bi-gear"></i> Account Details</h5>
          <div id="profileDetails" class="text-muted">Loading...</div>

          <hr>
          <h6 class="fw-bold text-danger mb-3"><i class="bi bi-key"></i> Change Password</h6>
          <form id="changePasswordForm">
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Current Password</label>
                <input type="password" id="currentPassword" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label>New Password</label>
                <input type="password" id="newPassword" class="form-control" required>
              </div>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-save"></i> Update Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Edit Profile</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editProfileForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" id="editName" class="form-control">
          </div>
          <div class="mb-3">
            <label>Username</label>
            <input type="text" id="editUsername" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label>Phone</label>
            <input type="text" id="editPhone" class="form-control">
          </div>
          <div class="mb-3">
            <label>Profile Picture</label>
            <input type="file" id="editPhoto" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="saveProfile"><i class="bi bi-save"></i> Save Changes</button>
      </div>
    </div>
  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<script>
$(document).ready(function(){
  loadAdminProfile();

  // 🖼️ Image preview
  $("#editPhoto").on("change", function(e){
    const file = e.target.files[0];
    if(file){
      const reader = new FileReader();
      reader.onload = (ev) => $("#adminPhoto").attr("src", ev.target.result);
      reader.readAsDataURL(file);
    }
  });

  // ✅ Save profile changes
  $("#saveProfile").click(function(){
    const data = {
      FullName: $("#editName").val(),
      phone: $("#editPhone").val(),
      base64Photo: $("#adminPhoto").attr("src")
    };

    $.ajax({
      url: "../Controllers/AdminProfileController.php",
      method: "PUT",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function(res){
        res = JSON.parse(res);
        alert(res.Result);
        $("#editProfileModal").modal("hide");
        loadAdminProfile();
      },
      error: function(){
        alert("Error updating profile");
      }
    });
  });

  // ✅ Change password
  $("#changePasswordForm").submit(function(e){
    e.preventDefault();
    const data = {
      currentPassword: $("#currentPassword").val(),
      newPassword: $("#newPassword").val()
    };

    $.ajax({
      url: "../Controllers/AdminProfileController.php",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function(res){
        res = JSON.parse(res);
        alert(res.Result);
        $("#changePasswordForm")[0].reset();
      },
      error: function(){
        alert("Error changing password");
      }
    });
  });
});

// ✅ Load Admin Profile Data
function loadAdminProfile(){
  $.ajax({
    url: "../Controllers/AdminProfileController.php",
    method: "GET",
    success: function(res){
      try {
        res = JSON.parse(res);
      } catch (e) {
        console.error("Invalid JSON:", res);
        return;
      }

      const admin = res.Result;

      $("#adminName").text(admin.FullName);
      $("#adminEmail").text(admin.UserName);
      $("#adminPhoto").attr("src", admin.photo ? "../Content/Photo/" + admin.photo : "../Content/Photo/default-avatar.png");

      $("#editName").val(admin.FullName);
      $("#editUsername").val(admin.UserName);
      $("#editPhone").val(admin.phone ?? "");

      $("#profileDetails").html(`
        <ul class="list-group">
          <li class="list-group-item"><strong>Username:</strong> ${admin.UserName}</li>
          <li class="list-group-item"><strong>Phone:</strong> ${admin.phone ?? '-'}</li>
        </ul>
      `);
    },
    error: function(){
      $("#profileDetails").html("<p class='text-danger'>Error loading profile data.</p>");
    }
  });
}
</script>

<style>
#adminPhoto {
  border: 4px solid #198754;
  padding: 3px;
}
.card {
  border-radius: 10px;
}
.card h5, .card h6 {
  color: #198754;
}
.list-group-item {
  font-size: 14px;
}
</style>
