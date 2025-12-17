<?php
require "../header.php";

// Check if a CustomerID is provided
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
        <h1>Customer Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="customer.php">Customers</a></li>
                <li class="breadcrumb-item active">Details</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
        <div class="row">
            <div class="col-xl-8 mx-auto">

                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company Name</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($customer['CompanyName']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Contact Name</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($customer['ContactName']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Title</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($customer['ContactTitle']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?= htmlspecialchars($customer['Address']); ?><br>
                                        <?= htmlspecialchars($customer['City']); ?>, <?= htmlspecialchars($customer['Region']); ?> <?= htmlspecialchars($customer['PostalCode']); ?><br>
                                        <?= htmlspecialchars($customer['Country']); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($customer['Phone']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Fax</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($customer['Fax']); ?></div>
                                </div>

                                <div class="text-center mt-4">
                                    <a href="edit_customer.php?id=<?= $customer['CustomerID']; ?>" class="btn btn-primary">Edit Customer</a>
                                    <a href="customer.php" class="btn btn-secondary">Back to List</a>
                                </div>

                            </div>
                        </div></div>
                </div>

            </div>
        </div>
    </section>

<?php require "../footer.php"; ?>