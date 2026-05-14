<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

<!-- ✅ Stylesheets -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container py-5 my-4">
  <!-- ABOUT HERO -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=800&q=80" alt="About Our Store" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h1 class="fw-bold mb-3" style="color:#1f8b3d;">About Kedai Online</h1>
      <p class="lead mb-3 text-muted">
        Welcome to Kedai Online, your trusted destination for quality men’s fashion. We offer a handpicked range of clothing—from classic blazers and cozy jackets to trendy casuals and activewear—crafted with style, comfort, and everyday elegance in mind.
      </p>
      <p>
        Our passion is to bring you premium designs at affordable prices. With fast shipping, easy returns, and dedicated customer care, shopping with us is always a premium experience.
      </p>
    </div>
  </div>

  <!-- BRAND STORY, MISSION, & PERKS -->
  <div class="row text-center g-4 mb-5">
    <div class="col-md-4">
      <i class="fa fa-globe fa-2x text-success mb-3"></i>
      <h5 class="fw-bold">Our Story</h5>
      <p class="text-muted small">
        Started in 2023, Kedai Online was born from a desire to make exceptional men’s fashion accessible for every age and lifestyle. Today, we empower customers across India to look sharp and shop smart, from work to weekend and everywhere in between.
      </p>
    </div>
    <div class="col-md-4">
      <i class="fa fa-bullseye fa-2x text-success mb-3"></i>
      <h5 class="fw-bold">Our Mission</h5>
      <p class="text-muted small">
        To inspire confidence and individuality through curated, high-quality apparel while delivering excellence in service and value to our customers—every single day.
      </p>
    </div>
    <div class="col-md-4">
      <i class="fa fa-star fa-2x text-success mb-3"></i>
      <h5 class="fw-bold">Why Shop With Us?</h5>
      <ul class="list-unstyled text-muted small">
        <li><i class="fa fa-check text-success me-2"></i>Free Shipping on orders ₹999+</li>
        <li><i class="fa fa-check text-success me-2"></i>14-day Easy Returns</li>
        <li><i class="fa fa-check text-success me-2"></i>100% Secure Payments</li>
        <li><i class="fa fa-check text-success me-2"></i>Dedicated Support Team</li>
      </ul>
    </div>
  </div>

  <!-- CUSTOMER TRUST/REVIEWS -->
  <div class="row align-items-center justify-content-center bg-light rounded shadow-sm p-4 mb-4">
    <div class="col-md-5">
      <h4 class="fw-bold mb-2 text-success">Our Customers Love Us!</h4>
      <p class="mb-4 text-muted">
        Rated 4.8/5 by thousands of satisfied shoppers for quality, value, and support. Join our family—shop with confidence!
      </p>
    </div>
    <div class="col-md-5 text-md-end">
      <div class="d-flex align-items-center gap-2 justify-content-md-end">
        <i class="fa fa-star text-warning"></i>
        <i class="fa fa-star text-warning"></i>
        <i class="fa fa-star text-warning"></i>
        <i class="fa fa-star text-warning"></i>
        <i class="fa fa-star-half-alt text-warning"></i>
        <span class="fw-semibold ms-2">4.8/5</span>
      </div>
      <small class="text-muted">Based on 2,476 reviews</small>
    </div>
  </div>

  <!-- CALL TO ACTION -->
  <div class="text-center mt-5">
    <h5 class="fw-bold mb-2">Ready to Refresh Your Wardrobe?</h5>
    <a href="shop.php" class="btn btn-success btn-lg px-4">Shop Latest Collection</a>
    <p class="text-muted mt-2 mb-0">Questions? <a href="contact.php" class="text-success">Contact our support team</a></p>
  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<style>
  .about-feature i {
    width:48px;
    height:48px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background: #e9fbe6;
    border-radius: 50%;
  }
  .bg-about-hero {
    background: linear-gradient(135deg, #e8fff2 0%, #ffffff 100%);
    border-radius: 1.5rem;
  }
  @media (max-width: 767px) {
    .about-feature i { width:32px; height:32px; font-size:1.2rem; }
  }
</style>
