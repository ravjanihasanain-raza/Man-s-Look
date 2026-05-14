<?php 
// FIX: DELETE LOGIC MUST RUN BEFORE ANY HTML OUTPUT
require_once("../DBOperations/manageContact.php");

$contactObj = new ManageContact();

// Delete contact message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $contactObj->DeleteContact($id);

    header("Location: manage_contact.php?deleted=1");
    exit;
}

$contacts = $contactObj->GetAllContacts();
?>

<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?> 

<style>
/* Same layout as Orders page */
body {
  background-color: #f8f9fa;
  overflow-x: hidden;
}

#content {
  margin-left: 260px;
  margin-top: 70px;
  padding: 20px;
  transition: margin-left 0.3s ease;
}

#content.expanded {
  margin-left: 80px;
}

.contact-table-container {
  max-height: calc(100vh - 240px);
  overflow-y: auto;
  overflow-x: auto;
  border-radius: 10px;
}

.contact-table-container thead th {
  position: sticky;
  top: 0;
  background: #212529 !important;
  color: white !important;
  z-index: 10;
}

.contact-table-container::-webkit-scrollbar {
  width: 8px;
}
.contact-table-container::-webkit-scrollbar-thumb {
  background: rgba(0,0,0,0.3);
  border-radius: 10px;
}

@media (max-width: 768px) {
  #content {
    margin-left: 0 !important;
  }
}
</style>

<!-- PAGE CONTENT -->
<div class="content" id="content">
  <div class="container-fluid py-4">

    <h2 class="fw-bold mb-4 text-success text-center">
      <i class="bi bi-envelope-paper-heart me-2"></i> Manage Contact Messages
    </h2>

    <?php if (isset($_GET['deleted'])): ?>
      <div class="alert alert-success text-center">Message deleted successfully!</div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
      <div class="card-body p-0">

        <div class="contact-table-container p-3">

          <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              <?php if ($contacts && $contacts->num_rows > 0): ?>
                <?php while ($row = $contacts->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td style="max-width:300px;"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                    <td>
                      <a href="?delete=<?= $row['id'] ?>" 
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete this message?')">
                        Delete
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-muted py-4">No contact messages found.</td>
                </tr>
              <?php endif; ?>
            </tbody>

          </table>

        </div>
      </div>
    </div>

  </div>
</div>

<?php include "Layouts/_Footer.php"; ?>
