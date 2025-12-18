<?php
require "../header.php";
?>
<h1>Product</h1>

<table id="product" class="container-fluid table table-striped table-hover">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Quantity Per Unit</th>
            <th>Unit Price</th>
            <th>Units In Stock</th>
            <th>Units On Order</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-group-divider" id="productTable">
        <!-- Data will be loaded dynamically -->
    </tbody>
</table>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <input type="hidden" id="modal_productID" name="productID">
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="modal_productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="modal_productName" name="productName" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modal_categoryID" class="form-label">Category ID</label>
                            <input type="number" class="form-control" id="modal_categoryID" name="categoryID" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_supplierID" class="form-label">Supplier ID</label>
                            <input type="number" class="form-control" id="modal_supplierID" name="supplierID" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="modal_quantityPerUnit" class="form-label">Quantity Per Unit</label>
                            <input type="text" class="form-control" id="modal_quantityPerUnit" name="quantityPerUnit" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modal_unitPrice" class="form-label">Unit Price ($)</label>
                            <input type="number" class="form-control" id="modal_unitPrice" name="unitPrice" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_unitsInStock" class="form-label">Units In Stock</label>
                            <input type="number" class="form-control" id="modal_unitsInStock" name="unitsInStock" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="modal_unitsOnOrder" class="form-label">Units On Order</label>
                            <input type="number" class="form-control" id="modal_unitsOnOrder" name="unitsOnOrder">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveProductBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<?php require "../footer.php"; ?>