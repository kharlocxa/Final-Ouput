<?php
require "../header.php";
?>
<h1>Customer</h1>

<table id="customer" class="container-fluid table table-striped table-hover">
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>Company Name</th>
            <th>Contact Name</th>
            <th>Contact Title</th>
            <th>Phone</th>
            <th>Country</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-group-divider" id="customerTable">
    <!-- Data will be loaded dynamically -->
    </tbody>
</table>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm">
                    <input type="hidden" id="modal_customerID" name="customerID">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modal_companyName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="modal_companyName" name="companyName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_contactName" class="form-label">Contact Name</label>
                            <input type="text" class="form-control" id="modal_contactName" name="contactName" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modal_contactTitle" class="form-label">Contact Title</label>
                            <input type="text" class="form-control" id="modal_contactTitle" name="contactTitle">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="modal_phone" name="phone">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="modal_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="modal_address" name="address">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="modal_city" class="form-label">City</label>
                            <input type="text" class="form-control" id="modal_city" name="city">
                        </div>
                        <div class="col-md-4">
                            <label for="modal_region" class="form-label">Region</label>
                            <input type="text" class="form-control" id="modal_region" name="region">
                        </div>
                        <div class="col-md-4">
                            <label for="modal_postalCode" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="modal_postalCode" name="postalCode">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modal_country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="modal_country" name="country">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_fax" class="form-label">Fax</label>
                            <input type="text" class="form-control" id="modal_fax" name="fax">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<?php require "../footer.php"; ?>