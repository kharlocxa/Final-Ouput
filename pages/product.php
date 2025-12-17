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
