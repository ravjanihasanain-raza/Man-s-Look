<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

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

.main-content {
  margin-left: 260px;
  margin-top: 70px;
  padding: 20px;
  transition: margin-left 0.3s ease;
}

.main-content.expanded {
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
  .main-content {
    margin-left: 0 !important;
  }
}
</style>

<div class="main-content">
  <div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>📝 Manage Blogs</h3>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#blogModal">+ Add Blog</button>
    </div>

    <div class="card shadow">
      <div class="card-body">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Author</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="blogs"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Blog Modal -->
<div class="modal fade" id="blogModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Add / Edit Blog</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <form id="blogForm">
          <input type="hidden" id="blog_id" value="0">

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Title</label>
              <input type="text" id="title" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Author</label>
              <input type="text" id="author" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label>Category</label>
            <input type="text" id="category" class="form-control">
          </div>

          <div class="mb-3">
            <label>Content</label>
            <textarea id="blog_content" class="form-control" rows="6"></textarea>
          </div>

          <div class="row align-items-center mb-3">
            <div class="col-md-8">
              <label>Image</label>
              <input type="file" id="Photo" class="form-control">
            </div>

            <div class="col-md-4 text-center">
              <img id="previewImage" src="" class="img-thumbnail" style="max-width:120px; display:none;">
            </div>
          </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" id="btnSaveBlog" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<script>
$(document).ready(function() {
  loadBlogs();
});

let base64String = "";

/* Convert Image to Base64 */
$('#Photo').on('change', function(e) {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function(event) {
    base64String = event.target.result;
    $("#previewImage").attr("src", base64String).show();
  };
  reader.readAsDataURL(file);
});

/* Load Blogs */
function loadBlogs() {
  $("#blogs").empty();

  $.ajax({
    url: "../Controllers/BlogController.php",
    method: "GET",
    success: function(res) {
      res = JSON.parse(res);

      res.Result.map((b) => {
        let img = b.Image
          ? `<img src="../uploads/blogs/${b.Image}" style="width:60px;height:60px;object-fit:cover;">`
          : "";

        $("#blogs").append(`
          <tr>
            <td>${img}</td>
            <td>${b.Title}</td>
            <td>${b.Category}</td>
            <td>${b.Author}</td>
            <td>${new Date(b.CreatedAt).toLocaleDateString()}</td>
            <td>
              <button class="btn btn-sm btn-primary" onclick="editBlog(${b.BlogId})">Edit</button>
              <button class="btn btn-sm btn-danger" onclick="deleteBlog(${b.BlogId})">Delete</button>
            </td>
          </tr>
        `);
      });
    }
  });
}

/* Edit Blog */
function editBlog(id) {
  $.ajax({
    url: "../Controllers/BlogController.php?ID=" + id,
    method: "GET",
    success: function(res) {
      res = JSON.parse(res);
      const b = res.Result;

      $("#blog_id").val(b.BlogId);
      $("#title").val(b.Title);
      $("#author").val(b.Author);
      $("#category").val(b.Category);
      $("#blog_content").val(b.Content);

      $("#previewImage")
        .attr("src", "../uploads/blogs/" + b.Image)
        .show();

      base64String = "";
      new bootstrap.Modal(document.getElementById('blogModal')).show();
    }
  });
}

/* Save Blog */
$("#btnSaveBlog").click(function() {
  const reqJSON = {
    blog_id: $("#blog_id").val(),
    title: $("#title").val(),
    author: $("#author").val(),
    category: $("#category").val(),
    content: $("#blog_content").val(),
    base64String: base64String
  };

  $.ajax({
    url: "../Controllers/BlogController.php",
    method: "POST",   // 🔥 FIXED — ALWAYS POST
    contentType: "application/json",
    data: JSON.stringify(reqJSON),

    success: function(res) {
      res = JSON.parse(res);
      alert(res.Result);

      $("#blogModal").modal('hide');
      loadBlogs();
    }
  });
});

/* Delete Blog */
function deleteBlog(id) {
  if (confirm("Are you sure you want to delete this blog?")) {
    $.ajax({
      url: "../Controllers/BlogController.php?ID=" + id,
      method: "DELETE",
      success: function(res) {
        res = JSON.parse(res);
        alert(res.Result);
        loadBlogs();
      }
    });
  }
}
</script>
