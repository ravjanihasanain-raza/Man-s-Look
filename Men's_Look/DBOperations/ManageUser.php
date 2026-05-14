<?php
include_once "DBConfig.php";

class ManageUser extends DBConfig
{
    // 🔹 Register new user
    public function registerUser($name, $email, $password, $MobileNo)
    {
        // Check if email already exists
        $check = $this->Con->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            return ["Status" => "Error", "Message" => "Email already exists"];
        }

        // Hash password
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // ✅ FIXED: 4 variables, so 4 placeholders
        $query = $this->Con->prepare("INSERT INTO users (name, email, ContactNo, password) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $name, $email, $MobileNo, $hashed);

        if ($query->execute()) {
            return ["Status" => "Ok", "Message" => "Registration successful"];
        } else {
            return ["Status" => "Error", "Message" => "Registration failed: " . $this->Con->error];
        }
    }

    // 🔹 Update user info
    public function updateUser($UserId, $name, $email, $mobile)
    {
        // Check if email already used by another user
        $check = $this->Con->prepare("SELECT id FROM users WHERE email = ? AND id <> ?");
        $check->bind_param("si", $email, $UserId);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            return ["Status" => "Error", "Message" => "Email already exists"];
        }

        // Update user data
        $query = $this->Con->prepare("UPDATE users SET name = ?, email = ?, ContactNo = ? WHERE id = ?");
        $query->bind_param("sssi", $name, $email, $mobile, $UserId);

        if ($query->execute()) {
            return ["Status" => "Ok", "Message" => "Profile updated successfully"];
        } else {
            return ["Status" => "Error", "Message" => "Failed to update profile"];
        }
    }

    // 🔹 Login user
    public function loginUser($email, $password)
    {
        $query = $this->Con->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows === 0) {
            return ["Status" => "Error", "Message" => "Email not found"];
        }

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            return ["Status" => "Ok", "User" => $user];
        } else {
            return ["Status" => "Error", "Message" => "Invalid password"];
        }
    }

    // 🔹 Get user by ID
    public function getUser($userId)
    {
        $query = $this->Con->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows === 0) {
            return ["Status" => "Error", "Message" => "User not found"];
        }

        $user = $result->fetch_assoc();
        return ["Status" => "Ok", "User" => $user];
    }

    // 🔹 Change password
    public function changePassword($userId, $currentPassword, $newPassword)
    {
        $query = $this->Con->prepare("SELECT password FROM users WHERE id = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows === 0) {
            return ["Status" => "Error", "Message" => "User not found"];
        }

        $user = $result->fetch_assoc();

        if (!password_verify($currentPassword, $user["password"])) {
            return ["Status" => "Error", "Message" => "Current password is incorrect"];
        }

        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $update = $this->Con->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $newHash, $userId);

        if ($update->execute()) {
            return ["Status" => "Ok", "Message" => "Password changed successfully"];
        } else {
            return ["Status" => "Error", "Message" => "Failed to update password"];
        }
    }
}
?>
