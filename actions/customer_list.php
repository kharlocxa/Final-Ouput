<?php
require "../config.php"; // Include database connection

$sql = "SELECT * FROM `customers` ORDER BY `CompanyName`, `CustomerID`"; // Fetch data
$result = mysqli_query($conn, $sql);


        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='customer-row' data-id='" . $row['CustomerID'] . "'>";
                echo "<td>" . $row['CustomerID'] . "</td>";
                echo "<td>" . $row['CompanyName'] . "</td>";
                echo "<td>" . $row['ContactName'] . "</td>";
                echo "<td>" . $row['ContactTitle'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No customers found.</td></tr>";
        }
        ?>


<script>
    // Clickable row feature to view customer details
    $(document).ready(function() {
        $(".customer-row").on("click", function() {
            var customerID = $(this).data("id");
            window.location.href = "customer_details.php?id=" + customerID; // Redirect to details page
        });
    });
</script>

<?php $conn->close(); ?>
