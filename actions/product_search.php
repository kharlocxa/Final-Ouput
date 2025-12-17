<?php
require "../config.php"; // Include database connection

$searchQuery = ''; // Initialize the search query variable

// Check if there's a search input from the GET request
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']); // Sanitize input
}

// Updated SQL query
// $sql = "SELECT p.*, c.CategoryName 
//         FROM `products` p
//         LEFT JOIN `categories` c ON p.CategoryID = c.CategoryID
//         WHERE p.ProductName LIKE '%$searchQuery%' OR c.CategoryName LIKE '%$searchQuery%'
//         ORDER BY p.ProductName, p.ProductID";

$sql = "SELECT products.*, categories.*
        FROM products
        INNER JOIN categories ON categories.CategoryID = products.CategoryID
        WHERE ProductID LIKE '%$searchQuery%'
        OR ProductName LIKE '%$searchQuery%'
        OR SupplierID LIKE '%$searchQuery%'
        OR QuantityPerUnit LIKE '%$searchQuery%'
        OR UnitPrice LIKE '%$searchQuery%'
        OR UnitsInStock LIKE '%$searchQuery%'
        OR UnitsOnOrder LIKE '%$searchQuery%'
    ";


$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn)); // Debugging for SQL issues
}

if (mysqli_num_rows($result) > 0) {
    // Loop through and display each product's data in a row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='product-row' data-id='" . $row['ProductID'] . "'>";
        echo "<td>" . $row['ProductID'] . "</td>";
        echo "<td>" . $row['ProductName'] . "</td>";
        echo "<td>" . $row['CategoryName'] . "</td>"; // CategoryName from categories table
        echo "<td>" . $row['SupplierID'] . "</td>";
        echo "<td>" . $row['QuantityPerUnit'] . "</td>";
        echo "<td>" . $row['UnitPrice'] . "</td>";
        echo "<td>" . $row['UnitsInStock'] . "</td>";
        echo "<td>" . $row['UnitsOnOrder'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No products found.</td></tr>";
}

$conn->close();
?>
