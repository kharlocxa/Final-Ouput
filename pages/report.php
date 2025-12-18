<?php
require "../header.php";

$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;
$dateRange = null;

try {
    // Base query - always fetch all products
    if ($startDate && $endDate) {
        $dateRange = "$startDate to $endDate";
        $inventoryQuery = "SELECT 
                               p.ProductID, 
                               p.ProductName, 
                               p.UnitsInStock, 
                               COALESCE(SUM(od.Quantity), 0) AS TotalOrdered,
                               GREATEST(p.UnitsInStock - COALESCE(SUM(od.Quantity), 0), 0) AS AvailableQuantity
                           FROM `PRODUCTS` p
                           LEFT JOIN `ORDER_DETAILS` od ON p.ProductID = od.ProductID
                           LEFT JOIN `ORDERS` o ON od.OrderID = o.OrderID AND o.OrderDate BETWEEN ? AND ?
                           GROUP BY p.ProductID, p.ProductName, p.UnitsInStock
                           ORDER BY p.ProductID";

        $stmt = $conn->prepare($inventoryQuery);
        $stmt->bind_param("ss", $startDate, $endDate);
    } else {
        // Show all inventory without date filter
        $inventoryQuery = "SELECT 
                               p.ProductID, 
                               p.ProductName, 
                               p.UnitsInStock, 
                               COALESCE(SUM(od.Quantity), 0) AS TotalOrdered,
                               GREATEST(p.UnitsInStock - COALESCE(SUM(od.Quantity), 0), 0) AS AvailableQuantity
                           FROM `PRODUCTS` p
                           LEFT JOIN `ORDER_DETAILS` od ON p.ProductID = od.ProductID
                           GROUP BY p.ProductID, p.ProductName, p.UnitsInStock
                           ORDER BY p.ProductID";

        $stmt = $conn->prepare($inventoryQuery);
    }
    
    $stmt->execute();
    $inventoryResult = $stmt->get_result();
} catch (mysqli_sql_exception $e) {
    echo "<p class='text-danger'>An error occurred: " . $e->getMessage() . "</p>";
    $inventoryResult = null;
}
?>

<h1>Inventory Report</h1>

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
            <a href="../pages/report.php" class="btn btn-secondary w-100">Clear Filter</a>
        </div>
    </div>
</form>

<?php
if ($inventoryResult && $inventoryResult->num_rows > 0) {
    echo "<h2>Inventory Report</h2>";
    if ($dateRange) {
        echo "<p><strong>Date Range:</strong> $dateRange</p>";
    } else {
        echo "<p><strong>Showing all inventory data</strong></p>";
    }
    echo "<table class='table table-bordered table-striped'>
            <thead class='table-dark'>
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
                <td>" . htmlspecialchars($row['ProductID']) . "</td>
                <td>" . htmlspecialchars($row['ProductName']) . "</td>
                <td>" . htmlspecialchars($row['UnitsInStock']) . "</td>
                <td>" . htmlspecialchars($row['TotalOrdered']) . "</td>
                <td>" . htmlspecialchars($row['AvailableQuantity']) . "</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p class='text-warning'>No products found.</p>";
}
?>

<?php require "../footer.php"; ?>