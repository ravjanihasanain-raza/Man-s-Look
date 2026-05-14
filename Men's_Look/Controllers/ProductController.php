<?php
require("../DBOperations/ManageProduct.php");
$method = $_SERVER["REQUEST_METHOD"];
$manageProduct = new ManageProduct();

switch ($method) {
  case "POST":
    $input = json_decode(file_get_contents("php://input"));

    // create unique file name
    $uniqueName = "IMG" . uniqid() . '.png';
    $input->image_url = $uniqueName;

    $result = $manageProduct->SaveProduct($input);

    if ($result["Status"] == "Ok" && isset($input->base64String)) {

      // get base64 string from input
      $rawBase64 = $input->base64String;

      // remove prefix like "data:image/png;base64,"
      $base64String = substr($rawBase64, strpos($rawBase64, ',') + 1);

      // decode
      $base64String = base64_decode($base64String);

      // save to folder
      file_put_contents("../Content/Photo/$uniqueName", $base64String);
    }

    echo json_encode($result);
    break;
  // READ Product(s)
  case "GET":
    if (isset($_REQUEST["ID"])) {
      // Single product
      $result = $manageProduct->getDetails($_REQUEST["ID"]);
    } else {
      // All products
      $result = $manageProduct->getData();
    }
    echo json_encode($result);
    break;

  // UPDATE Product
  case "PUT":
    $input = json_decode(file_get_contents("php://input"));

   if (!empty($input->base64String)) {
        $uniqueName = "IMG" . uniqid() . '.png';
        $input->image_url = $uniqueName;
    }

    $result = $manageProduct->editProduct($input);

    if ($result["Status"] == "Ok") {
      // Only process image if both image URL and base64 data are present
      if (!empty($input->base64String)) {
        $rawBase64 = $input->base64String;

        // Remove data URI prefix if exists (e.g., "data:image/png;base64,")
        if (strpos($rawBase64, ',') !== false) {
          $base64String = substr($rawBase64, strpos($rawBase64, ',') + 1);
        } else {
          $base64String = $rawBase64;
        }

        // Decode and overwrite file
        $decodedImage = base64_decode($base64String);
        if ($decodedImage !== false) {
          file_put_contents("../Content/Photo/" . $input->image_url, $decodedImage);
        } else {
          $result["Status"] = "Error";
          $result["Message"] = "Invalid base64 image data.";
        }
      }
    }
    echo json_encode($result);
    break;


  // DELETE Product
  case "DELETE":
    if (isset($_REQUEST["ID"])) {
      $result = $manageProduct->deleteProduct($_REQUEST["ID"]);
    } else {
      $result = array("Status" => "Fail", "Result" => "ID is not found");
    }
    echo json_encode($result);
    break;
}
