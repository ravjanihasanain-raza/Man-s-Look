<?php 
include "Layouts/_Header.php"; 
include "Layouts/navbar.php"; 
include_once "../Controllers/BlogController.php";

$blogObj = new BlogController();
$response = $blogObj->getAllBlogs(); // returns array
$blogs = $response["Result"];
?>

<div class="container py-5">
  <h2 class="text-center mb-4 text-success fw-bold">📰 Latest Fashion Articles</h2>

  <div class="row">
    <?php if (count($blogs) > 0): ?>
      <?php foreach ($blogs as $b): ?>
        <div class="col-md-4 mb-4">
          <div class="card border-0 shadow-sm h-100">
            <img 
              src="../uploads/blogs/<?= htmlspecialchars($b['Image']) ?>" 
              alt="<?= htmlspecialchars($b['Title']) ?>" 
              class="card-img-top" 
              style="height:220px;object-fit:cover;border-bottom:3px solid #28a745;"
            >
            <div class="card-body">
              <h5 class="fw-semibold"><?= htmlspecialchars($b['Title']) ?></h5>
              <p class="text-muted small mb-2">
                By <?= htmlspecialchars($b['Author']) ?> | <?= date('d M Y', strtotime($b['CreatedAt'])) ?>
              </p>
              <p class="small text-secondary">
                <?= substr(strip_tags($b['Content']), 0, 100) ?>...
              </p>
              <a href="blog-detail.php?slug=<?= urlencode($b['Slug']) ?>" class="btn btn-outline-success btn-sm">
                Read More
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 text-center text-muted">No blogs available at the moment.</div>
    <?php endif; ?>
  </div>
</div>

<?php include "Layouts/_Footer.php"; ?>
