<?php
require "../config.php";

$searchQuery = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "SELECT * FROM `customers`
        WHERE CustomerID LIKE '%$searchQuery%'
        OR CompanyName LIKE '%$searchQuery%'
        OR ContactTitle LIKE '%$searchQuery%'
        OR ContactName LIKE '%$searchQuery%'
        OR Phone LIKE '%$searchQuery%'
        OR Country LIKE '%$searchQuery%'
    ";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='customer-row' data-id='" . $row['CustomerID'] . "' style='cursor: pointer;'>";

        echo "<td>" . $row['CustomerID'] . "</td>";
        echo "<td>" . $row['CompanyName'] . "</td>";
        echo "<td>" . $row['ContactName'] . "</td>";
        echo "<td>" . $row['ContactTitle'] . "</td>";
        echo "<td>" . $row['Phone'] . "</td>";
        echo "<td>" . $row['Country'] . "</td>";

        echo "</tr>";
    }
} else {

    echo "<tr><td colspan='7' class='text-center'>No customers found.</td></tr>";
}

$conn->close();
?>