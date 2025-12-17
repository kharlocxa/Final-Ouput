<?php
require "../header.php";
?>

    <div class="pagetitle">
        <h1>Order Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer Orders</h5>

                        <?php include "../actions/order_list.php"; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>

<?php
require "../footer.php";
?>s