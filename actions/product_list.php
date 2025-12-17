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
        echo "<tr class='product-row' data-id='" . $row['ProductID'] . "'>";
        echo "<td>" . $row['ProductID'] . "</td>";
        echo "<td>" . $row['ProductName'] . "</td>";
        echo "<td>" . $row['CategoryName'] . "</td>";  // Displaying the category name
        echo "<td>" . $row['SupplierID'] . "</td>";
        echo "<td>" . $row['QuantityPerUnit'] . "</td>";
        echo "<td>" . $row['UnitPrice'] . "</td>";
        echo "<td>" . $row['UnitsInStock'] . "</td>";
        echo "<td>" . $row['UnitsOnOrder'] . "</td>";
        echo "<td><a href='edit_product.php?id=" . htmlspecialchars($row['ProductID']) . "' class='btn btn-primary'>Edit</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No products found.</td></tr>";
}

$conn->close();
?>
