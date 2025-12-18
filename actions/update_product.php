<?php
require "../config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = intval($_POST['productID']);
    $productName = $_POST['productName'];
    $categoryID = intval($_POST['categoryID']);
    $supplierID = intval($_POST['supplierID']);
    $quantityPerUnit = $_POST['quantityPerUnit'];
    $unitPrice = floatval($_POST['unitPrice']);
    $unitsInStock = intval($_POST['unitsInStock']);
    $unitsOnOrder = intval($_POST['unitsOnOrder'] ?? 0);

    // Validation
    if (empty($productName)) {
        echo json_encode(["success" => false, "message" => "Product name is required"]);
        exit;
    }

    if ($unitPrice < 0) {
        echo json_encode(["success" => false, "message" => "Unit price cannot be negative"]);
        exit;
    }

    if ($unitsInStock < 0) {
        echo json_encode(["success" => false, "message" => "Units in stock cannot be negative"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE products SET ProductName = ?, CategoryID = ?, SupplierID = ?, QuantityPerUnit = ?, UnitPrice = ?, UnitsInStock = ?, UnitsOnOrder = ? WHERE ProductID = ?");
    $stmt->bind_param("siisdiii", $productName, $categoryID, $supplierID, $quantityPerUnit, $unitPrice, $unitsInStock, $unitsOnOrder, $productID);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating product: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

$conn->close();
?>