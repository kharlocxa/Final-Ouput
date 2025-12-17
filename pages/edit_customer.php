<?php
require "../header.php";

// Fetch customer data based on ID
if (isset($_GET['id'])) {
    $customerID = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM `customers` WHERE `CustomerID` = ?");
    $stmt->bind_param("s", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Customer not found.</div>";
        require "../footer.php";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>No customer ID provided.</div>";
    require "../footer.php";
    exit;
}
?>

    <div class="pagetitle">
        <h1>Edit Customer</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="customer.php">Customers</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer Information</h5>

                        <form id="edit-customer-form" action="../actions/update_customer.php" method="post" class="row g-3">
                            <input type="hidden" name="customerID" value="<?= htmlspecialchars($customer['CustomerID']); ?>">

                            <div class="col-md-6">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" name="companyName" value="<?= htmlspecialchars($customer['CompanyName']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact Name</label>
                                <input type="text" class="form-control" name="contactName" value="<?= htmlspecialchars($customer['ContactName']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact Title</label>
                                <input type="text" class="form-control" name="contactTitle" value="<?= htmlspecialchars($customer['ContactTitle']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($customer['Phone']); ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($customer['Address']); ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($customer['City']); ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Region</label>
                                <input type="text" class="form-control" name="region" value="<?= htmlspecialchars($customer['Region']); ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="postalCode" value="<?= htmlspecialchars($customer['PostalCode']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" value="<?= htmlspecialchars($customer['Country']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fax</label>
                                <input type="text" class="form-control" name="fax" value="<?= htmlspecialchars($customer['Fax']); ?>">
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="customer.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form></div>
                </div>

            </div>
        </div>
    </section>

<?php require "../footer.php"; ?>