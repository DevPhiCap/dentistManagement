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

try {
  // Delete records from the details table first
  $stmt = $conn->prepare("DELETE FROM details WHERE patientid=?");
  $stmt->bind_param("s", $patientid);
  $stmt->execute();
  $stmt->close();

  // Commit the transaction
  $conn->commit();

  echo "Record deleted successfully.";
} catch (Exception $e) {
  // Rollback the transaction if an error occurred
  $conn->rollback();

  echo "Failed to delete the record: " . $e->getMessage();
}

// Close the connection
$conn->close();

// Redirect to the home page or the updated customer details page
header("Location: customerTable.php");
exit();

?>