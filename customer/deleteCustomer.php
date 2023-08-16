<?php

// Get the form data
$patientid = $_POST['patientid'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Debug
echo "Received patientid: " . $patientid;

// Prepare and bind the update statement
$stmt = $conn->prepare("DELETE FROM benhnhan WHERE patientid=?");
$stmt->bind_param("s", $patientid);

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