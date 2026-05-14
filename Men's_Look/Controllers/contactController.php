<?php
require_once("../DBOperations/manageContact.php");

$contact = new ManageContact();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'subject' => $_POST['subject'] ?? '',
        'message' => $_POST['message'] ?? '',
    ];

    if ($contact->SaveContact($data)) {
        header("Location: ../User/contact.php?success=1");
    } else {
        header("Location: ../User/contact.php?error=1");
    }
}
?>
