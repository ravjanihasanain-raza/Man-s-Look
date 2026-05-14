<?php
include_once "../DBOperations/DBConfig.php";

class BlogController extends DBConfig {

    // ✅ Add or Update Blog
    public function saveBlog($data) {
        $title = $data['title'];
        $content = $data['content'];
        $category = $data['category'];
        $author = $data['author'];
        $base64String = $data['base64String'] ?? "";
        $slug = strtolower(str_replace(" ", "-", $title));
        $blogId = $data['blog_id'] ?? 0;

        $imgName = "";

        // Save image if provided
        if (!empty($base64String)) {
            $imgName = time() . ".jpg";
            $imgData = explode(",", $base64String)[1];
            $imgDecoded = base64_decode($imgData);
            $uploadPath = dirname(__DIR__) . "/uploads/blogs/" . $imgName;
            file_put_contents($uploadPath, $imgDecoded);
        }

        if ($blogId == 0) {
            $stmt = $this->Con->prepare("INSERT INTO blogs (Title, Slug, Category, Author, Content, Image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $title, $slug, $category, $author, $content, $imgName);
            return $stmt->execute()
                ? ["Status" => "Ok", "Result" => "Blog added successfully!"]
                : ["Status" => "Error", "Result" => $this->Con->error];
        } else {
            if ($imgName != "") {
                $stmt = $this->Con->prepare("UPDATE blogs SET Title=?, Slug=?, Category=?, Author=?, Content=?, Image=? WHERE BlogId=?");
                $stmt->bind_param("ssssssi", $title, $slug, $category, $author, $content, $imgName, $blogId);
            } else {
                $stmt = $this->Con->prepare("UPDATE blogs SET Title=?, Slug=?, Category=?, Author=?, Content=? WHERE BlogId=?");
                $stmt->bind_param("sssssi", $title, $slug, $category, $author, $content, $blogId);
            }
            return $stmt->execute()
                ? ["Status" => "Ok", "Result" => "Blog updated successfully!"]
                : ["Status" => "Error", "Result" => $this->Con->error];
        }
    }

    // ✅ Get All Blogs (returns data)
    public function getAllBlogs() {
        $res = $this->Con->query("SELECT * FROM blogs ORDER BY BlogId DESC");
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        return ["Status" => "Ok", "Result" => $data];
    }

    // ✅ Get Single Blog by ID
    public function getBlog($id) {
        $stmt = $this->Con->prepare("SELECT * FROM blogs WHERE BlogId=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return ["Status" => "Ok", "Result" => $res];
    }

    // ✅ Get Blog by Slug
    public function getBlogBySlug($slug) {
        $stmt = $this->Con->prepare("SELECT * FROM blogs WHERE Slug=?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res;
    }

    // ✅ Delete Blog
    public function deleteBlog($id) {
        $stmt = $this->Con->prepare("DELETE FROM blogs WHERE BlogId=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute()
            ? ["Status" => "Ok", "Result" => "Blog deleted successfully!"]
            : ["Status" => "Error", "Result" => $this->Con->error];
    }
}

// 🔹 Handle HTTP Requests (only when accessed via browser)
if (php_sapi_name() !== 'cli' && basename($_SERVER['SCRIPT_NAME']) === 'BlogController.php') {
    $blog = new BlogController();
    $method = $_SERVER["REQUEST_METHOD"];

    switch ($method) {
        case "GET":
            if (isset($_GET["ID"])) {
                echo json_encode($blog->getBlog($_GET["ID"]));
            } else {
                echo json_encode($blog->getAllBlogs());
            }
            break;

        case "POST":
        case "PUT":
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($blog->saveBlog($data));
            break;

        case "DELETE":
            $id = $_GET["ID"];
            echo json_encode($blog->deleteBlog($id));
            break;
    }
}
?>
