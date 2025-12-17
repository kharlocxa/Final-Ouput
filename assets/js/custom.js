$(document).ready(function() {
    let tableID = $('table').attr('id');

    $(`#${tableID} tbody`).load(`../actions/${tableID}_list.php`);

    $('#nav a').on('click', function() {
        let page = $(this).text().toLowerCase();
        $('#' + tableID + ' tbody').load('../actions/' + page + '_list.php');
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
    $(document).on("click", ".customer-row", function() {
        var customerID = $(this).data("id");

        if(customerID) {
            window.location.href = "edit_customer.php?id=" + customerID;
        }
    })

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
        const searchUrl = `../actions/customer_search.php?search=${encodeURIComponent(query)}`;
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