$(document).ready(function() {
    let tableID = $('table').attr('id');
    console.log("Table ID:", tableID);

    $(`#${tableID} tbody`).load(`/IT424/Finals/actions/${tableID}_list.php`);

    $('#nav a').on('click', function() {
        let page = $(this).text().toLowerCase();
        $('#' + tableID + ' tbody').load(`/IT424/Finals/actions/${page}_list.php`);
    });

    $(document).on("click", "tr.customer-row", function(e) {
        console.log("Customer row clicked! Event:", e);
        console.log("This element:", this);
        console.log("Data ID:", $(this).data("id"));
    });

    setTimeout(function() {
        console.log("Checking for customer rows...");
        console.log("Number of .editCustomerBtn elements:", $('.editCustomerBtn').length);
        console.log("Number of .customer-row elements:", $('.customer-row').length);
        console.log("First few customer rows:", $('.customer-row').slice(0, 3));
    }, 500);

    $(`#${tableID} tbody`).load(`/IT424/Finals/actions/${tableID}_list.php`, function() {
        console.log("Table loaded! Checking for rows again...");
        console.log("Number of .editCustomerBtn elements:", $('.editCustomerBtn').length);
        console.log("Number of .customer-row elements:", $('.customer-row').length);
    });

    $(document).on("click", function(e) {
        if ($(e.target).closest(".editCustomerBtn").length) {
            console.log("!!! EDIT BUTTON CLICK DETECTED !!!");
        }
    });

    $(".product-row").on("click", function() {
        var productID = $(this).data("id");
        window.location.href = "product_details.php?id=" + productID;
    });

    $(document).on("click", ".editBtn", function() {
        $("#customerDetails").hide();
        $("#customerForm").show();

        var customerID = $(this).data("id");
        console.log("Editing customer: " + customerID);
    });
    
    // Handle clicking on customer row to open modal
    $(document).on("click", ".customer-row", function() {
        var customerID = $(this).data("id");
        if(customerID) {
            // Trigger the edit button click to open modal
            $(this).find('.editCustomerBtn').trigger('click');
        }
    });

$(document).on("click", ".editCustomerBtn", function(e) {
        console.log("=== EDIT BUTTON CLICKED ===");
        e.stopPropagation();
        var customerID = $(this).data("id");
        
        console.log("Edit button clicked for customer:", customerID);
        console.log("Button element:", this);
        
        if (!customerID) {
            console.error("ERROR: No customer ID found!");
            alert("Error: Could not get customer ID");
            return;
        }
        
        console.log("Fetching from URL: /IT424/Finals/actions/get_customer.php?id=" + customerID);
        
        // Fetch customer data
        $.ajax({
            url: '/IT424/Finals/actions/get_customer.php',
            method: 'GET',
            data: { id: customerID },
            dataType: 'json',
            success: function(customer) {
                console.log("=== AJAX SUCCESS ===");
                console.log("Customer data received:", customer);
                
                if (customer.error) {
                    console.error("Server returned error:", customer.error);
                    alert('Error: ' + customer.error);
                    return;
                }
                
                console.log("Populating form fields...");
                $('#modal_customerID').val(customer.CustomerID);
                $('#modal_companyName').val(customer.CompanyName);
                $('#modal_contactName').val(customer.ContactName);
                $('#modal_contactTitle').val(customer.ContactTitle || '');
                $('#modal_phone').val(customer.Phone || '');
                $('#modal_address').val(customer.Address || '');
                $('#modal_city').val(customer.City || '');
                $('#modal_region').val(customer.Region || '');
                $('#modal_postalCode').val(customer.PostalCode || '');
                $('#modal_country').val(customer.Country || '');
                $('#modal_fax').val(customer.Fax || '');
                
                console.log("Form fields populated. Showing modal...");
                console.log("Modal element:", $('#editCustomerModal'));
                
                $('#editCustomerModal').modal('show');
                console.log("Modal show command executed");
            },
            error: function(xhr, status, error) {
                console.error('=== AJAX ERROR ===');
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                console.error('Full XHR object:', xhr);
                alert('Error loading customer data: ' + error);
            }
        });
    });

    // Handle save button click
    $('#saveCustomerBtn').on('click', function() {
        var formData = $('#editCustomerForm').serialize();
        
        $.ajax({
            url: '/IT424/Finals/actions/update_customer.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Customer updated successfully!');
                    $('#editCustomerModal').modal('hide');
                    $('#customerTable').load('/IT424/Finals/actions/customer_list.php');
                } else {
                    alert('Error updating customer: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Response:', xhr.responseText);
                alert('Error updating customer');
            }
        });
    });

    $("#cancelBtn").on("click", function() {
        $("#customerForm").hide();
        $("#customerDetails").show();
    });

    const fetchProducts = (query = '') => {
        const searchUrl = `../actions/product_search.php?search=${encodeURIComponent(query)}`;

        $.ajax({
            url: searchUrl,
            method: 'GET',
            success: function (data) {
                $('#productTable').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching products:', error);
                $('#productTable').html('<tr><td colspan="8">Error loading products.</td></tr>');
            }
        });
    };
    
    const fetchCustomers = (query = '') => {
        const searchUrl = `/IT424/Finals/actions/customer_search.php?search=${encodeURIComponent(query)}`;
        $.ajax({
            url: searchUrl,
            method: 'GET',
            success: function (data) {
                $('#customerTable').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching customers:', error);
                $('#customerTable').html('<tr><td colspan="8">Error loading customers.</td></tr>');
            }
        });
    };

    $('#searchForm').on('submit', function (event) {
        event.preventDefault();
        const query = $('#searchInput').val();
        fetchCustomers(query)
        fetchProducts(query)
    });

    $('#edit-product-form').submit(function(event) {
        var unitPrice = $('input[name="unitPrice"]').val();
        var unitsInStock = $('input[name="unitsInStock"]').val();
        var categoryID = $('input[name="categoryID"]').val();
        var supplierID = $('input[name="supplierID"]').val();

        if (unitPrice <= 0) {
            alert("Unit Price must be greater than zero.");
            event.preventDefault();
            return false;
        }

        if (unitsInStock < 0) {
            alert("Units In Stock cannot be negative.");
            event.preventDefault();
            return false;
        }

        if (!categoryID || !supplierID) {
            alert("Please enter valid Category and Supplier IDs.");
            event.preventDefault();
            return false;
        }

        return true;
    });
});

