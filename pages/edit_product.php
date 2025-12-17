<?php
require "../header.php";

// Fetch product data based on ID
if (isset($_GET['id'])) {
    $productID = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM `products` WHERE `ProductID` = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Product not found.</div>";
        require "../footer.php";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>No product ID provided.</div>";
    require "../footer.php";
    exit;
}

// Handle Update Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $categoryID = $_POST['categoryID'];
    $supplierID = $_POST['supplierID'];
    $quantityPerUnit = $_POST['quantityPerUnit'];
    $unitPrice = $_POST['unitPrice'];
    $unitsInStock = $_POST['unitsInStock'];

    $stmt = $conn->prepare("UPDATE `products` SET `ProductName` = ?, `CategoryID` = ?, `SupplierID` = ?, `QuantityPerUnit` = ?, `UnitPrice` = ?, `UnitsInStock` = ? WHERE `ProductID` = ?");
    $stmt->bind_param("siisdis", $productName, $categoryID, $supplierID, $quantityPerUnit, $unitPrice, $unitsInStock, $productID);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'product.php';</script>";
    } else {
        echo "<script>alert('Error updating product.');</script>";
    }
}
?>

    <div class="pagetitle">
        <h1>Edit Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="product.php">Products</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8 mx-auto"> <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Product Details</h5>

                        <form id="edit-product-form" action="" method="post" onsubmit="return validateForm()" class="row g-3">
                            <input type="hidden" name="productID" value="<?= htmlspecialchars($product['ProductID']); ?>">

                            <div class="col-12">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="productName" value="<?= htmlspecialchars($product['ProductName']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category ID</label>
                                <input type="text" class="form-control" name="categoryID" value="<?= htmlspecialchars($product['CategoryID']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Supplier ID</label>
                                <input type="text" class="form-control" name="supplierID" value="<?= htmlspecialchars($product['SupplierID']); ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Quantity Per Unit</label>
                                <input type="text" class="form-control" name="quantityPerUnit" value="<?= htmlspecialchars($product['QuantityPerUnit']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Unit Price ($)</label>
                                <input type="number" class="form-control" name="unitPrice" step="0.01" value="<?= htmlspecialchars($product['UnitPrice']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Units In Stock</label>
                                <input type="number" class="form-control" name="unitsInStock" value="<?= htmlspecialchars($product['UnitsInStock']); ?>" required>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                                <a href="product.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>

<?php require "../footer.php"; ?>