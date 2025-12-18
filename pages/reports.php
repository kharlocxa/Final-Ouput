<?php
require "../header.php";
?>

<h1>Reports</h1>

<div class="row mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Sales Report</h5>
                <p class="card-text">View total sales revenue for a selected date range. See all orders and their totals.</p>
                <a href="../pages/sales_report.php" class="btn btn-primary">Generate Sales Report</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Inventory Report</h5>
                <p class="card-text">View all products in inventory with available quantities calculated based on orders.</p>
                <a href="../pages/report.php" class="btn btn-primary">Generate Inventory Report</a>
            </div>
        </div>
    </div>
</div>

<?php require "../footer.php"; ?>