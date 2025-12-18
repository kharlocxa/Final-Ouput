<?php
require "../config.php"; // Include database connection

$sql = "SELECT * FROM `customers` ORDER BY `CompanyName`, `CustomerID`"; // Fetch data

$result = mysqli_query($conn, $sql);


if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $customerID = htmlspecialchars($row['CustomerID']);
        $companyName = htmlspecialchars($row['CompanyName']);
        $contactName = htmlspecialchars($row['ContactName']);
        $contactTitle = htmlspecialchars($row['ContactTitle']);
        $phone = htmlspecialchars($row['Phone']);
        $country = htmlspecialchars($row['Country']);
        
        echo "<tr class='customer-row' data-id='{$customerID}'>";
        echo "<td>{$customerID}</td>";
        echo "<td>{$companyName}</td>";
        echo "<td>{$contactName}</td>";
        echo "<td>{$contactTitle}</td>";
        echo "<td>{$phone}</td>";
        echo "<td>{$country}</td>";
        echo "<td><button class='btn btn-sm btn-primary editCustomerBtn' data-id='{$customerID}'><i class='bi bi-pencil'></i> Edit</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No customers found.</td></tr>";
}

$conn->close();
?>