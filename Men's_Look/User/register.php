<?php
include "Layouts/_Header.php";
include "Layouts/navbar.php";



// Redirect logged-in users to home
if (isset($_SESSION['UserID'])) {
    echo "<script>window.location.href='home.php';</script>";
    exit;
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow p-4 border-0">
        <h3 class="fw-bold text-center mb-3">🧾 Create Account</h3>

        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" id="name" class="form-control" placeholder="Enter your full name">
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" id="email" class="form-control" placeholder="Enter your email">
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" id="password" class="form-control" placeholder="Enter your password">
        </div>

        <div class="mb-3">
          <label class="form-label">Contact No</label>
          <input type="number" id="txtContactNo" class="form-control" placeholder="Enter your Contact No">
        </div>

        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" id="cpassword" class="form-control" placeholder="Confirm your password">
        </div>

        <button class="btn btn-success w-100" onclick="registerUser()">
          <i class="fa fa-user-plus me-2"></i> Register
        </button>

        <p class="text-center mt-3 mb-0">
          Already have an account? <a href="login.php" class="text-decoration-none fw-bold">Login</a>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function registerUser() {
  let name = $("#name").val().trim();
  let email = $("#email").val().trim();
  let password = $("#password").val().trim();
  let cpassword = $("#cpassword").val().trim();
  let ContactNo = $("#txtContactNo").val().trim();

  // ---------------------------
  // ✔ NAME VALIDATION
  // ---------------------------
  let namePattern = /^[A-Za-z ]{3,}$/; 
  if (!namePattern.test(name)) {
    Swal.fire({
      icon: "warning",
      title: "Invalid Name",
      text: "Name must be at least 3 letters and cannot contain numbers."
    });
    return;
  }

  // ---------------------------
  // ✔ EMAIL VALIDATION
  // ---------------------------
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    Swal.fire({
      icon: "warning",
      title: "Invalid Email",
      text: "Please enter a valid email address."
    });
    return;
  }

  // ---------------------------
  // ✔ CONTACT NUMBER VALIDATION
  // ---------------------------
  if (!/^[0-9]{10}$/.test(ContactNo)) {
    Swal.fire({
      icon: "warning",
      title: "Invalid Contact Number",
      text: "Contact number must be exactly 10 digits."
    });
    return;
  }

  // ---------------------------
  // ✔ PASSWORD VALIDATION (MINIMUM 6 CHARACTERS)
  // ---------------------------
  if (password.length < 6) {
    Swal.fire({
      icon: "warning",
      title: "Weak Password",
      text: "Password must be at least 6 characters long."
    });
    return;
  }

  // ---------------------------
  // ✔ CONFIRM PASSWORD MATCH
  // ---------------------------
  if (password !== cpassword) {
    Swal.fire({
      icon: "error",
      title: "Password Mismatch",
      text: "Passwords do not match!"
    });
    return;
  }

  // ---------------------------
  // ✔ AJAX REGISTER
  // ---------------------------
  $.post("../Controllers/UserController.php", {
    action: "register",
    name: name,
    email: email,
    password: password,
    ContactNo: ContactNo
  }, function(res) {
    try {
      res = JSON.parse(res);

      if (res.Status == "Ok") {
        Swal.fire({
          icon: "success",
          title: "Registration Successful!",
          text: res.Message,
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = "login.php";
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Registration Failed",
          text: res.Message
        });
      }
    } catch (err) {
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
