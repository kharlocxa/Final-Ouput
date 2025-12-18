<?php
require "../config.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $customerID = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM customers WHERE CustomerID = ?");
    $stmt->bind_param("s", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        echo json_encode($customer);
    } else {
        echo json_encode(["error" => "Customer not found"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["error" => "No customer ID provided"]);
}

$conn->close();
?>