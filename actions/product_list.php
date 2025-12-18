<?php
require "../config.php"; // Include database connection

// SQL query to fetch product details with category name
$sql = "SELECT p.*, c.CategoryName 
        FROM `products` p
        JOIN `categories` c ON p.CategoryID = c.CategoryID
        ORDER BY p.ProductID";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    // Loop through and display each product's data in a row
    while($row = mysqli_fetch_assoc($result)) {
        $productID = htmlspecialchars($row['ProductID']);
        $productName = htmlspecialchars($row['ProductName']);
        $categoryName = htmlspecialchars($row['CategoryName']);
        $supplierID = htmlspecialchars($row['SupplierID']);
        $quantityPerUnit = htmlspecialchars($row['QuantityPerUnit']);
        $unitPrice = htmlspecialchars($row['UnitPrice']);
        $unitsInStock = htmlspecialchars($row['UnitsInStock']);
        $unitsOnOrder = htmlspecialchars($row['UnitsOnOrder']);
        
        echo "<tr class='product-row' data-id='{$productID}'>";
        echo "<td>{$productID}</td>";
        echo "<td>{$productName}</td>";
        echo "<td>{$categoryName}</td>";
        echo "<td>{$supplierID}</td>";
        echo "<td>{$quantityPerUnit}</td>";
        echo "<td>{$unitPrice}</td>";
        echo "<td>{$unitsInStock}</td>";
        echo "<td>{$unitsOnOrder}</td>";
        echo "<td><button class='btn btn-sm btn-primary editProductBtn' data-id='{$productID}'><i class='bi bi-pencil'></i> Edit</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No products found.</td></tr>";
}

$conn->close();
?>