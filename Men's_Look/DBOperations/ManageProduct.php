<?php
require("DBConfig.php");

class ManageProduct extends DBconfig
{
    // CREATE Product
    function SaveProduct($data)
    {
        $Query = "INSERT INTO `products` 
        (`category_id`, `product_name`, `description`, `brand`, `price`, `discount_price`, `stock_quantity`, `size`, `color`, `image_url`, `status`, `created_at`, `updated_at`) 
        VALUES 
        (
            '" . $data->category_id . "',
            '" . $data->product_name . "',
            '" . $data->description . "',
            '" . $data->brand . "',
            '" . $data->price . "',
            '" . $data->discount_price . "',
            '" . $data->stock_quantity . "',
            '" . $data->size . "',
            '" . $data->color . "',
            '" . $data->image_url . "',
            '" . $data->status . "',
            CURRENT_TIMESTAMP,
            CURRENT_TIMESTAMP
        )";

        if (mysqli_query($this->Con, $Query)) {
            return array("Status" => "Ok", "Result" => "Successfully Saved");
        } else {
            return array("Status" => "Fail", "Result" => mysqli_error($this->Con));
        }
    }

    // READ all Products
    function getData()
    {
        $Query = "SELECT * FROM products";
        $rows = [];
        $res = mysqli_query($this->Con, $Query);

        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }

        return array("Status" => "Ok", "Result" => $rows);
    }

    // READ single Product
    function getDetails($id)
    {
        $Query = "SELECT * FROM products WHERE product_id = $id";
        $res = mysqli_query($this->Con, $Query);

        if ($row = mysqli_fetch_assoc($res)) {
            return array("Status" => "Ok", "Result" => $row);
        } else {
            return array("Status" => "Fail", "Result" => "Not Found");
        }
    }

    // UPDATE Product
    function editProduct($data)
    {
        // Base UPDATE query
        $Query = "UPDATE `products` SET 
        `category_id` = '" . $data->category_id . "',
        `product_name` = '" . $data->product_name . "',
        `description` = '" . $data->description . "',
        `brand` = '" . $data->brand . "',
        `price` = '" . $data->price . "',
        `discount_price` = '" . $data->discount_price . "',
        `stock_quantity` = '" . $data->stock_quantity . "',
        `size` = '" . $data->size . "',
        `color` = '" . $data->color . "',
        `status` = '" . $data->status . "',
        `updated_at` = CURRENT_TIMESTAMP";

        // Only update image_url if provided
        if (!empty($data->image_url)) {
            $Query .= ", `image_url` = '" . $data->image_url . "'";
        }

        // Add WHERE condition
        $Query .= " WHERE `product_id` = '" . $data->product_id . "'";

        // Execute the query
        if (mysqli_query($this->Con, $Query)) {
            return array("Status" => "Ok", "Result" => "Successfully Updated");
        } else {
            return array("Status" => "Fail", "Result" => mysqli_error($this->Con));
        }
    }


    // DELETE Product
    function deleteProduct($id)
    {
        $Query = "DELETE FROM products WHERE product_id = $id";
        if (mysqli_query($this->Con, $Query)) {
            return array("Status" => "Ok", "Result" => "Successfully Deleted");
        } else {
            return array("Status" => "Fail", "Result" => mysqli_error($this->Con));
        }
    }

    public function getCount()
    {
        $query = "SELECT COUNT(*) as cnt FROM products"; // change table name
        $result = $this->Con->query($query);
        $row = $result->fetch_assoc();
        return $row['cnt'];
    }
}
