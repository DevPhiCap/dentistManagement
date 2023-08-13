<?php

// Get the form data
$name = $_POST['name'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare the insert statement
$sql = "INSERT INTO benhnhan (name, age, phoneno, address) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("ssss", $name, $age, $phone, $address);

// Execute the statement
$stmt->execute();

// Close the statement
$stmt->close();

// Close the connection
$conn->close();

// Redirect to the home page
header("Location: customerTable.php");

?>

