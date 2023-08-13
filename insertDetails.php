<?php
// Get the form data
$mota = $_POST['mota'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$patientId = $_GET['patientId'];
$befimg = $_FILES['befimg']['name'];
$aftimg = $_FILES['aftimg']['name'];

// Set the default value for startdate as today's date
if ($startdate == null) {
    $startdate = date("d-m-Y");
}
if ($enddate == null) {
    $enddate = 'chua co';
}

// Function to handle file upload and generate image URL
function handleFileUpload($fileInputName) {
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
    return "";
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the insert statement
$sql = "INSERT INTO details (mota, startdate, enddate, befimg, aftimg, status, patientid) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Generate image URLs and bind the parameters
$befimgUrl = handleFileUpload("befimg");
$aftimgUrl = handleFileUpload("aftimg");
$status = ($enddate == 'chua co') ? "chua hoan thien" : "da hoan thanh";

// Check if the file upload failed for befimg or aftimg
if ($befimgUrl === null || $aftimgUrl === null) {
    // Handle the error case, e.g., display an error message to the user
    echo "File upload failed.";
    exit();
}

// Bind the parameters
$stmt->bind_param("sssssss", $mota, $startdate, $enddate, $befimgUrl, $aftimgUrl, $status, $patientId);
$stmt->execute();

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to the home page
header("Location: patientDetails.php?patientId=" . $patientId);
exit();
?>