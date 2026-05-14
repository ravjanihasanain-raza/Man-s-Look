<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 🌄 Hero/Breadcrumb Section -->
<section class="breadcrumb-section text-white d-flex align-items-center"
  style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)), 
          url(img/about/about-us.jpg) center/cover no-repeat;
         height: 280px;">
  <div class="container text-center" data-aos="fade-down">
    <h1 class="fw-bold mb-2">Contact Us</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="home.php" class="text-white text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active text-light" aria-current="page">Contact</li>
      </ol>
    </nav>
  </div>
</section>

<!-- 📞 Contact Section -->
<section class="contact-page py-5">
  <div class="container">

    <!-- 🧱 Heading -->
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold text-dark">Get in Touch With Us</h2>
      <p class="text-muted mt-2 w-75 mx-auto">
        Have a question or just want to say hello? We’re here to help and answer any question you might have.
      </p>
    </div>

    <div class="row g-4 align-items-start">

      <!-- 📋 Contact Form -->
      <div class="col-lg-6" data-aos="fade-right">

        <form id="contactForm" class="shadow-lg p-4 bg-white rounded-4 border">

          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-person me-2 text-success"></i>Full Name</label>
            <input type="text" id="name" class="form-control" placeholder="Enter your full name">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-envelope-at me-2 text-success"></i>Email Address</label>
            <input type="email" id="email" class="form-control" placeholder="Enter your email">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-chat-dots me-2 text-success"></i>Subject</label>
            <input type="text" id="subject" class="form-control" placeholder="Subject of your message">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-pencil-square me-2 text-success"></i>Message</label>
            <textarea id="message" rows="4" class="form-control" placeholder="Write your message here..."></textarea>
          </div>

          <button type="submit" class="btn btn-success w-100 py-2 fw-semibold shadow-sm">
            <i class="bi bi-send me-2"></i>Send Message
          </button>
        </form>

      </div>

      <!-- 🏢 Contact Info -->
      <div class="col-lg-6" data-aos="fade-left">
        <div class="bg-white shadow-lg rounded-4 p-4 border h-100">
          <h4 class="fw-bold mb-4 text-success"><i class="bi bi-info-circle me-2"></i>Contact Information</h4>

          <ul class="list-unstyled fs-6">
            <li class="mb-3 d-flex align-items-center">
              <div class="icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px;">
                <i class="bi bi-geo-alt-fill fs-5"></i>
              </div>
              <div>
                <strong>Address:</strong><br>
                123 Business Street, Pune, Maharashtra 411001
              </div>
            </li>

            <li class="mb-3 d-flex align-items-center">
              <div class="icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px;">
                <i class="bi bi-telephone-fill fs-5"></i>
              </div>
              <div>
                <strong>Phone:</strong><br>
                +91 98765 43210
              </div>
            </li>

            <li class="mb-3 d-flex align-items-center">
              <div class="icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px;">
                <i class="bi bi-envelope-fill fs-5"></i>
              </div>
              <div>
                <strong>Email:</strong><br>
                contact@yourwebsite.com
              </div>
            </li>

            <li class="d-flex align-items-center">
              <div class="icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px;">
                <i class="bi bi-clock-fill fs-5"></i>
              </div>
              <div>
                <strong>Working Hours:</strong><br>
                Mon – Sat: 9:00 AM – 6:00 PM
              </div>
            </li>
          </ul>

            <!-- 🌍 Google Map -->
          <div class="mt-4">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3782.285905217306!2d73.85674327508517!3d18.56032328254109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2bf05d7d2b41d%3A0x6b6f1ec46b7cfb4f!2sPune%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1709376000000!5m2!1sen!2sin"
              width="100%" height="250" style="border:0;border-radius:10px;" allowfullscreen="" loading="lazy"></iframe>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php include "Layouts/_Footer.php"; ?>

<!-- ==========================================
        CONTACT FORM VALIDATION + LOGIN CHECK
========================================== -->
<script>
document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();

    // 🔐 LOGIN CHECK
    var userId = localStorage.getItem("UserId");

    if (!userId) {
        Swal.fire({
            title: "Login Required",
            text: "You need to login before sending a message.",
            icon: "warning",
            confirmButtonText: "Login Now",
            confirmButtonColor: "#198754"
        }).then(() => {
            window.location.href = "login.php";
        });
        return;
    }

    // 📝 GET FIELD VALUES
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let subject = document.getElementById("subject").value.trim();
    let message = document.getElementById("message").value.trim();

    // ⚠️ VALIDATIONS
    if (name.length < 3) return Swal.fire("Error", "Please enter a valid name.", "error");
    if (!email.match(/^[^@]+@[^@]+\.[^@]+$/)) return Swal.fire("Error", "Please enter a valid email address.", "error");
    if (subject.length < 3) return Swal.fire("Error", "Subject must be at least 3 characters.", "error");
    if (message.length < 10) return Swal.fire("Error", "Message must be at least 10 characters.", "error");

    // 🟢 FORM IS VALID → SEND DATA
    $.ajax({
        url: "../Controllers/contactController.php",
        type: "POST",
        data: {
            name: name,
            email: email,
            subject: subject,
            message: message,
            userId: userId
        },
        success: function(res) {
            Swal.fire({
                title: "Message Sent!",
                text: "Thank you for contacting us.",
                icon: "success"
            });

            document.getElementById("contactForm").reset();
        },
        error: function() {
            Swal.fire("Error", "Something went wrong. Please try again.", "error");
        }
    });
});
</script>
