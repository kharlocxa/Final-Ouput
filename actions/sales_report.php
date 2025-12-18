<?php
require "../header.php";

$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;
$totalSales = null;
$detailsResult = null;
$dateRange = null;

try {
    if ($startDate && $endDate) {
        $dateRange = "$startDate to $endDate";
        
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

        // Fetch sales details by order
        $detailsQuery = "SELECT 
                            o.OrderID,
                            o.CustomerID,
                            o.OrderDate,
                            SUM(od.UnitPrice * od.Quantity) AS OrderTotal
                        FROM `ORDERS` o
                        JOIN `ORDER_DETAILS` od ON o.OrderID = od.OrderID
                        WHERE o.OrderDate BETWEEN ? AND ?
                        GROUP BY o.OrderID, o.CustomerID, o.OrderDate
                        ORDER BY o.OrderDate DESC";

        $stmt = $conn->prepare($detailsQuery);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $detailsResult = $stmt->get_result();
    } else {
        // Show all sales without date filter
        $salesQuery = "SELECT SUM(od.UnitPrice * od.Quantity) AS total_sales
                       FROM `ORDER_DETAILS` od
                       JOIN `ORDERS` o ON od.OrderID = o.OrderID";

        $stmt = $conn->prepare($salesQuery);
        $stmt->execute();
        $salesResult = $stmt->get_result()->fetch_assoc();
        $totalSales = $salesResult['total_sales'] ?? 0;

        // Fetch all sales details
        $detailsQuery = "SELECT 
                            o.OrderID,
                            o.CustomerID,
                            o.OrderDate,
                            SUM(od.UnitPrice * od.Quantity) AS OrderTotal
                        FROM `ORDERS` o
                        JOIN `ORDER_DETAILS` od ON o.OrderID = od.OrderID
                        GROUP BY o.OrderID, o.CustomerID, o.OrderDate
                        ORDER BY o.OrderDate DESC";

        $stmt = $conn->prepare($detailsQuery);
        $stmt->execute();
        $detailsResult = $stmt->get_result();
    }
} catch (mysqli_sql_exception $e) {
    echo "<p class='text-danger'>An error occurred: " . $e->getMessage() . "</p>";
}
?>

<h1>Total Sales Report</h1>

<!-- Date Range Selection Form -->
<form method="post" action="" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <label for="startDate">Start Date (Optional):</label>
            <input type="date" name="startDate" id="startDate" class="form-control" value="<?php echo $startDate ?? ''; ?>">
        </div>
        <div class="col-md-3">
            <label for="endDate">End Date (Optional):</label>
            <input type="date" name="endDate" id="endDate" class="form-control" value="<?php echo $endDate ?? ''; ?>">
        </div>
        <div class="col-md-3">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">Filter by Date</button>
        </div>
        <div class="col-md-3">
            <label>&nbsp;</label>
            <a href="../pages/sales_report.php" class="btn btn-secondary w-100">Clear Filter</a>
        </div>
    </div>
</form>

<?php
if ($totalSales !== null) {
    echo "<h2>Sales Summary</h2>";
    if ($dateRange) {
        echo "<p><strong>Date Range:</strong> $dateRange</p>";
    } else {
        echo "<p><strong>Showing all sales data</strong></p>";
    }
    
    if ($totalSales > 0) {
        echo "<div class='alert alert-success' style='font-size: 1.2em;'>";
        echo "<strong>Total Sales Revenue:</strong> $" . number_format($totalSales, 2);
        echo "</div>";

        echo "<h3>Order Details</h3>";
        echo "<table class='table table-bordered table-striped'>
                <thead class='table-dark'>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Order Date</th>
                        <th>Order Total</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $detailsResult->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['OrderID']) . "</td>
                    <td>" . htmlspecialchars($row['CustomerID']) . "</td>
                    <td>" . htmlspecialchars($row['OrderDate']) . "</td>
                    <td>$" . number_format($row['OrderTotal'], 2) . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='text-warning'>No sales found.</p>";
    }
}
?>

<?php require "../footer.php"; ?>