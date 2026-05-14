<?php 
include "Layouts/_Header.php"; 
include "Layouts/navbar.php"; 
include_once "../Controllers/BlogController.php";

$blogObj = new BlogController();

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    echo "<div class='container py-5 text-center'><h4>Invalid Blog URL</h4></div>";
    include "Layouts/_Footer.php";
    exit;
}

$slug = $_GET['slug'];
$blog = $blogObj->getBlogBySlug($slug);

if (!$blog) {
    echo "<div class='container py-5 text-center'><h4>Blog Not Found</h4></div>";
    include "Layouts/_Footer.php";
    exit;
}
?>

<style>
/* Page wrapper */
.blog-wrapper {
    max-width: 850px;
    margin: auto;
}

/* Featured Image */
.blog-featured-img {
    position: relative;
    height: 380px;
    width: 100%;
    overflow: hidden;
    border-radius: 12px;
}

.blog-featured-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Title and meta */
.blog-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #222;
    line-height: 1.3;
}

.blog-meta {
    font-size: 0.95rem;
    color: #666;
}

/* Blog content */
.blog-content {
    font-size: 1.15rem;
    color: #333;
    line-height: 1.85;
    margin-top: 25px;
}

.blog-content img {
    max-width: 100%;
    border-radius: 10px;
    margin: 20px 0;
}

/* Pull quotes */
.blog-quote {
    font-size: 1.3rem;
    font-weight: 600;
    padding: 20px;
    border-left: 4px solid #28a745;
    background: #f4fff6;
    color: #1f4f1f;
    margin: 25px 0;
    border-radius: 5px;
}

/* Share buttons */
.share-box {
    margin-top: 35px;
    padding: 18px;
    background: #f8f9fa;
    border-radius: 10px;
    text-align: center;
}

.share-box button {
    margin: 4px;
}

/* Responsive */
@media (max-width: 768px) {
    .blog-title { font-size: 1.7rem; }
    .blog-featured-img { height: 230px; }
}
</style>

<div class="container py-5">

  <a href="blog.php" class="btn btn-outline-secondary mb-4">&larr; Back to Blogs</a>

  <div class="blog-wrapper">

    <!-- Featured Image -->
    <?php if (!empty($blog['Image'])): ?>
    <div class="blog-featured-img mb-4">
      <img src="../uploads/blogs/<?= $blog['Image'] ?>" alt="">
    </div>
    <?php endif; ?>

    <!-- Title -->
    <h1 class="blog-title"><?= htmlspecialchars($blog['Title']) ?></h1>

    <!-- Meta -->
    <p class="blog-meta mt-2 mb-4">
      ✍️ <b><?= htmlspecialchars($blog['Author']) ?></b>  
      &nbsp; • &nbsp;  
      📅 <?= date('d M Y', strtotime($blog['CreatedAt'])) ?>  
      &nbsp; • &nbsp;  
      📂 <?= htmlspecialchars($blog['Category']) ?>
    </p>

    <!-- Content -->
    <div class="blog-content">

      <?php
        $allowed_tags = '<p><br><b><strong><i><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><span><img>';

        $cleanContent = strip_tags($blog['Content'], $allowed_tags);

        // Auto-add beautiful quote block when "---quote---" appears
        $cleanContent = str_replace("[quote]", "<div class='blog-quote'>", $cleanContent);
        $cleanContent = str_replace("[/quote]", "</div>", $cleanContent);

        echo nl2br($cleanContent);
      ?>

    </div>

    <!-- Share Section -->
    <div class="share-box">
      <h5 class="fw-bold mb-3">Share this article</h5>

      <button class="btn btn-primary">
        <i class="bi bi-facebook"></i> Facebook
      </button>

      <button class="btn btn-info text-white">
        <i class="bi bi-twitter"></i> Twitter
      </button>

      <button class="btn btn-danger">
        <i class="bi bi-pinterest"></i> Pinterest
      </button>

      <button class="btn btn-dark">
        <i class="bi bi-whatsapp"></i> WhatsApp
      </button>
    </div>

  </div>
</div>

<?php include "Layouts/_Footer.php"; ?>
