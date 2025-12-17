<?php
require "../header.php";
?>

<h1>Reports</h1>

<!-- Date Range Selection Form -->
<form method="post" action="../actions/sales_report.php" class="mb-4">
    <div class="form-group">
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" id="startDate" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" id="endDate" class="form-control" required>
    </div>
    <button type="submit" name="generateReport" class="btn btn-primary mt-3">Generate Report</button>
</form>

<!-- Product List Table -->
<h2>Product List</h2>
<table id="product" class="container-fluid table table-striped table-hover">
    <thead>
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Units In Stock</th>
        <th>Total Ordered</th>
        <th>Available Quantity</th>
    </tr>
    </thead>
    <tbody class="table-group-divider" id="productTable">
    <!-- Inventory data will be dynamically loaded -->
    </tbody>
</table>

<script>
    // Optional: Use AJAX to dynamically fetch and display product inventory
    // Example fetch logic (requires a backend endpoint like `fetch_inventory.php`)
    document.addEventListener('DOMContentLoaded', () => {
        fetch('../actions/fetch_inventory.php')
            .then(response => response.json())
            .then(data => {
                const productTable = document.getElementById('productTable');
                productTable.innerHTML = data.map(row => `
                <tr>
                    <td>${row.ProductID}</td>
                    <td>${row.ProductName}</td>
                    <td>${row.UnitsInStock}</td>
                    <td>${row.TotalOrdered}</td>
                    <td>${row.AvailableQuantity}</td>
                </tr>
            `).join('');
            })
            .catch(error => console.error('Error fetching inventory:', error));
    });
</script>