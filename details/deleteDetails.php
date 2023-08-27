<?php

// Get the form data
$detailsid = $_POST['detailsid'];
$patientId = $_POST['patientid'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Debug
echo "Received patientid: " . $detailsid;

// Prepare and bind the update statement
$stmt = $conn->prepare("DELETE FROM details WHERE detailsid=?");
$stmt->bind_param("s", $detailsid);

// Execute the update statement
$stmt->execute();

// Close the statement
$stmt->close();

// Close the connection
$conn->close();

// Redirect to the home page or the updated customer details page
header("Location: patientDetails.php?patientId=" . $patientId.'&startdate=asc');
exit();

?>