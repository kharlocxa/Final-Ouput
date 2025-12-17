<?php
require "../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerID = $_POST["customerID"];
    $companyName = $_POST["companyName"];
    $contactName = $_POST["contactName"];
    $contactTitle = $_POST["contactTitle"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $region = $_POST["region"];
    $postalCode = $_POST["postalCode"];
    $country = $_POST["country"];
    $phone = $_POST["phone"];
    $fax = $_POST["fax"];

    // Use a prepared statement to update the customer
    $stmt = $conn->prepare("UPDATE customers SET 
        CompanyName = ?, ContactName = ?, ContactTitle = ?, Address = ?, City = ?, 
        Region = ?, PostalCode = ?, Country = ?, Phone = ?, Fax = ? WHERE CustomerID = ?");
    $stmt->bind_param(
        "sssssssssss",
        $companyName, $contactName, $contactTitle, $address, $city,
        $region, $postalCode, $country, $phone, $fax, $customerID
    );

    if ($stmt->execute()) {
        echo "<script>
        alert('Updated successfully!');
        window.location.href = '../pages/customer_details.php?id=$customerID';
    </script>";    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
