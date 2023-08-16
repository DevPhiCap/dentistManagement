<?php
// Get the form data
$detailsid = $_POST['detailsid'];
$mota = $_POST['mota'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$befimg = $_FILES['befimg']['name'];
$aftimg = $_FILES['aftimg']['name'];

$patientId = $_GET['patientId'];

// Function to handle file upload and generate image URL
function handleFileUpload($fileInputName){
    $targetDirectory = "uploaded_img/"; // Directory to save the uploaded images
    $targetFile = $targetDirectory . basename($_FILES[$fileInputName]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if a file was uploaded and it is an actual image
    if (!empty($_FILES[$fileInputName]["tmp_name"]) && getimagesize($_FILES[$fileInputName]["tmp_name"]) !== false) {
        // Move the uploaded file to the target directory
        move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile);

        // Return the generated image URL
        return $targetFile;
    }

    // Return an empty string if the file is not an image or no file was uploaded
    return null;
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the update statement
$sql = "UPDATE details SET mota = ?, startdate = ?, enddate = ?, befimg = ?, aftimg = ? WHERE detailsid = ?";
$stmt = $conn->prepare($sql);

// Generate image URLs and bind the parameters
$befimgUrl = handleFileUpload("befimg");
$aftimgUrl = handleFileUpload("aftimg");


// Bind the parameters
$stmt->bind_param("ssssss", $mota, $startdate, $enddate, $befimgUrl, $aftimgUrl, $detailsid);
$stmt->execute();

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to the patient details page
header("Location: patientDetails.php?patientId=" . $patientId);
exit();
?>