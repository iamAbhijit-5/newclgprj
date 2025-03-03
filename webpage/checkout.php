<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php'; // Ensure database connection

echo "Step 1: File loaded.<br>"; // Debugging step

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Step 2: Form submitted.<br>"; // Debugging step

    $customer_name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $laptop_model = $_POST["laptop-model"] ?? "";
    $quantity = $_POST["quantity"] ?? 0;
    $price = $_POST["price"] ?? 0;
    $total_price = $quantity * $price;

    echo "Step 3: Data received.<br>";
    echo "Customer: $customer_name, Email: $email, Model: $laptop_model, Quantity: $quantity, Price: $price<br>";

    // Check if fields are empty
    if (empty($customer_name) || empty($email) || empty($laptop_model) || $quantity <= 0 || $price <= 0) {
        die("Step 4: Invalid input data!"); // Stop if data is incorrect
    }

    echo "Step 5: Data validated.<br>";

    // Insert bill into database
    $stmt = $conn->prepare("INSERT INTO bills (customer_name, email, laptop_model, quantity, price, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssidd", $customer_name, $email, $laptop_model, $quantity, $price, $total_price);

    if ($stmt->execute()) {
        echo "Step 6: Bill stored successfully!";
    } else {
        echo "Step 6: Error inserting data - " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
