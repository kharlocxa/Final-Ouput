<?php
require "../header.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generateReport'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Validate date inputs
    if (!$startDate || !$endDate) {
        echo "<p class='text-danger'>Please provide a valid date range.</p>";
        exit;
    }

    try {
        // Fetch total sales revenue
        $salesQuery = "SELECT SUM(od.UnitPrice * od.Quantity) AS total_sales
                       FROM `ORDER_DETAILS` od
                       JOIN `ORDERS` o ON od.OrderID = o.OrderID
                       WHERE o.OrderDate BETWEEN ? AND ?";

        $stmt = $conn->prepare($salesQuery);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $salesResult = $stmt->get_result()->fetch_assoc();
        $totalSales = $salesResult['total_sales'] ?? 0;

        // Fetch inventory report
        $inventoryQuery = "SELECT 
                               p.ProductID, 
                               p.ProductName, 
                               p.UnitsInStock, 
                               COALESCE(SUM(od.Quantity), 0) AS TotalOrdered,
                               GREATEST(p.UnitsInStock - COALESCE(SUM(od.Quantity), 0), 0) AS AvailableQuantity
                           FROM `PRODUCTS` p
                           LEFT JOIN `ORDER_DETAILS` od ON p.ProductID = od.ProductID
                           LEFT JOIN `ORDERS` o ON od.OrderID = o.OrderID AND o.OrderDate BETWEEN ? AND ?
                           GROUP BY p.ProductID, p.ProductName, p.UnitsInStock";

        $stmt = $conn->prepare($inventoryQuery);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $inventoryResult = $stmt->get_result();

        // Display results
        echo "<h1>Sales Report</h1>";

        if ($totalSales > 0) {
            echo "<p><strong>Total Sales Revenue:</strong> $" . number_format($totalSales, 2) . "</p>";
        } else {
            echo "<p class='text-warning'>No sales were recorded for the selected date range: $startDate to $endDate.</p>";
        }

        echo "<h2>Inventory Report</h2>";
        echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Units In Stock</th>
                        <th>Total Ordered</th>
                        <th>Available Quantity</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $inventoryResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ProductID']}</td>
                    <td>{$row['ProductName']}</td>
                    <td>{$row['UnitsInStock']}</td>
                    <td>{$row['TotalOrdered']}</td>
                    <td>{$row['AvailableQuantity']}</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } catch (mysqli_sql_exception $e) {
        echo "<p class='text-danger'>An error occurred while generating the report: " . $e->getMessage() . "</p>";
    }
}
?>
