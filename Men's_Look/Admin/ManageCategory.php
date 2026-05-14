<?php include "Layouts/_Header.php" ?>
<?php include "Layouts/navbar.php" ?>
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
<!-- Content -->
<div class="content" id="content">
  <div class="container-fluid">
    <h3 class="mb-4">Add Category</h3>

    <div class="card shadow">
      <div class="card-body">
        <form>
          <input type="hidden" name="txtid" id="txtid" value="0" />
          
          <!-- Category Name -->
          <div class="mb-3">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="categoryName" placeholder="Enter category name">
          </div>

          <!-- Category Description -->
          <div class="mb-3">
            <label for="categoryDesc" class="form-label">Category Description</label>
            <input type="text" class="form-control" id="categoryDesc" placeholder="Enter category description">
          </div>

          <!-- Buttons -->
          <div class="d-flex gap-2">
            <button type="button" id="btnSave" class="btn btn-primary">
              <i class="bi bi-save"></i> Save
            </button>
            <button type="reset" class="btn btn-secondary" onclick="clearForm() ">
              <i class="bi bi-arrow-counterclockwise"></i> Reset
            </button>
          </div>
          <div class="mb-3">
            <table class="table table-bordered mt-5">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody id="catrgiries">
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include "Layouts/_footer.php" ?>


<script>
  $(document).ready(function() {
    getData();
    $("#btnSave").click(function() {
      const reqJSON = {
        "CategorieId": $("#txtid").val(),
        "Name": $("#categoryName").val(),
        "Description": $("#categoryDesc").val()
      };

      $.ajax({
        url: "../Controllers/CategorieController.php",
        method: ($("#txtid").val() == "0" ? "POST" : "PUT"),
        contentType: "application/json",
        data: JSON.stringify(reqJSON),
        success: function(res) {
          console.log(res);
          res = JSON.parse(res);
          if (res.Status == "Ok") {
            alert(res.Result);
            getData();
            clearForm();
          } else {
            alert(res.err);
          }
        },
        error: function(err) {
          console.log(" Error:", err);
        }
      });


    });
  });

  function getData() {
    $("#catrgiries").empty();
    $.ajax({
      url: "../Controllers/CategorieController.php",
      method: "GET",
      contentType: "application/json",
      success: function(res) {
        res = JSON.parse(res);
        res.Result.map((o) => {
          $("#catrgiries").append(`
                                    <tr>
                                        <td>${o.category_name}</td>
                                        <td>${o.description}</td>
                                        <td><button onClick="getDetail(${o.Categorieid},'${o.category_name}','${o.description}')" class="btn btn-primary" type="button">Edit</button></td>
                                        <td><button onClick="deleteData(${o.Categorieid})" class="btn btn-danger" type="button">Delete</button></td>
                                    
                                    </tr>
                                    `)
        })
      },
      error: function(err) {
        console.log(" Error:", err);
      }
    });
  }


    function clearForm() {
    $("#categoryName").val("");
    $("#categoryDesc").val("");
    $("#txtid").val("");
  }

  function getDetail(Categorieid, category_name, description) {
    $("#categoryName").val(category_name);
    $("#categoryDesc").val(description);
    $("#txtid").val(Categorieid);
  }

  function deleteData(Id) {
    if (confirm("Are you sure to  Delete...!!!")) {
      $("#catrgiries").empty();
      $.ajax({
        url: "../Controllers/CategorieController.php?ID=" + Id,
        method: "DELETE",
        contentType: "application/json",
        success: function(res) {
          res = JSON.parse(res);
          getData();
          alert(res.Result);
        },
        error: function(err) {
          console.log(" Error:", err);
        }
      });
    }
  }
</script>