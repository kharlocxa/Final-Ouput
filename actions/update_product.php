<?php
require "../config.php"; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = intval($_POST['productID']);
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $categoryID = intval($_POST['categoryID']);
    $supplierID = intval($_POST['supplierID']);
    $quantityPerUnit = mysqli_real_escape_string($conn, $_POST['quantityPerUnit']);
    $unitPrice = floatval($_POST['unitPrice']);
    $unitsInStock = intval($_POST['unitsInStock']);

    $stmt = $conn->prepare("UPDATE `products` SET 
                            `ProductName` = ?, 
                            `CategoryID` = ?, 
                            `SupplierID` = ?, 
                            `QuantityPerUnit` = ?, 
                            `UnitPrice` = ?, 
                            `UnitsInStock` = ? 
                            WHERE `ProductID` = ?");
    $stmt->bind_param("siisdii", $productName, $categoryID, $supplierID, $quantityPerUnit, $unitPrice, $unitsInStock, $productID);

    if ($stmt->execute()) {
        header("Location: ../pages/product.php");
        exit;
    } else {
        echo "Error updating product: " . $stmt->error;
    }
}
?>
