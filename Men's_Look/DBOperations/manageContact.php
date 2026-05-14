<?php
require_once("DBConfig.php");

class ManageContact extends DBConfig
{
    // Save Contact Message
    public function SaveContact($data)
    {
        $name = $this->conn->real_escape_string($data['name']);
        $email = $this->conn->real_escape_string($data['email']);
        $subject = $this->conn->real_escape_string($data['subject']);
        $message = $this->conn->real_escape_string($data['message']);

        $query = "INSERT INTO contact_messages (name, email, subject, message) 
                  VALUES ('$name', '$email', '$subject', '$message')";
        return $this->conn->query($query);
    }

    // Get All Messages
    public function GetAllContacts()
    {
        $result = $this->conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
        return $result;
    }

    // Delete a message (optional)
    public function DeleteContact($id)
    {
        $id = (int)$id;
        return $this->conn->query("DELETE FROM contact_messages WHERE id = $id");
    }
}
?>
