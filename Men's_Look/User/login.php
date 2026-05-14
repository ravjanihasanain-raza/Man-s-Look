<?php
include "Layouts/_Header.php";
include "Layouts/navbar.php";

?>

<script>
  if (localStorage.getItem("UserId") != null){
    window.location.href='home.php';
  }
</script>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow p-4 border-0">
        <h3 class="fw-bold text-center mb-3">🔑 Login</h3>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" id="email" class="form-control" placeholder="Enter your email">
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" id="password" class="form-control" placeholder="Enter your password">
        </div>

        <button class="btn btn-dark w-100" onclick="loginUser()">
          <i class="fa fa-sign-in-alt me-2"></i> Login
        </button>

        <p class="text-center mt-3 mb-0">
          New user? <a href="register.php" class="text-decoration-none fw-bold">Create account</a>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function loginUser() {
  let email = $("#email").val().trim();
  let password = $("#password").val().trim();

  // ---------------------------
  // ✔ EMAIL VALIDATION
  // ---------------------------
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    Swal.fire({
      icon: "warning",
      title: "Invalid Email",
      text: "Please enter a valid email address!"
    });
    return;
  }

  // ---------------------------
  // ✔ PASSWORD VALIDATION
  // ---------------------------
  if (password.length < 1) {
    Swal.fire({
      icon: "warning",
      title: "Missing Password",
      text: "Please enter your password!"
    });
    return;
  }

  // ---------------------------
  // ✔ LOGIN AJAX REQUEST
  // ---------------------------
  $.post("../Controllers/UserController.php", {
    action: "login",
    email: email,
    password: password
  }, function(res) {
    try {
      console.log(res);
      res = JSON.parse(res);

      if (res.Status === "Ok") {
        // Save session info in localStorage
        localStorage.setItem("UserId", res.User.id);
        localStorage.setItem("CustomerName", res.User.name);

        Swal.fire({
          icon: "success",
          title: "Login Successful!",
          text: res.Message,
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = "home.php";
        });

      } else {
        Swal.fire({
          icon: "error",
          title: "Login Failed",
          text: res.Message
        });
      }

    } catch (e) {
      Swal.fire({
        icon: "error",
        title: "Unexpected Error",
        text: "Something went wrong. Please try again."
      });
      console.error("Response parse error:", res);
    }
  });
}

</script>
