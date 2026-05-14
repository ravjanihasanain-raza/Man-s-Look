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

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-success"><i class="bi bi-people-fill"></i> Manage Customers</h3>
      <button class="btn btn-outline-primary btn-sm" id="refreshCustomers"><i class="bi bi-arrow-repeat"></i> Refresh</button>
    </div>

    <!-- ✅ Table Container -->
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-3 flex-wrap">
          <div>
            <input type="text" id="searchCustomer" class="form-control form-control-sm" placeholder="🔍 Search customer..." style="width:220px;">
          </div>
          <div class="text-end small text-muted mt-2 mt-sm-0">
            Total Customers: <span id="customerCount">--</span>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle text-center">
            <thead class="table-success">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Registered</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="customerTable">
              <tr><td colspan="7" class="text-muted py-3">Loading customers...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ View Details Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Customer Details</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="customerDetail">
        <p class="text-center text-muted">Loading...</p>
      </div>
    </div>
  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<script>
$(document).ready(function(){
  loadCustomers();

  $("#refreshCustomers").click(loadCustomers);
  $("#searchCustomer").on("keyup", function(){
    let val = $(this).val().toLowerCase();
    $("#customerTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
    });
  });
});

// ✅ Load all customers
function loadCustomers(){
  $("#customerTable").html(`<tr><td colspan="7" class="text-muted py-3">Loading customers...</td></tr>`);
  $.ajax({
    url: "../Controllers/CustomerController.php",
    method: "GET",
    success: function(res){
      res = JSON.parse(res);
      if(res.Status !== "OK" || !res.Result || res.Result.length === 0){
        $("#customerTable").html(`<tr><td colspan="7" class="text-muted py-3">No customers found</td></tr>`);
        $("#customerCount").text("0");
        return;
      }

      $("#customerCount").text(res.Result.length);
      $("#customerTable").empty();

      res.Result.forEach((c, i) => {
        $("#customerTable").append(`
          <tr>
            <td>${i + 1}</td>
            <td>${c.name}</td>
            <td>${c.email}</td>
            <td>${c.MobileNo ?? '-'}</td>
            <td>${new Date(c.created_at).toLocaleDateString()}</td>
            <td>
              <select class="form-select form-select-sm w-auto mx-auto" onchange="updateStatus(${c.id}, this.value)">
                <option value="Active" ${c.status === 'Active' ? 'selected' : ''}>Active</option>
                <option value="Inactive" ${c.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
              </select>
            </td>
            <td>
              <button class="btn btn-sm btn-info text-white" onclick="viewCustomer(${c.id})"><i class="bi bi-eye"></i></button>
              <button class="btn btn-sm btn-danger" onclick="deleteCustomer(${c.id})"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        `);
      });
    },
    error: function(){
      $("#customerTable").html(`<tr><td colspan="7" class="text-danger">⚠️ Error loading customers</td></tr>`);
    }
  });
}

// ✅ View Details
function viewCustomer(id){
  $("#customerDetail").html(`<p class="text-center text-muted">Loading...</p>`);
  const modal = new bootstrap.Modal(document.getElementById("customerModal"));
  modal.show();

  $.ajax({
    url: "../Controllers/CustomerController.php?ID=" + id,
    method: "GET",
    success: function(res){
      res = JSON.parse(res);
      if(res.Status !== "OK" || !res.Result){
        $("#customerDetail").html(`<p class="text-danger text-center">Customer not found</p>`);
        return;
      }
      const c = res.Result;
      $("#customerDetail").html(`
        <ul class="list-group">
          <li class="list-group-item"><strong>Name:</strong> ${c.name}</li>
          <li class="list-group-item"><strong>Email:</strong> ${c.email}</li>
          <li class="list-group-item"><strong>Mobile:</strong> ${c.MobileNo ?? '-'}</li>
          <li class="list-group-item"><strong>Status:</strong> ${c.status}</li>
          <li class="list-group-item"><strong>Joined:</strong> ${new Date(c.created_at).toLocaleString()}</li>
        </ul>
      `);
    }
  });
}

// ✅ Update Status
function updateStatus(id, status){
  $.ajax({
    url: "../Controllers/CustomerController.php",
    method: "PUT",
    contentType: "application/json",
    data: JSON.stringify({ id: id, status: status }),
    success: function(res){
      res = JSON.parse(res);
      if(res.Status === "OK") alert("✅ " + res.Result);
      else alert("❌ " + res.Result);
    }
  });
}

// ✅ Delete Customer
function deleteCustomer(id){
  if(!confirm("Are you sure to delete this customer?")) return;

  $.ajax({
    url: "../Controllers/CustomerController.php?ID=" + id,
    method: "DELETE",
    success: function(res){
      res = JSON.parse(res);
      alert(res.Result);
      loadCustomers();
    }
  });
}
</script>

<style>
.table th {
  white-space: nowrap;
}
.table td {
  vertical-align: middle;
}
select.form-select {
  min-width: 100px;
}
.btn-sm i {
  font-size: 14px;
}
.activity-card {
  transition: 0.3s;
}
.activity-card:hover {
  transform: scale(1.02);
}
</style>
