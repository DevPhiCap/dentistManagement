<?php

// Get the form data
$name = $_POST['name'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$schedule = $_POST['schedule'];
$patientid = $_POST['patientid'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind the update statement
$stmt = $conn->prepare("UPDATE benhnhan SET name=?, age=?, phoneno=?, address=?, schedule=? WHERE patientid=?");
$stmt->bind_param("ssssss", $name, $age, $phone, $address, $schedule, $patientid);

// Execute the update statement
$stmt->execute();

// Close the statement
$stmt->close();

// Close the connection
$conn->close();

// Redirect to the home page or the updated customer details page
header("Location: customerTable.php");
exit();

?>