// ========== PRODUCT MODAL HANDLERS ==========
    
    // Handle edit button click to open modal
    $(document).on("click", ".editProductBtn", function(e) {
        e.stopPropagation();
        var productID = $(this).data("id");
        
        console.log("Edit button clicked for product:", productID);
        
        if (!productID) {
            console.error("ERROR: No product ID found!");
            alert("Error: Could not get product ID");
            return;
        }
        
        // Fetch product data
        $.ajax({
            url: '/IT424/Finals/actions/get_product.php',
            method: 'GET',
            data: { id: productID },
            dataType: 'json',
            success: function(product) {
                console.log("Product data loaded:", product);
                
                if (product.error) {
                    console.error("Server error:", product.error);
                    alert('Error: ' + product.error);
                    return;
                }
                
                $('#modal_productID').val(product.ProductID);
                $('#modal_productName').val(product.ProductName);
                $('#modal_categoryID').val(product.CategoryID);
                $('#modal_supplierID').val(product.SupplierID);
                $('#modal_quantityPerUnit').val(product.QuantityPerUnit || '');
                $('#modal_unitPrice').val(product.UnitPrice || '');
                $('#modal_unitsInStock').val(product.UnitsInStock || '');
                $('#modal_unitsOnOrder').val(product.UnitsOnOrder || '');
                
                $('#editProductModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error loading product:', error);
                console.error('Response:', xhr.responseText);
                alert('Error loading product data');
            }
        });
    });

    // Handle save button click
    $('#saveProductBtn').on('click', function() {
        var formData = $('#editProductForm').serialize();
        
        $.ajax({
            url: '/IT424/Finals/actions/update_product.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Product updated successfully!');
                    $('#editProductModal').modal('hide');
                    $('#productTable').load('/IT424/Finals/actions/product_list.php');
                } else {
                    alert('Error updating product: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Response:', xhr.responseText);
                alert('Error updating product');
            }
        });
    });