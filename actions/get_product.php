<?php
require "../config.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $productID = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE ProductID = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["error" => "No product ID provided"]);
}

$conn->close();
?>