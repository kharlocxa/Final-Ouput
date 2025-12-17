<?php
// Fetch customer data based on the ID passed from customer_details.php
if (isset($customer)) {
    // Output the customer details in table rows
    echo "<tr>";
    echo "<td>" . htmlspecialchars($customer['CustomerID']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['CompanyName']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['ContactName']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['ContactTitle']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['Address']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['City']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['Region']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['PostalCode']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['Country']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['Phone']) . "</td>";
    echo "<td>" . htmlspecialchars($customer['Fax']) . "</td>";
    echo "<td><a href='edit_customer.php?id=" . htmlspecialchars($customer['CustomerID']) . "' class='btn btn-primary'>Edit</a></td>";
    echo "<td><a href='customer.php' class='btn btn-secondary'>Back</a></td>";

    echo "</tr>";
} else {
    echo "<tr><td colspan='12'>Customer data not available.</td></tr>";
}
?>
