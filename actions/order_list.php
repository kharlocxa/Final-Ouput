<?php
if (!function_exists('fetchData')) {
    function fetchData($table, $filter = true, $columns = "*") {
        global $conn;
        $data = [];
        $sql = "SELECT $columns FROM $table WHERE $filter";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}

if (!function_exists('fetchSingleData')) {
    function fetchSingleData($table, $column, $filter) {
        global $conn;
        $sql = "SELECT $column FROM $table WHERE $filter";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row[$column];
        }
        return null;
    }
}

// MAIN DISPLAY LOGIC
$customers = fetchData("customers");
?>

<div class="accordion accordion-flush" id="ordersAccordion">

    <?php
    if (!empty($customers)) {
        foreach ($customers as $index => $customer) {
            $companyName = htmlspecialchars($customer['CompanyName']);
            $contactName = htmlspecialchars($customer['ContactName']);
            $customerId = htmlspecialchars($customer['CustomerID']);

            // Create unique IDs for Bootstrap controls based on the loop index or CustomerID
            $headingId = "heading" . $customerId;
            $collapseId = "collapse" . $customerId;

            $orders = fetchData("orders", "CustomerID='$customerId'");
            $orderCount = count($orders);
            ?>

            <div class="accordion-item">
                <h2 class="accordion-header" id="<?= $headingId; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId; ?>" aria-expanded="false" aria-controls="<?= $collapseId; ?>">

                        <div class="container-fluid p-0">
                            <div class="row align-items-center">

                                <div class="col-8 text-truncate">
                                    <strong><?= $companyName; ?></strong>
                                    <span class="text-muted small ms-2">(<?= $contactName; ?>)</span>
                                </div>

                                <div class="col-4 text-end" style="padding-right: 500px;">
                                    <?php if($orderCount > 0): ?>
                                        <span class="badge bg-primary rounded-pill"><?= $orderCount; ?> Orders</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill">0</span>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                    </button>
                </h2>
                <div id="<?= $collapseId; ?>" class="accordion-collapse collapse" aria-labelledby="<?= $headingId; ?>" data-bs-parent="#ordersAccordion">
                    <div class="accordion-body">

                        <?php if (!empty($orders)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Ship To</th>
                                        <th>City</th>
                                        <th>Total</th>
                                        <th>Items</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($orders as $order):
                                        $orderId = htmlspecialchars($order['OrderID']);
                                        $orderDate = date("M d, Y", strtotime($order['OrderDate']));
                                        $shipName = htmlspecialchars($order['ShipName']);
                                        $shipCity = htmlspecialchars($order['ShipCity']);
                                        $orderDetails = fetchData("order_details", "OrderID='$orderId'");

                                        // Calculate Total and build inner table rows
                                        $total = 0;
                                        $detailsRows = "";

                                        foreach ($orderDetails as $detail) {
                                            $unitPrice = $detail['UnitPrice'];
                                            $quantity = $detail['Quantity'];
                                            $productId = $detail['ProductID'];
                                            $productName = fetchSingleData("products", "ProductName", "ProductID='$productId'");

                                            $subtotal = $unitPrice * $quantity;
                                            $total += $subtotal;

                                            $detailsRows .= "<tr>
                                            <td>$productName</td>
                                            <td>$quantity</td>
                                            <td>$" . number_format($unitPrice, 2) . "</td>
                                            <td>$" . number_format($subtotal, 2) . "</td>
                                        </tr>";
                                        }
                                        ?>
                                        <tr>
                                            <td>#<?= $orderId; ?></td>
                                            <td><?= $orderDate; ?></td>
                                            <td><?= $shipName; ?></td>
                                            <td><?= $shipCity; ?></td>
                                            <td class="fw-bold">$<?= number_format($total, 2); ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" href="#details<?= $orderId; ?>" role="button">
                                                    View Items
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="details<?= $orderId; ?>">
                                            <td colspan="6">
                                                <div class="p-3 border bg-light">
                                                    <h6>Order #<?= $orderId; ?> Details:</h6>
                                                    <table class="table table-sm table-light mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?= $detailsRows; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">No orders found for this customer.</div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        <?php } // End foreach customers
    } else {
        echo "<div class='alert alert-warning'>No customers found.</div>";
    }
    ?>

</div>```