<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | Men's Look</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    body {
      background: linear-gradient(120deg, #198754, #0d6efd);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      background: #fff;
      border-radius: 12px;
      padding: 30px;
      width: 350px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h3 class="text-center fw-bold text-success mb-4">Admin Login</h3>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" id="username" class="form-control" placeholder="Enter username">
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" id="password" class="form-control" placeholder="Enter password">
    </div>
    <button class="btn btn-success w-100" id="btnLogin">Login</button>
    <p id="msg" class="text-center mt-3 text-danger small"></p>
  </div>

  <script>
    // 🚪 Redirect if already logged in
    if (localStorage.getItem("adminToken")) {
      window.location.href = "Dashboard.php";
    }

    $("#btnLogin").click(function(){
      const data = {
        username: $("#username").val(),
        password: $("#password").val()
      };

      $.ajax({
        url: "../Controllers/AdminLoginController.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function(res){
          res = JSON.parse(res);
          if(res.Status === "OK"){
            // ✅ Store admin info
            localStorage.setItem("adminToken", res.Result.token);
            localStorage.setItem("adminName", res.Result.FullName);
            localStorage.setItem("adminUser", res.Result.UserName);
            localStorage.setItem("adminPhoto", res.Result.photo);

            $("#msg").html("<span class='text-success'>"+res.Result.FullName+" logged in!</span>");
            setTimeout(()=> window.location.href="Dashboard.php", 800);
          } else {
            $("#msg").text(res.Result);
          }
        },
        error: () => $("#msg").text("⚠️ Server error.")
      });
    });
  </script>
</body>
</html>
